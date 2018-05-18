<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Minimum Byte
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function min_byte($str, $val)
	{
		if ( !is_numeric($val) ){
			return FALSE;
		}

		return ($val <= strlen($str));
	}

	/**
	 * Max Byte
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function max_byte($str, $val)
	{
		if ( !is_numeric($val) ){
			return FALSE;
		}

		return ($val >= strlen($str));
	}
}