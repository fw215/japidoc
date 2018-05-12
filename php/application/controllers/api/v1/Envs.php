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

		$this->_api['envs'] = $this->Envs->search($search);
		if($search['page'] > 0){
			$this->_api['count'] = $this->Envs->search($search, TRUE);
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
		$env->headers = $this->Headers->search($search);
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
			'api_id' => isset($this->_stream['api_id']) ? $this->space_trim($this->_stream['api_id']) : NULL,
			'name' => isset($this->_stream['name']) ? $this->space_trim($this->_stream['name']) : NULL,
			'description' => isset($this->_stream['description']) ? $this->space_trim($this->_stream['description']) : NULL,
			'method' => isset($this->_stream['method']) ? $this->space_trim($this->_stream['method']) : NULL,
			'url' => isset($this->_stream['url']) ? $this->space_trim($this->_stream['url']) : NULL,
		);
		$errors = $this->Envs_lib->register_validation( $update );

		// HEADER
		$headers = isset($this->_stream['headers']) ? (array)$this->_stream['headers'] : array();
		$not_delete_headers = array();
		foreach($headers as $k => $header){
			$upsert = array(
				'env_id' => isset($header['env_id']) ? $this->_stream['env_id'] : NULL,
				'name' => isset($this->_stream['name']) ? $this->space_trim($this->_stream['name']) : NULL,
				'value' => isset($this->_stream['value']) ? $this->space_trim($this->_stream['value']) : NULL,
			);
			$header_errors = $this->Headers_lib->register_validation( $upsert );
			if($header_errors){
				$errors['headers'][$k] = $header_errors;
			}else{
				$header_id = isset($header['header_id']) ? $header['header_id'] : 0;
				if( $header_id > 0 ){
					$not_delete_headers[] = $header_id;
				}
			}
		}
		if( $errors ){
			$this->_api['code'] = API_BAD_REQUEST;
			$this->_api['errors'] = $errors;
			$this->json();
		}

		$env = $this->Envs->update($env_id, $update);
		if( !$env ){
			show_404();
		}

		// HEADER
		$this->Headers->eliminate($env_id, $not_delete_headers);
		foreach($headers as $k => $header){
			$upsert = array(
				'env_id' => isset($header['env_id']) ? $this->_stream['env_id'] : NULL,
				'name' => isset($header['name']) ? $this->space_trim($header['name']) : NULL,
				'value' => isset($header['value']) ? $this->space_trim($header['value']) : NULL,
			);
			$header_id = isset($header['header_id']) ? $header['header_id'] : 0;
			if( $header_id > 0 ){
				$header_errors = $this->Headers->update($header_id, $upsert);
			}else{
				$header_errors = $this->Headers->insert($upsert);
			}
			if($header_errors){
				$errors['headers'][$k] = $header_errors;
			}
		}

		$search = array(
			'env_id' => $env->env_id,
		);
		$env->headers = $this->Headers->search($search);
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
			'method' => isset($this->_stream['method']) ? $this->space_trim($this->_stream['method']) : NULL,
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
		$env->headers = array();
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
