<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Login
 *
 * ログイン
 */
class Login extends MY_Controller
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
