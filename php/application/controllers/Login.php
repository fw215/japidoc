<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Login
 *
 * ログイン
 */
class Login extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * index
	 *
	 * ログイン画面
	 */
	public function index()
	{
		if( $this->input->method(TRUE) === 'POST' ){
			$postdata = $this->input->post();
			if( $this->_data['errors'] = $this->LibUsers->login_validation( $postdata ) ){
				/* エラー */
				$this->_data['data']['email'] = $this->input->post('email');
			}else{
				/* ログインチェック */
				if( $user = $this->LibUsers->login( $postdata ) ){
					$this->session->sess_regenerate(TRUE);
					$this->session->set_userdata('id', $this->session->session_id);
					$this->session->set_userdata('user', $this->encrypt->encode($user->user_id));
				}
				$this->_data['data']['email'] = $this->input->post('email');
				$this->_data['errors']['password'] = lang('login_failure');
			}
		}

		$this->set();
	}
}
