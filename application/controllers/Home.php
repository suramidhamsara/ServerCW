<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	protected $data = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->model('Question_model');
		date_default_timezone_set('Asia/Colombo');
		$this->data['user_id'] = $this->session->userdata('user_id');
		$this->data['username'] = $this->session->userdata('username');
		$this->data['title'] = 'Home';
		$this->data['questions'] = $this->Question_model->get_questions();

	}

	public function index()
	{

		// Don't show the form initially
		$this->data['isShowForm'] = false;

		// Load the home view and pass the list of questions to it
		$this->load->view('home', $this->data);
	}

	public function show_ask_form()
	{
		// Check if the user is logged in
		if (!$this->session->userdata('user_id')) {
			// Redirect the user to the login page
			redirect('user/login');
		}

		$this->load->library('form_validation');


		// Get the list of questions


		$this->data['isShowForm'] = true;
		$this->load->view('home', $this->data);
	}

	public function ask_question()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');

		// Get the question title and description
		$title = $this->input->post('title');
		$description = $this->input->post('description');


		if ($this->form_validation->run() == FALSE) {
			$this->show_ask_form();
		} else {
			// Get the user id
			$user_id = $this->session->userdata('user_id');

			// Insert the question into the database
			$this->Question_model->ask_question($title, $description, $user_id);

			// Redirect the user to the home page
			redirect('home');
		}

	}

}

/* End of file Home.php and path \application\controllers\Home.php */
