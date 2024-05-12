<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Vote_model extends CI_Model
{
	public function vote_answer($answer_id, $user_id, $vote_type)
	{
		$data = array(
			'answer_id' => $answer_id,
			'user_id' => $user_id,
			'vote_type' => $vote_type
		);
		return $this->db->insert('votes', $data);
	}

	public function get_total_votes_by_user($user_id)
	{
		// Count the number of 'up' votes
		$this->db->where('user_id', $user_id);
		$this->db->where('vote_type', 'up');
		$up_votes = $this->db->count_all_results('votes');

		// Count the number of 'down' votes
		$this->db->where('user_id', $user_id);
		$this->db->where('vote_type', 'down');
		$down_votes = $this->db->count_all_results('votes');

		// Calculate the total votes
		$total_votes = $up_votes - $down_votes;

		return $total_votes;
	}
}

