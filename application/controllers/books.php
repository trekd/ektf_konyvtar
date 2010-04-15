<?php

#doc
#	classname:	Book
#	scope:		PUBLIC
#
#/doc

class Books extends Controller
{
	#	Constructor
	function __construct ()
	{
		# code...
		parent::Controller();
		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('user');
		}
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
		$data['title'] = $this->lang->line('title_book_home');
		$data['javascript'] = array('jquery', 'jquery.validate', 'label');
		$data['css'] = array('book');

		$this->load->view('head_view', $data);
		echo anchor('user/logout', 'kilépés');
		$this->load->view('./books/index', $data);
		$this->load->view('foot_view', $data);
	}
	###
}
###
