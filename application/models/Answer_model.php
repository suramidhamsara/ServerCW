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

	public function mark_as_correct($answer_id, $question_id, $user_id)
	{
		// Check if the user is the owner of the question
		$this->db->where('id', $question_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('questions');

		if ($query->num_rows() > 0) {
			// The user is the owner of the question, so mark the answer as correct
			$this->db->where('id', $answer_id);
			$this->db->update('answers', array('is_correct' => 1));
			$this->db->where('id', $question_id);
			$this->db->update('questions', array('is_solved' => 1));
		}
	}

	public function get_correct_answers_by_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('is_correct', 1);
		$query = $this->db->get('answers');
		return $query->result_array();
	}


	public function delete_answer($answer_id)
	{
		$this->db->where('id', $answer_id);
		return $this->db->delete('answers');
	}
}
