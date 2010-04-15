<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_json'))
{
	#doc
	#	functionname:	get_json
	#	scope:		public
	#	parm:		
	#	return:		string
	#
	#/doc

	function get_json($action = '')
	{
		# code...
		switch($action)
		{
			case 'error_username_email_or_password':
				$json = array('error' => 'error_username_email_or_password');
				break;

			case 'good_username_email_or_password':
				$json = array('success' => 'you_are_logged_in');
				break;

			default:
				$json = array('error' => 'error_bad_json_request');
				break;
		}
		return utf8_encode(json_encode($json));
	}
	###
}
###
