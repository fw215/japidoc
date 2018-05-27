<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Categories
 *
 * カテゴリ
 */
class Categories extends MY_Controller
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

		$this->_api['categories'] = $this->Categories->search($search);
		$this->_api['count'] = $this->Categories->search($search, TRUE);
		$this->_api['pages'] = ceil($this->_api['count'] / DEFAULT_PAGE_LIMIT);

		$this->json();
	}

	/**
	 * get
	 *
	 * 1件取得
	 */
	public function get($category_id=0)
	{
		$search = array(
			'category_id' => $category_id,
		);

		$category = $this->Categories->get($search);
		if( !$category ){
			show_404();
		}
		$this->_api['category'] = $category;

		$this->json();
	}

	/**
	 * put
	 *
	 * 1件更新
	 */
	public function put($category_id=0)
	{
		$update = array(
			'name' => isset($this->_stream['name']) ? $this->space_trim($this->_stream['name']) : NULL,
			'description' => isset($this->_stream['description']) ? $this->space_trim($this->_stream['description']) : NULL,
		);
		$errors = $this->Categories_lib->register_validation( $update );
		if( $errors ){
			$this->_api['code'] = API_BAD_REQUEST;
			$this->_api['errors'] = $errors;
			$this->json();
		}

		$category = $this->Categories->update($category_id, $update);
		if( !$category ){
			show_404();
		}
		$this->_api['category'] = $category;

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
		$errors = $this->Categories_lib->register_validation( $insert );
		if( $errors ){
			$this->_api['code'] = API_BAD_REQUEST;
			$this->_api['errors'] = $errors;
			$this->json();
		}

		$category = $this->Categories->insert($insert);
		if( !$category ){
			show_404();
		}
		$this->_api['category'] = $category;

		$this->json();
	}

	/**
	 * delete
	 *
	 * 1件削除
	 */
	public function delete($category_id=0)
	{
		$result = $this->Categories->delete($category_id);
		if( !$result ){
			show_404();
		}

		$this->json();
	}
}
