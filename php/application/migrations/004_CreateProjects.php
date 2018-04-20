<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_CreateProjects extends CI_Migration
{
	/**
	 * up
	 *
	 * projectsテーブル作成
	 */
	public function up()
	{
		$fields = array(
			'project_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
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
				'comment'        => '説明'
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_field('created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT "登録日時"');
		$this->dbforge->add_field('modified datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新日時"');

		$this->dbforge->add_key('project_id', TRUE);
		$this->dbforge->create_table('projects');
	}

	/**
	 * down
	 *
	 * projectsテーブル削除
	 */
	public function down()
	{
		$this->dbforge->drop_table('projects', TRUE);
	}
}