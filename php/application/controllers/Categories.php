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
		parent::__construct();
	}

	/**
	 * index
	 *
	 * 一覧
	 */
	public function index()
	{
		$this->set();
	}

	/**
	 * edit
	 *
	 * 登録・編集
	 */
	public function edit($category_id=0)
	{
		$search = array(
			'category_id' => $category_id,
		);

		$category = $this->Categories->get($search);
		if( $category ){
			$this->_data['category'] = $category;
		}
		$this->_data['category_id'] = $category_id;

		$this->set();
	}
}
