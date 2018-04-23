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
		parent::__construct();
	}

	public function index()
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
}
