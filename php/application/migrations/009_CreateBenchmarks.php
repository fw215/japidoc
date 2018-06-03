<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_CreateBenchmarks extends CI_Migration
{
	/**
	 * up
	 *
	 * benchmarksテーブル作成
	 */
	public function up()
	{
		$fields = array(
			'benchmark_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
				'comment'        => 'ベンチマークID'
			),
			'env_id' => array(
				'type'           => 'bigint',
				'unsigned'       => TRUE,
				'comment'        => '環境ID'
			),
			'times' => array(
				'type'           => 'int',
				'unsigned'       => TRUE,
				'null'           => FALSE,
				'comment'        => '回数'
			),
			'shortest' => array(
				'type'           => 'decimal',
				'constraint'     => '20,17',
				'null'           => FALSE,
				'comment'        => '最短'
			),
			'longest' => array(
				'type'           => 'decimal',
				'constraint'     => '20,17',
				'null'           => FALSE,
				'comment'        => '最長'
			),
			'average' => array(
				'type'           => 'decimal',
				'constraint'     => '20,17',
				'null'           => FALSE,
				'comment'        => '平均'
			),
			'results' => array(
				'type'           => 'text',
				'null'           => FALSE,
				'comment'        => '結果'
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_field('created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT "登録日時"');
		$this->dbforge->add_field('modified datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新日時"');

		$this->dbforge->add_key('benchmark_id', TRUE);
		$this->dbforge->create_table('benchmarks');
	}

	/**
	 * down
	 *
	 * benchmarksテーブル削除
	 */
	public function down()
	{
		$this->dbforge->drop_table('benchmarks', TRUE);
	}
}