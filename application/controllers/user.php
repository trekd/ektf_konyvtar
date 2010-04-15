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
	#	functionname:	go_to_dashboard
	#	scope:		private
	#	parm:		
	#	return:		void
	#
	#/doc
	
	function _go_to_dashboard()
	{
		# code...
		if ($this->session->userdata('logged_in') && ! $this->logout)
		{
			redirect('books');
		}
	}
	###

	#doc
	#	functionname:	index
	#	scope:		public
	#	parm:		string
	#	return:		void
	#
	#/doc
	
	function index($msg = '')
	{
		# code...
		$this->load->library('guest');
		$this->_go_to_dashboard();

		$data['title'] = $this->lang->line('title_login');
		$data['javascript'] = array('jquery', 'jquery.validate', 'label', 'login');
		$data['css'] = array('entry');
		$data['msg'] = $msg;

		$this->load->view('head_view', $data);
		$this->load->view('./entry/login_form_view', $data);
		$this->load->view('foot_view', $data);
	}
	###

	#doc
	#	functionname:	login
	#	scope:		public
	#	parm:		string
	#	return:		void
	#
	#/doc
	
	function login($as_guest = '')
	{
		# code...
		$this->load->library('guest');
		$this->_go_to_dashboard();

		$this->username_email = $this->input->post('username_email');
		$this->password = $this->input->post('password');

		if ($as_guest == 'as_guest')
		{
			$this->username_email = 'guest';
			$this->password = 'guest';
		}

		if($this->login->login($this->username_email, $this->password))
		{
			if($this->input->post('ajax'))
			{
				$data['json'] = get_json('good_username_email_or_password');
				$this->load->view('json', $data);
			}
			else
			{
				redirect('books');
			}
		}
		else
		{
			if($this->input->post('ajax'))
			{
				$data['json'] = get_json('error_username_email_or_password');
				$this->load->view('json', $data);
			}
			else
			{
				$this->index('error_username_email_or_password');
			}
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
		$this->load->library('guest');
		$this->load->library('captcha');

		$data['title'] = $this->lang->line('title_lost_my_password');
		$data['javascript'] = array('jquery');
		$data['css'] = array('entry');

		$configs = array(
				'img_path' => './captcha/',
				'img_url' => base_url() . 'captcha/',
				'font_path' => './system/fonts',
				'font_name' => 'awesome.ttf',
				'img_height' => '20',
			);			
		$data['captcha'] = $this->captcha->get_antispam_image($configs);

		$this->load->view('head_view', $data);
		$this->load->view('entry/lost_my_password_view', $data);
		$this->load->view('foot_view', $data);
	}
	###

	#doc
	#	functionname:	logout
	#	scope:		public
	#	parm:		
	#	return:		void
	#
	#/doc
	
	function logout()
	{
		# code...
		if ($this->login->logout())
			$this->logout = true;
			$this->index('entry_logout_successfuly');
	}
	###
}
###
