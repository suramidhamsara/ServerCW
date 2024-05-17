<?php
defined('BASEPATH') or exit('No direct script access allowed') ?>

<?php
class User_model extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function get_user($user_id)
	{
		$this->db->where('id', $user_id);
		return $this->db->get('users')->row_array();
	}

	public function register($username, $password, $email)
	{
		$this->db->where('username', $username);
		$result = $this->db->get('users');

		if ($result->num_rows() > 0) {
			return array('error' => 'Username already exists. Please choose a different one.');
		}

		// Check if email already exists
		$this->db->where('email', $email);
		$result = $this->db->get('users');

		if ($result->num_rows() > 0) {
			// If email exists, return an error message
			return array('error' => 'Email already exists. Please choose a different one.');
		}

		// Check if password is valid
		if (strlen($password) < 8) {
			// If password is less than 8 characters, return an error message
			return array('error' => 'Password should be at least 8 characters long.');
		}

		// If all validations pass, continue with registration
		$data = array(
			'username' => $username,
			'password' => password_hash($password, PASSWORD_BCRYPT),
			'email' => $email
		);

		$this->db->insert('users', $data);

		return array('success' => 'Registration successful. You can now log in.');
	}

	public function login($username, $password)
	{
		// Check if username and password are not empty
		if (empty($username) || empty($password)) {
			return array('error' => 'Username and password are required.');
		}

		$this->db->where('username', $username);
		$user = $this->db->get('users')->row();

		// Check if user exists and password is correct
		if ($user && password_verify($password, $user->password)) {
			return $user;
		}

		// If user doesn't exist or password is incorrect, return an error message
		return array('error' => 'Invalid username or password.');

	}

	public function delete_account($user_id)
	{
		$this->db->where('id', $user_id);
		return $this->db->delete('users');
	}
}

