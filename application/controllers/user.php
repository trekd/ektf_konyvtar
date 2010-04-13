<?php

#doc
#	classname:	Site
#	scope:		PUBLIC
#
#/doc

class User extends Controller
{
	#	Constructor
	function __construct ()
	{
		parent::Controller();
	}
	###

	#doc
	#	functionname:	index
	#	scope:		public
	#	parm:		
	#	return:		void
	#
	#/doc
	
	function index()
	{
		# code...
		$data['title'] = $this->lang->line('title_login');
		$data['javascript'] = array('jquery');
		$data['css'] = array('entry');

		$this->load->view('head_view', $data);
		$this->load->view('entry/login_form_view', $data);
		$this->load->view('foot_view', $data);
	}
	###

	#doc
	#	functionname:	login
	#	scope:		public
	#	parm:		
	#	return:		void
	#
	#/doc
	
	function login()
	{
		# code...
		if($this->login->login($this->input->post('username_email'), $this->input->post('password')))
		{
			
		}
	}
	###

	#doc
	#	functionname:	lost_my_password
	#	scope:		public
	#	parm:		
	#	return:		void
	#
	#/doc
	
	function lost_my_password()
	{
		# code...
		$data['title'] = $this->lang->line('title_lost_my_password');
		$data['javascript'] = array('jquery');
		$data['css'] = array('entry');

		$this->load->view('head_view', $data);
		$this->load->view('entry/lost_my_password_view', $data);
		$this->load->view('foot_view', $data);
	}
	###
}
###
