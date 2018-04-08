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
				/* エラーチェック */
				$this->_data['data']['email'] = $this->input->post('email');
			}else{
				/* ログインチェック */
			}
		}

		$this->set();
	}
}
