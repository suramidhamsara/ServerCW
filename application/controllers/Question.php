<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends CI_Controller
{

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	}

    public function ask_question()
    {

		if (!$this->session->userdata('user_id')) {
			// If the user is not logged in, redirect to the home page
			redirect('home');
		}
        // Load the Question_model
        $this->load->model('Question_model');

        // Get user input
        $title = $this->input->post('title');
        $description = $this->input->post('description');

        // Get user id from session
        $user_id = $this->session->userdata('user_id');

        // Ask the question
        $this->Question_model->ask_question($title, $description, $user_id);
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
}
/* End of file Question.php and path \application\controllers\Question.php */
