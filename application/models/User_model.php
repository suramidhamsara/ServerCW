<?php 
defined('BASEPATH') OR exit('No direct script access allowed')?>
                        
<?php
class User_model extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function get_user($user_id){
		$this->db->where('id', $user_id);
		return $this->db->get('users')->row_array();
	}

    public function register($username, $password, $email)
    {
        $data = array(
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'email' => $email
        );
        return $this->db->insert('users', $data);
    }

    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $user = $this->db->get('users')->row();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return false;
    }

    public function delete_account($user_id)
    {
        $this->db->where('id', $user_id);
        return $this->db->delete('users');
    }
}


/* End of file User_model.php and path \application\models\User_model.php */
