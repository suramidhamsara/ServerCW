<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vote extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	}
	public function vote_answer()
	{
		if (!$this->session->userdata('user_id')) {
			$this->set_previous_url();
			// If the user is not logged in, redirect to the home page
			redirect('login');
		} else {
			// Load the Vote_model
			$this->load->model('Vote_model');

			// Get user id from session
			$user_id = $this->session->userdata('user_id');

			$question_id = $this->uri->segment(2);
			$answer_id = $this->uri->segment(4);
			$vote_type = $this->uri->segment(6);

			// Vote the answer
			$vote_result = $this->Vote_model->vote_answer($answer_id, $user_id, $vote_type);

			// Redirect the user to the question page
			redirect('question/view/' . $question_id);

		}
	}

	public function set_previous_url()
	{
		$this->session->set_userdata('previous_url', current_url());
	}

}


/* End of file Vote.php and path \application\controllers\Vote.php */
