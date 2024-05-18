<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
	protected $data = [];
	protected $questions = [];

	protected $updated_questions = [];
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Colombo');
		$this->data['user_id'] = $this->session->userdata('user_id');
		$this->data['username'] = $this->session->userdata('username');
		$this->data['title'] = 'Home';
		$this->questions = $this->Question_model->get_questions();
		$this->data['questions'] = $this->questions;
		$this->data['showForm'] = false;
		$this->data['isAskQueBtn'] = true;
		foreach ($this->questions as $question) {
			$answer_count = $this->Question_model->get_answer_count($question['id']);
			$question['answer_count'] = $answer_count;
			$question['time_span'] = strtolower(timespan(strtotime($question['date_asked']), time(), 2));
			$this->updated_questions[] = $question;
		}
		$this->data['questions'] = $this->updated_questions;
	}
	public function index()
	{

		log_message('debug', 'Home page loading');
		$this->load->view('home', $this->data);
		log_message('debug', 'Home page loaded');
	}

	public function show_ask_form()
	{
		log_message('debug', 'show_ask_form() called');
		if (!$this->session->userdata('user_id')) {
			$this->set_previous_url();
			redirect('login');
		}
		$this->data['showForm'] = true;
		$this->data['isAskQueBtn'] = false;
		log_message('debug', 'Ask form loaded');
		$this->load->view('home', $this->data);
		log_message('debug', 'Ask form loaded');
	}
	public function ask_question()
	{
		log_message('debug', 'ask_question() called');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		if ($this->form_validation->run() == FALSE) {
			$this->show_ask_form();
		} else {
			$user_id = $this->session->userdata('user_id');
			$this->Question_model->ask_question($title, $description, $user_id);
			$this->data['showForm'] = false;
			$this->data['isAskQueBtn'] = true;
			log_message('debug', 'Question Added');
			redirect('home');
		}
	}
	public function search()
	{
		log_message('debug', 'search() called');
		$search = trim($this->input->get('search'));
		if (empty($search)) {
			redirect('home');
		} else {
			$search_words = explode(' ', $search);
			$filtered_questions = [];
			foreach ($search_words as $word) {
				$filtered = array_filter($this->questions, function ($question) use ($word) {
					return strpos(strtolower($question['title']), strtolower($word)) !== false;
				});
				$filtered_questions = array_merge($filtered_questions, $filtered);
			}
			$filtered_questions = array_unique($filtered_questions, SORT_REGULAR);
			usort($filtered_questions, function ($a, $b) {
				return strtotime($b['date_asked']) - strtotime($a['date_asked']);
				log_message('debug', 'Search results sorted');
			});

			$updated_questions = [];
			foreach ($filtered_questions as $question) {
				$answer_count = $this->Question_model->get_answer_count($question['id']);
				$question['answer_count'] = $answer_count;
				$question['time_span'] = strtolower(timespan(strtotime($question['date_asked']), time(), 2));
				$updated_questions[] = $question;
			}

			$this->data['questions'] = $updated_questions;
			log_message('debug', 'Search results loaded');
			$this->load->view('home', $this->data);
		}
	}
	public function set_previous_url()
	{
		$this->session->set_userdata('previous_url', current_url());
	}

	public function hide_ask_que_btn()
	{
		$this->data['isAskQueBtn'] = true;
		$this->load->view('home', $this->data);
	} 
}
