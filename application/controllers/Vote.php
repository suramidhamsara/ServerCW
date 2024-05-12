<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Vote extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}
    public function vote_answer()
    {
		if (!$this->session->userdata('user_id')) {
			// If the user is not logged in, redirect to the home page
			redirect('home');
		}
        // Load the Vote_model
        $this->load->model('Vote_model');

        // Get user input
        $answer_id = $this->input->post('answer_id');
        $vote_type = $this->input->post('vote_type');

        // Get user id from session
        $user_id = $this->session->userdata('user_id');

        // Vote the answer
        $this->Vote_model->vote_answer($answer_id, $user_id, $vote_type);
    }
}


/* End of file Vote.php and path \application\controllers\Vote.php */
