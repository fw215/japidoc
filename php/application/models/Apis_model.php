<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apis_model extends CI_Model
{
	protected $_table;

	public function __construct() {
		parent::__construct();

		$this->_table = 'apis';
	}

	/**
	 * getList
	 *
	 * 一覧情報を取得
	 *
	 * @param array $search
	 * @param bool $isCount
	 * @return object|bool
	 */
	public function getList($search=false, $isCount=false)
	{
		$result = false;
		try{
			$select = array(
				'apis.api_id',
				'apis.project_id',
				'apis.name',
				'apis.description',
				'DATE_FORMAT(apis.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(apis.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(apis.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(apis.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
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

			$this->db->order_by('apis.name', 'ASC');

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
	 * get
	 *
	 * 1件取得
	 *
	 * @param array $search
	 * @return object|bool
	 */
	public function get($search=false)
	{
		$result = false;
		try{
			$select = array(
				'apis.api_id',
				'apis.project_id',
				'apis.name',
				'apis.description',
				'DATE_FORMAT(apis.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(apis.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(apis.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(apis.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'api_id':
							$this->db->where('api_id', $value);
							break;
						default:
							break;
					}
				}
			}

			$result = $this->db->get($this->_table)->row();
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
	 * @param int $api_id
	 * @param array $update
	 * @return object|bool
	 */
	public function update(int $api_id, array $update)
	{
		$result = false;
		try{
			$conditions = array(
				'api_id' => $api_id
			);
			$api = $this->get($conditions);
			if( !$api ){
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
					'api_id' => $this->db->insert_id()
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
	 * @param int $api_id
	 * @return bool
	 */
	public function delete(int $api_id)
	{
		$result = false;
		try{
			$conditions = array(
				'api_id' => $api_id
			);
			$api = $this->get($conditions);
			if( !$api ){
				return false;
			}

			$result = $this->db->delete($this->_table, $conditions);
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}
}
