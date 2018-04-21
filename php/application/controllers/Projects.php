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

	/**
	 * index
	 *
	 * 一覧
	 */
	public function index()
	{
		$this->set();
	}
}
