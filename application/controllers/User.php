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

		$this->data['title'] = 'Register';
		// Check if the form was submitted
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			// Get user input
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$email = $this->input->post('email');

			// Register the user
			$registered = $this->User_model->register($username, $password, $email);
			if ($registered) {
				// If the user was registered successfully, redirect to the login page
				redirect('user/login');
			} else {
				// If the user registration failed, load the registration view
				$this->load->view('register');
			}

		} else {
			// If the form wasn't submitted, load the registration view
			$this->load->view('register', $this->data);
		}
	}

	public function login()
	{

		$this->data['title'] = 'Login';

		// Get user input
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		// Login the user
		$user = $this->User_model->login($username, $password);

		if ($user) {

			// Set the user's session data
			$this->session->set_userdata('user_id', $user->id);
			$this->session->set_userdata('username', $user->username);
			// Redirect to home page
			redirect('home');
		} else {
			// User login failed
			// Load the login view
			$this->load->view('login', $this->data);
		}
	}

	public function logout()
	{

		if (!$this->session->userdata('user_id')) {
			// If the user is not logged in, redirect to the home page
			redirect('home');
		}
		// Destroy the user's session
		$this->session->sess_destroy();

		// Redirect to the login page
		redirect('home');
	}

	public function delete_account()
	{
		// Get user id from session
		$user_id = $this->session->userdata('user_id');

		// Delete the user account
		$this->User_model->delete_account($user_id);
	}

	public function profile()
	{
		$this->data['title'] = 'Profile';

		if (!$this->session->userdata('user_id')) {
			// If the user is not logged in, redirect to the home page
			redirect('home');
		}
		$this->load->model('Question_model');
		$this->load->model('Answer_model');
		$this->load->model('Vote_model');

		$questions = $this->Question_model->get_questions_by_user($this->user['id']);
		$this->data['questions'] = $questions;
		$this->data['answers'] = $this->Answer_model->get_answers_by_user($this->user['id']);
		$correct_answers = $this->Answer_model->get_correct_answers_by_user($this->user['id']);
		$this->data['total_votes'] = $this->Vote_model->get_total_votes_by_user($this->user['id']);

		$this->data['num_questions'] = count($questions);
		$this->data['num_correct_answers'] = count($correct_answers);

		// Load the profile view and pass the user data to it
		$this->load->view('profile', $this->data);

	}



}
