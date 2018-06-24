<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_CreateScenarios extends CI_Migration
{
	/**
	 * up
	 *
	 * scenariosテーブル作成
	 */
	public function up()
	{
		$fields = array(
			'scenario_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
				'comment'        => 'シナリオID'
			),
			'project_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'comment'        => 'プロジェクトID'
			),
			'name' => array(
				'type'           => 'varchar',
				'constraint'     => '255',
				'null'           => FALSE,
				'comment'        => '名称'
			),
			'description' => array(
				'type'           => 'text',
				'null'           => FALSE,
				'comment'        => '概要'
			),
			'category_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'comment'        => 'カテゴリID'
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_field('created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT "登録日時"');
		$this->dbforge->add_field('modified datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新日時"');

		$this->dbforge->add_key('scenario_id', TRUE);
		$this->dbforge->create_table('scenarios');
	}

	/**
	 * down
	 *
	 * scenariosテーブル削除
	 */
	public function down()
	{
		$this->dbforge->drop_table('scenarios', TRUE);
	}
}