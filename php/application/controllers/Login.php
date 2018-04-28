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
			if( $this->_data['errors'] = $this->Users_lib->login_validation( $postdata ) ){
				/* エラー */
				$this->_data['data']['email'] = $this->input->post('email');
			}else{
				/* ログインチェック */
				if( $userID = $this->Users_lib->login( $postdata ) ){
					$this->session->sess_regenerate(TRUE);
					$this->session->set_userdata('id', $this->session->session_id);
					$this->session->set_userdata('user', $this->encryption->encrypt($userID));

					/* 自動ログイン */
					if( $this->input->post('remember_me') ){
						$access_token = $this->AccessTokens->generateToken( $userID );
						set_cookie('token', $access_token, ACCESS_EXPIRE_TIME);
					}
					redirect( base_url('/') );
				}
				$this->_data['data']['email'] = $this->input->post('email');
				$this->_data['errors']['password'] = lang('login_failure');
			}
		}

		$this->set();
	}

	/* logout
	 *
	 * ログアウト処理
	 */
	public function logout()
	{
		$this->_logout();
	}
}
