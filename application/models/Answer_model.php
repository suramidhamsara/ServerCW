<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Answer_model extends CI_Model
{
	public function answer_question($answer, $question_id, $user_id)
	{
		$data = array(
			'answer' => $answer,
			'question_id' => $question_id,
			'user_id' => $user_id
		);
		return $this->db->insert('answers', $data);
	}


	public function get_answers_by_user($user_id)
	{
		$this->db->select('answers.*, questions.title as question_title');
		$this->db->from('answers');
		$this->db->join('questions', 'answers.question_id = questions.id');
		$this->db->where('answers.user_id', $user_id);
		$result = $this->db->get()->result_array();

		if ($result === null) {
			return null;
		}
		return $result;
	}

	public function get_correct_answers_by_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('is_correct', 1); // Only get answers marked as correct
		$query = $this->db->get('answers');
		return $query->result_array();
	}


	public function delete_answer($answer_id)
	{
		$this->db->where('id', $answer_id);
		return $this->db->delete('answers');
	}
}



/* End of file Answer_model.php and path \application\models\Answer_model.php */
