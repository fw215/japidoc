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

	/**
	 * index
	 *
	 * 新規登録画面
	 */
	public function index()
	{
		if($this->input->method(TRUE) === 'POST' ){
			$postdata = $this->input->post();
			if( $this->_data['errors'] = $this->Users_lib->signup_validation( $postdata ) ){
				/* エラーチェック */
				$this->_data['data']['nickname'] = $this->input->post('nickname');
				$this->_data['data']['email'] = $this->input->post('email');
				$this->_data['data']['terms'] = $this->input->post('terms');
			}else{
				/* 新規登録 */
				$postdata['user_id'] = 0;
				$user_id = $this->Users->register( $postdata );
				/* ログイン */
				$this->session->sess_regenerate(TRUE);
				$this->session->set_userdata('id', $this->session->session_id);
				$this->session->set_userdata('user', $this->encryption->encrypt($user_id));
				redirect( base_url('/') );
			}
		}
		$this->set();
	}
}
