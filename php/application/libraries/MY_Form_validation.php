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

	/**
	 * is_json
	 *
	 * JSON形式のチェック
	 *
	 * @param string $str
	 */
	protected function is_json($str)
	{
		return is_string($str) && is_array(json_decode($str, TRUE)) && (json_last_error() == JSON_ERROR_NONE) ? TRUE : FALSE;
	}
}