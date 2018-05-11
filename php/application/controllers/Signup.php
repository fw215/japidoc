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
			if( $this->_data['errors'] = $this->Users_lib->signup_validation( $this->input->post() ) ){
				/* エラーチェック */
				$this->_data['data']['nickname'] = $this->input->post('nickname');
				$this->_data['data']['email'] = $this->input->post('email');
				$this->_data['data']['terms'] = $this->input->post('terms');
			}else{
				/* 新規登録 */
				$insert = array(
					'nickname' => $this->input->post('nickname'),
					'email' => $this->input->post('email'),
					'password' => $this->input->post('password'),
				);
				$user = $this->Users->insert($insert);
				/* ログイン */
				$this->session->sess_regenerate(TRUE);
				$this->session->set_userdata('id', $this->session->session_id);
				$this->session->set_userdata('user', $this->encryption->encrypt($user->user_id));
				$this->AccessTokens->generateToken( $user->user_id, ACCESS_TOKEN_API );
				redirect( base_url('/') );
			}
		}
		$this->set();
	}
}
