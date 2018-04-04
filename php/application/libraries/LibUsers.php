<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibUsers
{
	protected $CI;

	function __construct()
	{
		$this->CI =& get_instance();
	}

	public function signup($data)
	{
		$this->CI->load->library('form_validation', 'validation');

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
			$response['nickname'] = !empty($this->CI->validation->error('nickname')) ? $this->CI->validation->error('nickname') : NULL;
			$response['email'] = !empty($this->CI->validation->error('email')) ?  $this->CI->validation->error('email') : NULL;
			$response['password'] = !empty($this->CI->validation->error('password')) ? $this->CI->validation->error('password'): NULL;
			$response['terms'] = !empty($this->CI->validation->error('terms')) ? $this->CI->validation->error('terms') : NULL;
			return $response;
		}
		return false;
	}
}