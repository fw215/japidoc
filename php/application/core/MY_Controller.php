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

		/* クラス名とメソッド名をセット */
		$this->_data['class'] = strtolower($this->router->fetch_class());
		$this->_data['method'] = strtolower($this->router->fetch_method());

		/* ログインチェック */
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

		/* Pagesはログインチェックなし */
		if( $this->_data['class'] !== 'pages' && $this->_data['class'] !== 'signup' ){
			if( $this->_data['class'] === 'login' && $this->_data['method'] !== 'logout' ){
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

	/**
	 * view表示
	 *
	 * contentsのviewファイルはclass/method.phpを見る
	 * otherviewを指定した場合はclass/otherview.phpを見る
	 *
	 * @param string $otherview
	 */
	protected function set($otherview = NULL)
	{
		/* header */
		if( $this->_data['class'] === 'login' || $this->_data['class'] === 'signup' ){
			$this->load->view('templates'.DS.'login-header', $this->_data);
		}else{
			$this->load->view('templates'.DS.'header', $this->_data);
		}

		/* contents */
		if( $otherview ){
			$this->load->view( $this->_data['class'].DS.$otherview, $this->_data );
		}else{
			$this->load->view( $this->_data['class'].DS.$this->_data['method'], $this->_data );
		}

		/* footer */
		if( $this->_data['class'] === 'login' || $this->_data['class'] === 'signup' ){
			$this->load->view('templates'.DS.'login-footer', $this->_data);
		}else{
			$this->load->view('templates'.DS.'footer', $this->_data);
		}
	}
}