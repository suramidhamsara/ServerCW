<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MainPage extends CI_Controller
{

	protected $data = [];
	protected $questions = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('date');
		date_default_timezone_set('Asia/Colombo');
		$this->data['user_id'] = $this->session->userdata('user_id');
		$this->data['username'] = $this->session->userdata('username');
		$this->data['title'] = 'MainPage';
		$this->data['showForm'] = false;
	}

	public function index()
	{
		$this->load->view('mainPage', $this->data);
		log_message('debug', 'MainPage loaded');
	}

}
