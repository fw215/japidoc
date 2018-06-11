<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_CreatePlans extends CI_Migration
{
	/**
	 * up
	 *
	 * plansテーブル作成
	 */
	public function up()
	{
		$fields = array(
			'plan_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
				'comment'        => 'プランID'
			),
			'scenario_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'comment'        => 'シナリオID'
			),
			'env_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'comment'        => '環境ID'
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_field('created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT "登録日時"');
		$this->dbforge->add_field('modified datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新日時"');

		$this->dbforge->add_key('plan_id', TRUE);
		$this->dbforge->create_table('plans');
	}

	/**
	 * down
	 *
	 * plansテーブル削除
	 */
	public function down()
	{
		$this->dbforge->drop_table('plans', TRUE);
	}
}