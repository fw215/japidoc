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
	 * search
	 *
	 * 一覧情報を取得
	 *
	 * @param array $search
	 * @param bool $isCount
	 * @return object|bool
	 */
	public function search($search=false, $isCount=false)
	{
		$result = false;
		try{
			$select = array(
				'scenarios.scenario_id',
				'scenarios.project_id',
				'scenarios.name',
				'scenarios.description',
				'DATE_FORMAT(scenarios.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(scenarios.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(scenarios.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(scenarios.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'project_id':
							if( $this->validation->required($value) ){
								$this->db->where('scenarios.project_id', $value);
							}
							break;
						case 'page':
							if( $isCount == false && $this->validation->required($value) ){
								$offset = DEFAULT_PAGE_LIMIT * ($value - 1);
								$this->db->limit(DEFAULT_PAGE_LIMIT, $offset);
							}
							break;
						default:
							break;
					}
				}
			}
			$this->db->order_by('scenarios.name', 'ASC');

			if( $isCount === true ){
				$result = $this->db->from($this->_table)->count_all_results();
			}else{
				$result = $this->db->get($this->_table)->result();
			}
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
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
