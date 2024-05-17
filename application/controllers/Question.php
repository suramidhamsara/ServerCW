<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Question extends CI_Controller
{
	protected $data = [];
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->data['user_id'] = $this->session->userdata('user_id');
		$this->data['username'] = $this->session->userdata('username');
		$this->load->helper('url');
		$this->load->model('Question_model');
		$this->load->helper('date');
		date_default_timezone_set('Asia/Colombo');
		$this->data['showForm'] = false;
	}



	public function show_answer_form($question_id)
	{
		// Check if the user is logged in
		if (!$this->session->userdata('user_id')) {
			// Redirect the user to the login page
			$this->set_previous_url();
			redirect('login');
		}

		$this->data['question_id'] = $question_id;

		$question = $this->Question_model->get_question($question_id);
		$this->data['question'] = $question;


		$this->data['showForm'] = true;
		$this->load->view('question', $this->data);
	}

	public function answer_question($question_id)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('answer', 'Answer', 'required');

		$answer = $this->input->post('answer');

		if ($this->form_validation->run() == FALSE) {
			$this->show_answer_form($question_id);
		} else {
			$this->load->model('Answer_model');

			$user_id = $this->session->userdata('user_id');

			$this->Answer_model->answer_question($answer, $question_id, $user_id);

			redirect('question/view/' . $question_id);
		}
	}

	public function view_question($id)
	{

		$question = $this->Question_model->get_question($id);
		$this->data['question'] = $question;

		$this->load->view('question', $this->data);
	}

	public function mark_as_solved()
	{

		if (!$this->session->userdata('user_id')) {
			// If the user is not logged in, redirect to the home page
			redirect('home');
		}
		// Load the Question_model
		$this->load->model('Question_model');

		// Get question id from post data
		$question_id = $this->input->post('question_id');

		// Mark the question as solved
		$this->Question_model->mark_as_solved($question_id);
	}

	public function delete_question()
	{
		if (!$this->session->userdata('user_id')) {
			// If the user is not logged in, redirect to the home page
			redirect('home');
		}
		// Load the Question_model
		$this->load->model('Question_model');

		// Get question id from post data
		$question_id = $this->input->post('question_id');

		// Delete the question
		$this->Question_model->delete_question($question_id);
	}

	public function set_previous_url()
	{
		$this->session->set_userdata('previous_url', current_url());
	}
}
