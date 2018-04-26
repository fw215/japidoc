<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Log extends CI_Log
{
	public $_levels = array(
		'ERROR' => '1',
		'INFO'  => '2',
		'DEBUG' => '3',
		'ALL'   => '4'
	);

	public function __construct()
	{
		parent::__construct();
	}

	protected function _format_line($level, $date, $message)
	{
		return sprintf("%-5s - %s --> %s\n", $level, $date, $message);
	}
}
