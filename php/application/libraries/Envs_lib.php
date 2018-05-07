<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Envs_lib
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
			'api_id',
			'lang:apis_title',
			'required|trim'
		);
		$this->CI->validation->set_rules(
			'name',
			'lang:envs_name',
			'required|trim|max_length[50]'
		);
		$this->CI->validation->set_rules(
			'description',
			'lang:envs_description',
			'trim|max_length[20000]'
		);
		$this->CI->validation->set_rules(
			'method',
			'lang:envs_method',
			'required|trim'
		);
		$this->CI->validation->set_rules(
			'url',
			'lang:envs_url',
			'required|trim|max_length[255]|valid_url'
		);
		if( !$this->CI->validation->run() ){
			$result['api_id'] = !empty($this->CI->validation->error('api_id')) ? $this->CI->validation->error('api_id') : NULL;
			$result['name'] = !empty($this->CI->validation->error('name')) ? $this->CI->validation->error('name') : NULL;
			$result['description'] = !empty($this->CI->validation->error('description')) ? $this->CI->validation->error('description') : NULL;
			$result['method'] = !empty($this->CI->validation->error('method')) ? $this->CI->validation->error('method') : NULL;
			$result['url'] = !empty($this->CI->validation->error('url')) ? $this->CI->validation->error('url') : NULL;
		}
		/* 追加バリデーション */
		if( !isset($result['api_id']) ){
			$api_validation = $this->api_validation($data);
			if( isset($api_validation) ){
				$result['api_id'] = $api_validation;
			}
		}

		return $result;
	}

	/**
	 * api_validation
	 *
	 * APIのチェック
	 *
	 * @param array $data
	 * @return string|null
	 */
	public function api_validation(array $data){
		/* プロジェクトが存在しているかチェック */
		$api_id = isset($data['api_id']) ? $data['api_id'] : 0;
		$search = array(
			'api_id' => $api_id,
		);
		if( !$this->CI->Apis->get($search) ){
			return lang('envs_api_not_exist');
		}
		return NULL;
	}
}