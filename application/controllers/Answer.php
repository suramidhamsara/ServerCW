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
			redirect('login');
		}

		$this->load->model('Answer_model');

		$answer_id = $this->input->post('answer_id');
		$question_id = $this->input->post('question_id');

		// Mark the answer as correct
		$this->Answer_model->mark_as_correct($answer_id, $question_id, $this->session->userdata('user_id'));
		redirect('question/view/' . $question_id);
		log_message('debug', 'Answer marked as correct');
	}

	public function delete_answer()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('home');
		}
		$this->load->model('Answer_model');
		$this->load->model('Question_model');

		$answer_id = $this->input->post('answer_id');
		$question_id = $this->input->post('question_id');

		$this->db->where('answer_id', $answer_id);
		$this->db->delete('votes');

		$this->db->where('id', $answer_id);
		$this->db->delete('answers');
		$this->Question_model->unsolved_questions($question_id);
		log_message('debug', 'Answer deleted');

		redirect('profile');
	}

	public function set_previous_url()
	{
		$this->session->set_userdata('previous_url', current_url());
	}
}

