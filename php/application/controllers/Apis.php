<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Apis
 *
 * API
 */
class Apis extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * index
	 *
	 * 一覧
	 *
	 * @param int $project_id
	 */
	public function index($project_id=0)
	{
		$search = array(
			'project_id' => $project_id,
		);

		$project = $this->Projects->get($search);
		if( !$project ){
			show_404();
		}
		$this->_data['project'] = $project;
		$this->set();
	}

	/**
	 * edit
	 *
	 * 登録・編集
	 */
	public function edit($project_id=0, $api_id=0)
	{
		$search = array(
			'project_id' => $project_id,
		);

		$project = $this->Projects->get($search);
		if( !$project ){
			show_404();
		}
		$this->_data['project'] = $project;
		$this->_data['project_id'] = $project_id;
		$this->_data['api_id'] = $api_id;

		$this->_data['categories'] = $this->Categories->search();

		$this->set();
	}
}
