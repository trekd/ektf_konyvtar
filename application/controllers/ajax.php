<?php

#doc
#	classname:	Ajax
#	scope:		PUBLIC
#
#/doc

class Ajax extends Controller
{
	#	Constructor
	function __construct ()
	{
		# code...
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
		$json = array ('error' => $this->lang->line('error_bad_json_request'));
		$this->_json($json);
	}
	###

	#doc
	#	functionname:	call_json
	#	scope:		public
	#	parm:		
	#	return:		void
	#
	#/doc
	
	function call_json($action = '')
	{
		# code...
		
		
		$this->_json($json);
	}
	###

	#doc
	#	functionname:	json
	#	scope:		private
	#	parm:		array
	#	return:		void
	#
	#/doc
	
	function _json($json = array())
	{
		# code...
		$data['json'] = $json;
		$this->load->view('json', $data);
		
	}
	###
}
###
