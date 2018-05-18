<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Headers_lib
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
			'env_id',
			'lang:envs_title',
			'required|trim'
		);
		$this->CI->validation->set_rules(
			'name',
			'lang:headers_name',
			'trim|max_byte[255]'
		);
		$this->CI->validation->set_rules(
			'value',
			'lang:headers_value',
			'trim|max_byte[65535]'
		);
		if( !$this->CI->validation->run() ){
			$result['env_id'] = !empty($this->CI->validation->error('env_id')) ? $this->CI->validation->error('env_id') : NULL;
			$result['name'] = !empty($this->CI->validation->error('name')) ? $this->CI->validation->error('name') : NULL;
			$result['value'] = !empty($this->CI->validation->error('value')) ? $this->CI->validation->error('value') : NULL;
		}
		/* 追加バリデーション */
		if( !isset($result['env_id']) ){
			$env_validation = $this->env_validation($data);
			if( isset($env_validation) ){
				$result['env_id'] = $env_validation;
			}
		}

		return $result;
	}

	/**
	 * env_validation
	 *
	 * ENVのチェック
	 *
	 * @param array $data
	 * @return string|null
	 */
	public function env_validation(array $data){
		/* プロジェクトが存在しているかチェック */
		$env_id = isset($data['env_id']) ? $data['env_id'] : 0;
		$search = array(
			'env_id' => $env_id,
		);
		if( !$this->CI->Envs->get($search) ){
			return lang('headers_env_not_exist');
		}
		return NULL;
	}
}