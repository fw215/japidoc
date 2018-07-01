<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Apis
 *
 * プロジェクト
 */
class Apis extends MY_Controller
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
			'freetext' => $this->input->get('freetext'),
			'page' => $this->input->get('page'),
		);

		if( empty($search['page']) ){
			$search['page'] = 1;
		}

		$this->_api['apis'] = $this->Apis->search($search);
		$this->_api['count'] = $this->Apis->search($search, TRUE);
		$this->_api['pages'] = ceil($this->_api['count'] / DEFAULT_PAGE_LIMIT);

		$this->json();
	}

	/**
	 * get
	 *
	 * 1件取得
	 */
	public function get($api_id=0)
	{
		$search = array(
			'api_id' => $api_id,
		);

		$api = $this->Apis->get($search);
		if( !$api ){
			show_404();
		}
		$this->_api['api'] = $api;

		$this->json();
	}

	/**
	 * put
	 *
	 * 1件更新
	 */
	public function put($api_id=0)
	{
		$update = array(
			'project_id' => isset($this->_stream['project_id']) ? $this->space_trim($this->_stream['project_id']) : NULL,
			'name' => isset($this->_stream['name']) ? $this->space_trim($this->_stream['name']) : NULL,
			'description' => isset($this->_stream['description']) ? $this->space_trim($this->_stream['description']) : NULL,
		);
		$errors = $this->Apis_lib->register_validation( $update );
		if( $errors ){
			$this->_api['code'] = API_BAD_REQUEST;
			$this->_api['errors'] = $errors;
			$this->json();
		}

		$api = $this->Apis->update($api_id, $update);
		if( !$api ){
			show_404();
		}
		$this->_api['api'] = $api;

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
		$errors = $this->Apis_lib->register_validation( $insert );
		if( $errors ){
			$this->_api['code'] = API_BAD_REQUEST;
			$this->_api['errors'] = $errors;
			$this->json();
		}

		$api = $this->Apis->insert($insert);
		if( !$api ){
			show_404();
		}
		$this->_api['api'] = $api;

		$this->json();
	}

	/**
	 * delete
	 *
	 * 1件削除
	 */
	public function delete($api_id=0)
	{
		$result = $this->Apis->delete($api_id);
		if( !$result ){
			show_404();
		}

		$this->json();
	}
}
