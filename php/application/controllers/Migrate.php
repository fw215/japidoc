<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migrate
 * 
 * マイグレーション実行
 * php <ENVIRONMENT>.php migrate <method> <param>
 */
class Migrate extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		/**
		 * HTTPアクセスを抑止
		 */
		if(!$this->input->is_cli_request()) {
			show_404();
			exit;
		}
		$this->load->library('migration');
	}

	/**
	 * current
	 * 
	 * migration_versionに指定したバージョンまでマイグレーション
	 */
	function current()
	{
		if ($this->migration->current()) {
			log_message('error', 'Migration Success.');
		} else {
			log_message('error', $this->migration->error_string());
		}
	}

	/**
	 * rollback
	 * 
	 * 指定したバージョンまでロールバック
	 * migrate rollback 0
	 */
	function rollback($version=null)
	{
		if ( !isset($version) ) {
			log_message('error', 'Version is null.');
		} elseif ($this->migration->version($version)) {
			log_message('error', 'Migration Success.');
		} else {
			log_message('error', $this->migration->error_string());
		}
	}

	/**
	 * latest
	 * 
	 * 最新のバージョンまでマイグレーション
	 */
	function latest()
	{
		if ($this->migration->latest()) {
			log_message('error', 'Migration Success.');
		} else {
			log_message('error', $this->migration->error_string());
		}
	}
}