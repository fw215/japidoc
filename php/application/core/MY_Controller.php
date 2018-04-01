<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public $_data = array();

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();

		// ログインチェック
		$this->loginCheck();
	}

	/**
	 * loginCheck
	 *
	 * ログインチェック
	 * 最新のデータを$this->_userに格納
	 */
	protected function loginCheck()
	{
		$class = strtolower($this->router->fetch_class());
		$method = strtolower($this->router->fetch_method());

		/* Pagesはログインチェックなし */
		if( $class !== 'pages' ){
			if( $class === 'login' && $method !== 'logout' ){
				/* ログイン済 */
				if( $this->session->userdata('id') ){
					redirect( base_url('/') );
				}
			}else{
				/* Cookieがあればログインを試みる */
				if( get_cookie('token') ){
					$auth = $this->AccessTokens->tryAutoLogin( get_cookie('token') );
					if( $auth ){
						$this->session->sess_regenerate(TRUE);
						$this->session->set_userdata('id', $this->session->session_id);
						$this->session->set_userdata('user', $this->encrypt->encode($auth->user_id));
					}
				}
				/* 未ログイン */
				if( !$this->session->userdata('id') ){
					$this->logout();
				}
				$_user = $this->Users->getDetail( $this->encrypt->decode($this->session->userdata('user')) );
				if( $_user ){
					/* 最新のログイン情報を取得 */
					$this->_user = $_user;
				}else{
					/* ログインアカウントが正しくない */
					$this->logout();
				}
			}
		}
	}

	/**
	 * logout
	 */
	protected function logout()
	{
		$this->session->sess_destroy();
		delete_cookie('token');

		redirect( base_url('login') );
	}
}