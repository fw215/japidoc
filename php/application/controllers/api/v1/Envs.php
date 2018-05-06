<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Envs
 *
 * プロジェクト
 */
class Envs extends MY_Controller
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
			'api_id' => $this->input->get('api_id'),
			'page' => $this->input->get('page'),
		);

		if( empty($search['page']) ){
			$search['page'] = 1;
		}

		$this->_api['envs'] = $this->Envs->getList($search);
		if($search['page'] > 0){
			$this->_api['count'] = $this->Envs->getList($search, TRUE);
			$this->_api['pages'] = ceil($this->_api['count'] / DEFAULT_PAGE_LIMIT);
		}

		$this->json();
	}

	/**
	 * get
	 *
	 * 1件取得
	 */
	public function get($env_id=0)
	{
		$search = array(
			'env_id' => $env_id,
		);

		$env = $this->Envs->get($search);
		if( !$env ){
			show_404();
		}
		$this->_api['env'] = $env;

		$this->json();
	}

	/**
	 * put
	 *
	 * 1件更新
	 */
	public function put($env_id=0)
	{
		$update = array(
			'env_id' => isset($this->_stream['env_id']) ? $this->space_trim($this->_stream['env_id']) : NULL,
			'api_id' => isset($this->_stream['api_id']) ? $this->space_trim($this->_stream['api_id']) : NULL,
			'name' => isset($this->_stream['name']) ? $this->space_trim($this->_stream['name']) : NULL,
			'description' => isset($this->_stream['description']) ? $this->space_trim($this->_stream['description']) : NULL,
			'url' => isset($this->_stream['url']) ? $this->space_trim($this->_stream['url']) : NULL,
		);
		$errors = $this->Envs_lib->register_validation( $update );
		if( $errors ){
			$this->_api['code'] = API_BAD_REQUEST;
			$this->_api['errors'] = $errors;
			$this->json();
		}

		$env = $this->Envs->update($env_id, $update);
		if( !$env ){
			show_404();
		}
		$this->_api['env'] = $env;

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
			'api_id' => isset($this->_stream['api_id']) ? $this->space_trim($this->_stream['api_id']) : NULL,
			'name' => isset($this->_stream['name']) ? $this->space_trim($this->_stream['name']) : NULL,
			'description' => isset($this->_stream['description']) ? $this->space_trim($this->_stream['description']) : NULL,
			'url' => isset($this->_stream['url']) ? $this->space_trim($this->_stream['url']) : NULL,
		);
		$errors = $this->Envs_lib->register_validation( $insert );
		if( $errors ){
			$this->_api['code'] = API_BAD_REQUEST;
			$this->_api['errors'] = $errors;
			$this->json();
		}

		$env = $this->Envs->insert($insert);
		if( !$env ){
			show_404();
		}
		$this->_api['env'] = $env;

		$this->json();
	}

	/**
	 * delete
	 *
	 * 1件削除
	 */
	public function delete($env_id=0)
	{
		$result = $this->Envs->delete($env_id);
		if( !$result ){
			show_404();
		}

		$this->json();
	}
}
