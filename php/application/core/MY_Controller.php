<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public $_data = array();
	public $_api = array();
	public $_stream = array();

	/**
	 * construct
	 */
	public function __construct($is_session_login=true)
	{
		parent::__construct();

		/* クラス名とメソッド名をセット */
		$this->_data['class'] = strtolower($this->router->fetch_class());
		$this->_data['method'] = strtolower($this->router->fetch_method());

		/* ログインチェック */
		if( $is_session_login ){
			$this->sessionLoginCheck();
		}else{
			$this->apiLoginCheck();
		}
	}

	/**
	 * sessionLoginCheck
	 *
	 * セッションログインチェック
	 * 最新のデータを$this->_userに格納
	 */
	protected function sessionLoginCheck()
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
				$token = get_cookie('token');
				if( $token ){
					$auth = $this->AccessTokens->tryAutoLogin( $token, ACCESS_TOKEN_COOKIE );
					if( $auth ){
						$this->session->sess_regenerate(TRUE);
						$this->session->set_userdata('id', $this->session->session_id);
						$this->session->set_userdata('user', $this->encryption->encrypt($auth->user_id));
						$this->AccessTokens->generateToken( $auth->user_id, ACCESS_TOKEN_API );
					}
				}
				/* 未ログイン */
				if( !$this->session->userdata('id') ){
					$this->_logout();
				}
				$_user = $this->Users->getDetail( $this->encryption->decrypt($this->session->userdata('user')) );
				if( $_user ){
					/* 最新のログイン情報を取得 */
					$this->_user = $_user;
					$this->_data['api_token'] = $this->AccessTokens->fetchToken( $this->_user->user_id, ACCESS_TOKEN_API );
				}else{
					/* ログインアカウントが正しくない */
					$this->_logout();
				}
			}
		}
	}

	/**
	 * _logout
	 *
	 * ログアウト処理
	 */
	protected function _logout()
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
		$this->_data['aside'] = lang('app_aside');
		$this->load->view('templates'.DS.'header', $this->_data);

		/* sidebar */
		$this->load->view('templates'.DS.'sidebar', $this->_data);

		/* contents */
		if( $otherview ){
			$this->load->view( $this->_data['class'].DS.$otherview, $this->_data );
		}else{
			$this->load->view( $this->_data['class'].DS.$this->_data['method'], $this->_data );
		}

		/* footer */
		$this->load->view('templates'.DS.'footer', $this->_data);
	}

	/**
	 * apiLoginCheck
	 *
	 * APIログインチェック
	 * 最新のデータを$this->_userに格納
	 */
	public function apiLoginCheck()
	{
		$token = $this->input->get_request_header(API_AUTH_HEADER, TRUE);
		$auth = $this->AccessTokens->tryAutoLogin($token, ACCESS_TOKEN_API);
		if( !$auth ){
			/* 無効なトークン */
			$this->_api['code'] = 400;
			$this->json();
		}

		$_user = $this->Users->getDetail( $auth->user_id );
		if( !$_user ){
			/* ログインアカウントが正しくない */
			$this->_api['code'] = 403;
			$this->json();
		}
		$this->_user = $_user;

		if( $this->input->raw_input_stream ){
			$this->_stream = json_decode(trim($this->input->raw_input_stream), true);
			if( !isset($this->_stream) ){
				/* json形式エラー */
				$this->_api['code'] = 900;
				$this->json();
			}
		}
	}

	/**
	 * json
	 *
	 * API用jsonレスポンス
	 *
	 * @return json
	 */
	public function json()
	{
		$this->_api['code'] = isset($this->_api['code']) ? $this->_api['code'] : 200;

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($this->_api))
		->_display();
		exit(0);
	}

	/**
	 * space_trim
	 *
	 * 前後の半角全角スペースを除く
	 *
	 * @param string $str
	 */
	protected function space_trim($str) {
		// 行頭の半角、全角スペースを、空文字に置き換える
		$str = preg_replace('/^[ 　]+/u', '', $str);
		// 末尾の半角、全角スペースを、空文字に置き換える
		$str = preg_replace('/[ 　]+$/u', '', $str);

		return $str;
	}

}