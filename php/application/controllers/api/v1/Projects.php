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
			'freetext' => $this->input->get('freetext'),
			'page' => $this->input->get('page'),
		);

		if( empty($search['page']) ){
			$search['page'] = 1;
		}

		$this->_api['projects'] = $this->Projects->search($search);
		$this->_api['count'] = $this->Projects->search($search, TRUE);
		$this->_api['pages'] = ceil($this->_api['count'] / DEFAULT_PAGE_LIMIT);

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

		$project = $this->Projects->get($search);
		if( !$project ){
			show_404();
		}
		$this->_api['project'] = $project;

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

		$project = $this->Projects->update($project_id, $update);
		if( !$project ){
			show_404();
		}
		$this->_api['project'] = $project;

		$this->json();
	}

	/**
	 * post
	 *
	 * 1件登録
	 */
	public function post()
	{
		$insert = array(
			'name' => isset($this->_stream['name']) ? $this->space_trim($this->_stream['name']) : NULL,
			'description' => isset($this->_stream['description']) ? $this->space_trim($this->_stream['description']) : NULL,
		);
		$errors = $this->Projects_lib->register_validation( $insert );
		if( $errors ){
			$this->_api['code'] = API_BAD_REQUEST;
			$this->_api['errors'] = $errors;
			$this->json();
		}

		$project = $this->Projects->insert($insert);
		if( !$project ){
			show_404();
		}
		$this->_api['project'] = $project;

		$this->json();
	}

	/**
	 * delete
	 *
	 * 1件削除
	 */
	public function delete($project_id=0)
	{
		$result = $this->Projects->delete($project_id);
		if( !$result ){
			show_404();
		}

		$this->json();
	}
}
