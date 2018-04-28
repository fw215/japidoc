<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Projects
 *
 * プロジェクト
 */
class Projects extends MY_Controller
{
	function __construct()
	{
		parent::__construct(FALSE);
	}

	/**
	 * search
	 *
	 * 検索
	 */
	public function search()
	{
		$search = array(
			'page' => $this->input->get('page'),
		);

		if( empty($search['page']) ){
			$search['page'] = 1;
		}

		$this->_api['projects'] = $this->Projects->getList($search);
		$this->_api['count'] = $this->Projects->getList($search, TRUE);

		$this->json();
	}

	/**
	 * get
	 *
	 * 1件取得
	 */
	public function get($project_id=0)
	{
		$search = array(
			'project_id' => $project_id,
		);

		$this->_api['project'] = $this->Projects->get($search);

		$this->json();
	}

	/**
	 * put
	 *
	 * 1件更新
	 */
	public function put($project_id=0)
	{
		$update = array(
			'name' => isset($this->_stream['name']) ? $this->space_trim($this->_stream['name']) : NULL,
			'description' => isset($this->_stream['description']) ? $this->space_trim($this->_stream['description']) : NULL,
		);
		$errors = $this->Projects_lib->register_validation( $update );
		if( $errors ){
			$this->_api['code'] = API_BAD_REQUEST;
			$this->_api['errors'] = $errors;
			$this->json();
		}

		$this->json();
	}

	/**
	 * post
	 *
	 * 1件登録
	 */
	public function post($project_id=0)
	{
		$this->json();
	}
}
