<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Signup
 *
 * 新規登録
 */
class Signup extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->input->method(TRUE) === 'POST' ){
			if( $this->_data['errors'] = $this->LibUsers->signup( $this->input->post() ) ){
				$this->_data['data']['nickname'] = $this->input->post('nickname');
				$this->_data['data']['email'] = $this->input->post('email');
				$this->_data['data']['terms'] = $this->input->post('terms');
			}
		}
		$this->set();
	}
}
