<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * SimpleLoginSecure Class
 *
 * Makes authentication simple and secure.
 *
 * Simplelogin expects the following database setup. If you are not using 
 * this setup you may need to do some tweaking.
 *   
 * 
 *   CREATE TABLE `users` (
 *     `user_id` int(10) unsigned NOT NULL auto_increment,
 *     `user_email` varchar(255) NOT NULL default '',
 *     `user_pass` varchar(60) NOT NULL default '',
 *     `user_date` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT 'Creation date',
 *     `user_modified` datetime NOT NULL default '0000-00-00 00:00:00',
 *     `user_last_login` datetime NULL default NULL,
 *     PRIMARY KEY  (`user_id`),
 *     UNIQUE KEY `user_email` (`user_email`),
 *   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * 
 * @package   SimpleLoginSecure
 * @version   1.0.1
 * @author    Alex Dunae, Dialect <alex[at]dialect.ca>
 * @copyright Copyright (c) 2008, Alex Dunae
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt
 * @link      http://dialect.ca/code/ci-simple-login-secure/
 * 
 **
 * customized
 * by eriksulymosi
 */
class Login
{
	var $CI;
	var $user_table = 'users';

	/**
	 * Create a user account
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function create($username = '', $email = '', $password = '', $usergroup = 0) 
	{
		$this->CI =& get_instance();
		


		//Make sure account info was sent
		if($username == '' OR $email == '' OR $password == '')
		{
			return false;
		}
		
		//Check against user table
		$this->CI->db->where('username', $username);
		$this->CI->db->where('email', $email);
		$query = $this->CI->db->getwhere($this->user_table);
		
		if ($query->num_rows() > 0) //user_email already exists
		{
			return false;
		}

		//Insert account into the database
		$data = array(
					'username' => $username,
					'email' => $email,
					'password' => md5($password),
					'usergroup' => $usergroup
				);

		$this->CI->db->set($data); 

		if(!$this->CI->db->insert($this->user_table)) //There was a problem!
		{
			return false;
		}

		return true;
	}

	/**
	 * Login and sets session variables
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function login($username_email = '', $password = '') 
	{
		$this->CI =& get_instance();

		if($username_email == '' OR $password == '')
			return false;


		//Check if already logged in
		if($this->CI->session->userdata('username_email') == $username_email)
			return true;
		
		
		//Check against user table
		$this->CI->db->where('username', $username_email); 
		$this->CI->db->or_where('email', $username_email); 
		$query = $this->CI->db->getwhere($this->user_table);

		
		if ($query->num_rows() > 0) 
		{
			$user_data = $query->row_array(); 

			if(md5($password) != $user_data['password'])
				return false;

			//Destroy old session
			$this->CI->session->sess_destroy();
			
			//Create a fresh, brand new session
			$this->CI->session->sess_create();

			$this->CI->db->simple_query('UPDATE ' . $this->user_table  . ' SET last_login_date = NOW(), last_login_ip = "'. $_SERVER['REMOTE_ADDR'] .'" WHERE username = "' . $user_data['username'].'"');

			//Set session data
			unset($user_data['password']);
			$user_data['logged_in'] = true;
			$this->CI->session->set_userdata($user_data);
			
			return true;
		} 
		else 
		{
			return false;
		}	

	}


	/**
	 * Change pass
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function changepass($username_email = '', $user_oldpass = '', $user_newpass = '')
	{
	    
		$this->CI =& get_instance();
		
		// Make sure account info was sent
		if($username_email == '' OR $user_oldpass == '' OR $user_newpass == '') {
		    return false;
		}
		
		//Check against user table
		$this->CI->db->where('username', $username_email); 
		$this->CI->db->or_where('email', $username_email); 
		$query = $this->CI->db->getwhere($this->user_table);

		// Check old password
		if ($query->num_rows() > 0) 
		{
		    $user_data = $query->row_array(); 

		    $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);

		    if(md5($user_oldpass) != $user_data['user_pass'])
		        return false;

		    // Insert new password into table
		    $this->CI->db->simple_query('UPDATE ' . $this->user_table  . ' SET pasword = ' . md5($user_newpass) . ' WHERE username = "' . $user_data['username'].'"');

		    return true;
		} 
		else 
		{
		    return false;
		}    
	    
	}

	/**
	 * Logout user
	 *
	 * @access	public
	 * @return	bool
	 */
	function logout() {
		$this->CI =& get_instance();
		$this->CI->session->sess_destroy();
		return true;
	}

	/**
	 * Delete user
	 *
	 * @access	public
	 * @param 	string
	 * @return	bool
	 */
	function delete($user_id) 
	{
		$this->CI =& get_instance();
		
		if(!is_numeric($username))
			return false;			

		return $this->CI->db->delete($this->user_table, array('username' => $username));
	}
	
}
?>
