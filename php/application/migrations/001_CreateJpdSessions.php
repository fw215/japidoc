<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migrate
 *
 * マイグレーション実行
 * php <ENVIRONMENT>.php migrate <method> <param>
 */
class Migration_CreateJpdSessions extends CI_Migration
{
	/**
	 * up
	 *
	 * sessionsテーブル作成
	 */
	public function up()
	{
		$sql = "CREATE TABLE IF NOT EXISTS `jad_sessions` (";
		$sql .= "	`id` varchar(40) NOT NULL,";
		$sql .= "	`ip_address` varchar(45) NOT NULL,";
		$sql .= "	`timestamp` int(10) unsigned DEFAULT 0 NOT NULL,";
		$sql .= "	`data` blob NOT NULL,";
		$sql .= "	KEY `jad_sessions_timestamp` (`timestamp`)";
		$sql .= ");";
		$this->db->query($sql);
	}

	/**
	 * down
	 *
	 * sessionsテーブル削除
	 */
	public function down()
	{
		$this->dbforge->drop_table('jad_sessions', TRUE);
	}
}