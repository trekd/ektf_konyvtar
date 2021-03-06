<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Guest
{

	var $CI;
	var $user_table = 'users';

	/**
	 * Guest Link
	 *
	 * Creates an anchor based on the local URL.
	 *
	 * @access	public
	 * @param	string	the URL
	 * @param	string	the link title
	 * @param	mixed	any attributes
	 * @return	string
	 */
	
	function guest_link($uri = '', $title = '', $attributes = '')
	{

		$this->CI =& get_instance();

		$this->CI->db->where('username', 'guest'); 
		$this->CI->db->where('password', md5('guest')); 
		$query = $this->CI->db->getwhere($this->user_table);

		if ($query->num_rows() == 1)
		{
			$title = (string) $title;

			if ( ! is_array($uri))
			{
				$site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
			}
			else
			{
				$site_url = site_url($uri);
			}

			if ($title == '')
			{
				$title = $site_url;
			}

			if ($attributes != '')
			{
				$attributes = _parse_attributes($attributes);
			}

			return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
		}
	}
}
###
