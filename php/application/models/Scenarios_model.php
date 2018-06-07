<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scenarios_model extends CI_Model
{
	protected $_table;

	public function __construct() {
		parent::__construct();

		$this->_table = 'scenarios';
	}

	/**
	 * update
	 *
	 * 1件更新
	 *
	 * @param int $scenario_id
	 * @param array $update
	 * @return object|bool
	 */
	public function update(int $scenario_id, array $update)
	{
		$result = false;
		try{
			$conditions = array(
				'scenario_id' => $scenario_id
			);
			$env = $this->get($conditions);
			if( !$env ){
				return false;
			}

			if( $this->db->update($this->_table, $update, $conditions) ){
				$result = $this->get($conditions);
			}
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}

	/**
	 * insert
	 *
	 * 1件登録
	 *
	 * @param array $insert
	 * @return object|bool
	 */
	public function insert(array $insert)
	{
		$result = false;
		try{
			if( $this->db->insert($this->_table, $insert) ){
				$conditions = array(
					'scenario_id' => $this->db->insert_id()
				);
				$result = $this->get($conditions);
			}
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}

	/**
	 * delete
	 *
	 * 1件削除
	 *
	 * @param int $scenario_id
	 * @return bool
	 */
	public function delete(int $scenario_id)
	{
		$result = false;
		try{
			$conditions = array(
				'scenario_id' => $scenario_id
			);
			$env = $this->get($conditions);
			if( !$env ){
				return false;
			}

			$result = $this->db->delete($this->_table, $conditions);
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}
}
