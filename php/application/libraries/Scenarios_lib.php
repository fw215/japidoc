<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scenarios_lib
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
			'project_id',
			'lang:projects_title',
			'required|trim'
		);
		$this->CI->validation->set_rules(
			'name',
			'lang:scenarios_name',
			'required|trim|max_byte[255]'
		);
		$this->CI->validation->set_rules(
			'description',
			'lang:scenarios_description',
			'trim|max_byte[65535]'
		);
		if( !$this->CI->validation->run() ){
			$result['project_id'] = !empty($this->CI->validation->error('project_id')) ? $this->CI->validation->error('project_id') : NULL;
			$result['name'] = !empty($this->CI->validation->error('name')) ? $this->CI->validation->error('name') : NULL;
			$result['description'] = !empty($this->CI->validation->error('description')) ? $this->CI->validation->error('description') : NULL;
		}
		/* 追加バリデーション */
		if( !isset($result['project_id']) ){
			$project_validation = $this->project_validation($data);
			if( isset($project_validation) ){
				$result['project_id'] = $project_validation;
			}
		}

		return $result;
	}

	/**
	 * project_validation
	 *
	 * プロジェクトのチェック
	 *
	 * @param array $data
	 * @return string|null
	 */
	public function project_validation(array $data){
		/* プロジェクトが存在しているかチェック */
		$project_id = isset($data['project_id']) ? $data['project_id'] : 0;
		$search = array(
			'project_id' => $project_id,
		);
		if( !$this->CI->Projects->get($search) ){
			return lang('scenarios_project_not_exist');
		}
		return NULL;
	}
}