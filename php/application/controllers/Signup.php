<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Signup
 *
 * 新規登録
 */
class Signup extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->set();
	}
}
