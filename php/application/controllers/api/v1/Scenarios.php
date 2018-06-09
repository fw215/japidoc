<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Scenarios
 *
 * シナリオ
 */
class Scenarios extends MY_Controller
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
			'project_id' => $this->input->get('project_id'),
			'page' => $this->input->get('page'),
		);

		if( empty($search['page']) ){
			$search['page'] = 1;
		}

		$this->_api['scenarioss'] = $this->Scenarios->search($search);
		$this->_api['count'] = $this->Scenarios->search($search, TRUE);
		$this->_api['pages'] = ceil($this->_api['count'] / DEFAULT_PAGE_LIMIT);

		$this->json();
	}

	/**
	 * get
	 *
	 * 1件取得
	 */
	public function get($scenario_id=0)
	{
		$search = array(
			'scenario_id' => $scenario_id,
		);

		$scenario = $this->Scenarios->get($search);
		if( !$scenario ){
			show_404();
		}
		$this->_api['scenario'] = $scenario;

		$this->json();
	}

	/**
	 * put
	 *
	 * 1件更新
	 */
	public function put($scenario_id=0)
	{
		$update = array(
			'project_id' => isset($this->_stream['project_id']) ? $this->space_trim($this->_stream['project_id']) : NULL,
			'name' => isset($this->_stream['name']) ? $this->space_trim($this->_stream['name']) : NULL,
			'description' => isset($this->_stream['description']) ? $this->space_trim($this->_stream['description']) : NULL,
		);
		$errors = $this->Scenarios_lib->register_validation( $update );
		if( $errors ){
			$this->_api['code'] = API_BAD_REQUEST;
			$this->_api['errors'] = $errors;
			$this->json();
		}

		$scenario = $this->Scenarios->update($scenario_id, $update);
		if( !$scenario ){
			show_404();
		}
		$this->_api['scenario'] = $scenario;

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
			'project_id' => isset($this->_stream['project_id']) ? $this->space_trim($this->_stream['project_id']) : NULL,
			'name' => isset($this->_stream['name']) ? $this->space_trim($this->_stream['name']) : NULL,
			'description' => isset($this->_stream['description']) ? $this->space_trim($this->_stream['description']) : NULL,
		);
		$errors = $this->Scenarios_lib->register_validation( $insert );
		if( $errors ){
			$this->_api['code'] = API_BAD_REQUEST;
			$this->_api['errors'] = $errors;
			$this->json();
		}

		$scenario = $this->Scenarios->insert($insert);
		if( !$scenario ){
			show_404();
		}
		$this->_api['scenario'] = $scenario;

		$this->json();
	}

	/**
	 * delete
	 *
	 * 1件削除
	 */
	public function delete($scenario_id=0)
	{
		$result = $this->Scenarios->delete($scenario_id);
		if( !$result ){
			show_404();
		}

		$this->json();
	}
}
