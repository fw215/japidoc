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
		$env->forms = $this->Forms->search($search);
		$env->benchmarks = $this->Benchmarks->search($search);
		$env->is_body = (int)$env->is_body;
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
			'category_id' => isset($this->_stream['category_id']) ? $this->space_trim($this->_stream['category_id']) : NULL,
			'method' => isset($this->_stream['method']) ? $this->space_trim($this->_stream['method']) : NULL,
			'url' => isset($this->_stream['url']) ? $this->space_trim($this->_stream['url']) : NULL,
			'body' => isset($this->_stream['body']) ? $this->space_trim($this->_stream['body']) : NULL,
			'is_body' => isset($this->_stream['is_body']) ? $this->space_trim($this->_stream['is_body']) : NULL,
		);
		$errors = $this->Envs_lib->register_validation( $update );

		// HEADER
		$headers = isset($this->_stream['headers']) ? (array)$this->_stream['headers'] : array();
		$not_delete_headers = array();
		foreach($headers as $k => $header){
			$upsert = array(
				'env_id' => $env_id,
				'name' => isset($header['name']) ? $this->space_trim($header['name']) : NULL,
				'value' => isset($header['value']) ? $this->space_trim($header['value']) : NULL,
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
		// FORMS
		$forms = isset($this->_stream['forms']) ? (array)$this->_stream['forms'] : array();
		$not_delete_forms = array();
		foreach($forms as $k => $form){
			$upsert = array(
				'env_id' => $env_id,
				'name' => isset($form['name']) ? $this->space_trim($form['name']) : NULL,
				'value' => isset($form['value']) ? $this->space_trim($form['value']) : NULL,
			);
			$form_errors = $this->Forms_lib->register_validation( $upsert );
			if($form_errors){
				$errors['forms'][$k] = $form_errors;
			}else{
				$form_id = isset($form['form_id']) ? $form['form_id'] : 0;
				if( $form_id > 0 ){
					$not_delete_forms[] = $form_id;
				}
			}
		}
		if( $errors ){
			$errors['api_id'] = isset($errors['api_id']) ? $errors['api_id'] : NULL;
			$errors['category_id'] = isset($errors['category_id']) ? $errors['category_id'] : NULL;
			$errors['method'] = isset($errors['method']) ? $errors['method'] : NULL;
			$errors['url'] = isset($errors['url']) ? $errors['url'] : NULL;
			$errors['body'] = isset($errors['body']) ? $errors['body'] : NULL;
			$errors['is_body'] = isset($errors['is_body']) ? $errors['is_body'] : NULL;
			$errors['forms'] = isset($errors['forms']) ? $errors['forms'] : array();
			$errors['headers'] = isset($errors['headers']) ? $errors['headers'] : array();
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
				'env_id' => isset($header['env_id']) ? $header['env_id'] : NULL,
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
		// FORM
		$this->Forms->eliminate($env_id, $not_delete_forms);
		foreach($forms as $k => $form){
			$upsert = array(
				'env_id' => isset($form['env_id']) ? $form['env_id'] : NULL,
				'name' => isset($form['name']) ? $this->space_trim($form['name']) : NULL,
				'value' => isset($form['value']) ? $this->space_trim($form['value']) : NULL,
			);
			$form_id = isset($form['form_id']) ? $form['form_id'] : 0;
			if( $form_id > 0 ){
				$form_errors = $this->Forms->update($form_id, $upsert);
			}else{
				$form_errors = $this->Forms->insert($upsert);
			}
			if($form_errors){
				$errors['forms'][$k] = $form_errors;
			}
		}

		$search = array(
			'env_id' => $env->env_id,
		);
		$env->headers = $this->Headers->search($search);
		$env->forms = $this->Forms->search($search);
		$env->is_body = (int)$env->is_body;
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
			'category_id' => isset($this->_stream['category_id']) ? $this->space_trim($this->_stream['category_id']) : NULL,
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
		$env->forms = array();
		$env->benchmarks = array();
		$env->is_body = (int)$env->is_body;
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
		$this->Headers->eliminate($env_id);
		$this->Forms->eliminate($env_id);
		$this->Benchmarks->eliminate($env_id);

		$this->json();
	}
}
