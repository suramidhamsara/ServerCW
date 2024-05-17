<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Vote_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function vote_answer($answer_id, $user_id, $vote_type)
	{
		// Check if a vote by this user on this answer already exists
		$this->db->where('user_id', $user_id);
		$this->db->where('answer_id', $answer_id);

		$query = $this->db->get('votes');

		if ($query->num_rows() > 0) {
			// A vote already exists
			$existing_vote = $query->row();
			log_message('info', 'A vote already exists');
			log_message('info', 'Existing vote type: ' . $existing_vote->vote_type);
			if ($existing_vote->vote_type == $vote_type) {
				// The new vote is the same as the existing vote, so delete the vote
				$this->db->where('answer_id', $answer_id);
				$this->db->where('user_id', $user_id);
				$this->db->delete('votes');

				if ($vote_type == 'up') {
					$this->db->set('vote_count', 'vote_count-1', FALSE);
				} else if ($vote_type == 'down') {
					$this->db->set('vote_count', 'vote_count+1', FALSE);
				}
				$this->db->where('id', $answer_id);
				$this->db->update('answers');
			} else {
				// The new vote is different from the existing vote, so update the vote
				$this->db->where('answer_id', $answer_id);
				$this->db->where('user_id', $user_id);
				$this->db->update('votes', array('vote_type' => $vote_type));

				// Update the vote count for the answer
				if ($vote_type == 'up' && $existing_vote->vote_type == 'down') {
					// If the new vote is 'up' and the existing vote is 'down', increment the vote count by 2
					$this->db->set('vote_count', 'vote_count+2', FALSE);
				} else if ($vote_type == 'down' && $existing_vote->vote_type == 'up') {
					// If the new vote is 'down' and the existing vote is 'up', decrement the vote count by 2
					$this->db->set('vote_count', 'vote_count-2', FALSE);
				}
				$this->db->where('id', $answer_id);
				$this->db->update('answers');
			}
			return $existing_vote;
		} else {
			// No vote exists, so insert a new vote
			$data = array(
				'answer_id' => $answer_id,
				'user_id' => $user_id,
				'vote_type' => $vote_type
			);
			$this->db->insert('votes', $data);

			// Increment the vote count for the answer
			if ($vote_type == 'up') {
				$this->db->set('vote_count', 'vote_count+1', FALSE);
			} else if ($vote_type == 'down') {
				$this->db->set('vote_count', 'vote_count-1', FALSE);
			}
			$this->db->where('id', $answer_id);
			$this->db->update('answers');
		}
	}


	public function get_answer_votes($answer_id)
	{
		// Count the number of 'up' votes
		$this->db->where('answer_id', $answer_id);
		$this->db->where('vote_type', 'up');
		$up_votes = $this->db->count_all_results('votes');

		// Count the number of 'down' votes
		$this->db->where('answer_id', $answer_id);
		$this->db->where('vote_type', 'down');
		$down_votes = $this->db->count_all_results('votes');

		// Calculate the final count
		$final_count = $up_votes - $down_votes;

		// Return the final count
		return $final_count;
	}

	public function get_user_total_votes($user_id)
	{
		// Join the 'votes' table with the 'answers' table on 'answer_id'
		$this->db->select('votes.vote_type');
		$this->db->from('votes');
		$this->db->join('answers', 'votes.answer_id = answers.id');

		// Filter by 'user_id' from the 'answers' table
		$this->db->where('answers.user_id', $user_id);

		// Get the results
		$query = $this->db->get();

		// Count the number of 'up' votes and 'down' votes
		$up_votes = 0;
		$down_votes = 0;
		foreach ($query->result() as $row) {
			if ($row->vote_type == 'up') {
				$up_votes++;
			} else if ($row->vote_type == 'down') {
				$down_votes++;
			}
		}

		// Calculate the final count
		$final_count = $up_votes - $down_votes;

		// Return the final count
		return $final_count;
	}
}

