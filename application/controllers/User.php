<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	protected $data = [];
	protected $user;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->model('User_model');
		date_default_timezone_set('Asia/Colombo');
		$user_id = $this->session->userdata('user_id');
		$this->user = $this->User_model->get_user($user_id);
		if ($this->user !== null) {
			$this->data['user_id'] = $user_id;
			$this->data['username'] = $this->user['username'];
			$this->data['email'] = $this->user['email'];
		}

	}

	public function register()
	{
		if ($this->session->userdata('user_id')) {
			redirect('home');
		}

		$this->data['title'] = 'Sign Up';
		// Check if the form was submitted
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$email = $this->input->post('email');

			$registered = $this->User_model->register($username, $password, $email);
			if (isset($registered['success'])) {
				redirect('login');
				log_message('debug', 'User registered successfully');
			} else {
				$this->data['error'] = $registered['error'];
				$this->load->view('register', $this->data);
				log_message('debug', 'User registration failed');
			}

		} else {
			// If the form wasn't submitted, load the registration view
			$this->load->view('register', $this->data);
			log_message('debug', 'Registration page loaded');
		}
	}

	public function login()
	{
		if ($this->session->userdata('user_id')) {
			redirect('home');
		}

		$this->data['title'] = 'Login';
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$user = $this->User_model->login($username, $password);

			if (is_object($user) && !isset($user->error)) {

				$this->session->set_userdata('user_id', $user->id);
				$this->session->set_userdata('username', $user->username);
				log_message('debug', 'User logged in');

				if ($this->session->userdata('previous_url')) {
					redirect($this->session->userdata('previous_url'));
					log_message('debug', 'Redirecting to previous URL');
				} else {
					redirect('home');
				}
			} else {

				$this->data['error'] = $user['error'];
				$this->load->view('login', $this->data);
				log_message('debug', 'User login failed');
			}
		} else {
			$this->load->view('login', $this->data);
			log_message('debug', 'Login page loaded');
		}
	}

	public function logout()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('home');
		}
		// Destroy the user's session
		$this->session->sess_destroy();
		log_message('debug', 'User logged out');
		redirect('home');
	}

	public function profile()
	{
		$this->data['title'] = 'Profile';

		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}
		$this->load->model('Question_model');
		$this->load->model('Answer_model');
		$this->load->model('Vote_model');

		$questions = $this->Question_model->get_questions_by_user($this->user['id']);
		$this->data['questions'] = $questions;
		$this->data['answers'] = $this->Answer_model->get_answers_by_user($this->user['id']);
		$correct_answers = $this->Answer_model->get_correct_answers_by_user($this->user['id']);
		$this->data['total_votes'] = $this->Vote_model->get_user_total_votes($this->user['id']);

		$this->data['num_questions'] = count($questions);
		$this->data['num_correct_answers'] = count($correct_answers);

		// Load the profile view and pass the user data to it
		$this->load->view('profile', $this->data);
		log_message('debug', 'Profile page loaded');

	}
}
