<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Envs_model extends CI_Model
{
	protected $_table;

	public function __construct() {
		parent::__construct();

		$this->_table = 'envs';
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
				'envs.env_id',
				'envs.api_id',
				'envs.name',
				'envs.description',
				'envs.method',
				'envs.url',
				'envs.body',
				'envs.is_body',
				'DATE_FORMAT(envs.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(envs.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(envs.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(envs.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'api_id':
							if( $this->validation->required($value) ){
								$this->db->where('api_id', $value);
							}
							break;
						case 'page':
							if( $isCount == false && $this->validation->required($value) ){
								if($value > 0){
									$offset = DEFAULT_PAGE_LIMIT * ($value - 1);
									$this->db->limit(DEFAULT_PAGE_LIMIT, $offset);
								}
							}
							break;
						default:
							break;
					}
				}
			}

			$this->db->order_by('envs.name', 'ASC');

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
				'envs.env_id',
				'envs.api_id',
				'envs.name',
				'envs.description',
				'envs.method',
				'envs.url',
				'envs.body',
				'envs.is_body',
				'DATE_FORMAT(envs.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(envs.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(envs.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(envs.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'env_id':
							$this->db->where('env_id', $value);
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
	 * @param int $env_id
	 * @param array $update
	 * @return object|bool
	 */
	public function update(int $env_id, array $update)
	{
		$result = false;
		try{
			$conditions = array(
				'env_id' => $env_id
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
					'env_id' => $this->db->insert_id()
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
	 * @param int $env_id
	 * @return bool
	 */
	public function delete(int $env_id)
	{
		$result = false;
		try{
			$conditions = array(
				'env_id' => $env_id
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
