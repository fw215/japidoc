<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibUsers
{
	protected $CI;

	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('form_validation', 'validation');
	}

	/**
	 * login
	 *
	 * ログイン
	 *
	 * @param array $data
	 * @return bool
	 */
	public function login(array $data)
	{
		$email = isset($data['email']) ? $data['email'] : '';
		$password = isset($data['password']) ? $data['password'] : '';

		if( !$result = $this->CI->Users->getDataEmail($email) ){
			return false;
		}

		if( !password_verify($password, $result->password) ){
			return false;
		}
		return true;
	}

	/**
	 * login_validation
	 *
	 * ログインバリデーション
	 *
	 * @param array $data
	 * @return bool|array $result
	 */
	public function login_validation(array $data)
	{
		$result = false;

		$this->CI->validation->set_data($data);
		$this->CI->validation->set_rules(
			'email',
			'lang:users_email',
			'required|trim|valid_email'
		);
		$this->CI->validation->set_rules(
			'password',
			'lang:users_password',
			'required|trim'
		);
		if( !$this->CI->validation->run() ){
			$result['email'] = !empty($this->CI->validation->error('email')) ? $this->CI->validation->error('email') : NULL ;
			$result['password'] = !empty($this->CI->validation->error('password')) ? $this->CI->validation->error('password') : NULL;
		}
		return $result;
	}

	/**
	 * signup_validation
	 *
	 * 新規登録バリデーション
	 *
	 * @param array $data
	 * @return bool|array $result
	 */
	public function signup_validation(array $data)
	{
		$result = false;

		$this->CI->validation->set_data($data);
		$this->CI->validation->set_rules(
			'nickname',
			'lang:users_nickname',
			'required|trim|min_length[1]|max_length[64]'
		);
		$this->CI->validation->set_rules(
			'email',
			'lang:users_email',
			'required|trim|valid_email|min_length[8]|max_length[255]'
		);
		$this->CI->validation->set_rules(
			'password',
			'lang:users_password',
			'required|trim|min_length[8]|max_length[64]'
		);
		$this->CI->validation->set_rules(
			'terms',
			'lang:users_signup_terms',
			'required'
		);
		if( !$this->CI->validation->run() ){
			$result['nickname'] = !empty($this->CI->validation->error('nickname')) ? $this->CI->validation->error('nickname') : NULL;
			$result['email'] = !empty($this->CI->validation->error('email')) ?  $this->CI->validation->error('email') : NULL;
			$result['password'] = !empty($this->CI->validation->error('password')) ? $this->CI->validation->error('password'): NULL;
			$result['terms'] = !empty($this->CI->validation->error('terms')) ? $this->CI->validation->error('terms') : NULL;
		}
		/* 追加バリデーション */
		if( !isset($result['email']) ){
			$email_validation = $this->email_validation($data);
			if( isset($email_validation) ){
				$result['email'] = $email_validation;
			}
		}

		return $result;
	}

	/**
	 * email_validation
	 *
	 * メールアドレスのチェック
	 *
	 * @param array $data
	 * @return string|null
	 */
	public function email_validation(array $data){
		/* メールアドレスと重複していないかチェック */
		$email = isset($data['email']) ? $data['email'] : '';
		$user_id = isset($data['user_id']) ? $data['user_id'] : 0;
		if( $this->CI->Users->isCheckDuplicateEmail($email, $user_id) ){
			return lang('signup_email_duplicate');
		}
		return NULL;
	}
}