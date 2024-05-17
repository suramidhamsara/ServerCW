<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Answer extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	}

	public function mark_as_correct()
	{
		if (!$this->session->userdata('user_id')) {
			// If the user is not logged in, redirect to the home page
			redirect('login');
		}

		// Load the Answer_model
		$this->load->model('Answer_model');

		// Get answer id from post data
		$answer_id = $this->input->post('answer_id');
		$question_id = $this->input->post('question_id');

		// Mark the answer as correct
		$this->Answer_model->mark_as_correct($answer_id, $question_id, $this->session->userdata('user_id'));
		redirect('question/view/' . $question_id);
	}

	public function delete_answer()
	{
		if (!$this->session->userdata('user_id')) {
			// If the user is not logged in, redirect to the home page
			redirect('home');
		}
		// Load the Answer_model
		$this->load->model('Answer_model');

		// Get answer id from post data
		$answer_id = $this->input->post('answer_id');
		$question_id = $this->input->post('question_id');

		// Delete the answer
		$this->Answer_model->delete_answer($answer_id);
		redirect('question/view/' . $question_id);
	}

	public function set_previous_url()
	{
		$this->session->set_userdata('previous_url', current_url());
	}
}

