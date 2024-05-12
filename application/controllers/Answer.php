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





	public function answer_question()
	{
		if (!$this->session->userdata('user_id')) {
			// If the user is not logged in, redirect to the home page
			redirect('home');
		}
		// Load the Answer_model
		$this->load->model('Answer_model');

		// Get user input
		$answer = $this->input->post('answer');
		$question_id = $this->input->post('question_id');

		// Get user id from session
		$user_id = $this->session->userdata('user_id');

		// Answer the question
		$this->Answer_model->answer_question($answer, $question_id, $user_id);
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

		// Delete the answer
		$this->Answer_model->delete_answer($answer_id);
	}
}
/* End of file Answer.php and path \application\controllers\Answer.php */
