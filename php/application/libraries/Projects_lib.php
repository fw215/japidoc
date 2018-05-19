<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects_lib
{
	protected $CI;

	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('form_validation', 'validation');

		$this->CI->validation->set_error_delimiters('', '');
	}

	/**
	 * register_validation
	 *
	 * 登録・更新バリデーション
	 *
	 * @param array $data
	 * @return bool|array $result
	 */
	public function register_validation(array $data)
	{
		$result = false;

		$this->CI->validation->set_data($data);
		$this->CI->validation->set_rules(
			'name',
			'lang:projects_name',
			'required|trim|max_byte[255]|max_length[100]'
		);
		$this->CI->validation->set_rules(
			'description',
			'lang:projects_description',
			'trim|max_byte[65535]'
		);
		if( !$this->CI->validation->run() ){
			$result['name'] = !empty($this->CI->validation->error('name')) ? $this->CI->validation->error('name') : NULL;
			$result['description'] = !empty($this->CI->validation->error('description')) ? $this->CI->validation->error('description') : NULL;
		}

		return $result;
	}
}