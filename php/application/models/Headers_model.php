<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Headers_model extends CI_Model
{
	protected $_table;

	public function __construct() {
		parent::__construct();

		$this->_table = 'headers';
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
				'headers.header_id',
				'headers.env_id',
				'headers.name',
				'headers.value',
				'DATE_FORMAT(headers.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(headers.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(headers.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(headers.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'env_id':
							if( $this->validation->required($value) ){
								$this->db->where('env_id', $value);
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

			$this->db->order_by('headers.name', 'ASC');

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
				'headers.header_id',
				'headers.env_id',
				'headers.name',
				'headers.value',
				'DATE_FORMAT(headers.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(headers.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(headers.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(headers.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'header_id':
							$this->db->where('header_id', $value);
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
	 * @param int $header_id
	 * @param array $update
	 * @return object|bool
	 */
	public function update(int $header_id, array $update)
	{
		$result = false;
		try{
			$conditions = array(
				'header_id' => $header_id
			);
			$header = $this->get($conditions);
			if( !$header ){
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
					'header_id' => $this->db->insert_id()
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
	 * @param int $header_id
	 * @return bool
	 */
	public function delete(int $header_id)
	{
		$result = false;
		try{
			$conditions = array(
				'header_id' => $header_id
			);
			$header = $this->get($conditions);
			if( !$header ){
				return false;
			}

			$result = $this->db->delete($this->_table, $conditions);
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}

	/**
	 * eliminate
	 *
	 * 不要なHEADERを削除
	 *
	 * @param int $env_id
	 * @param array $IDs
	 * @return array
	 */
	public function eliminate($env_id, $IDs=false)
	{
		$result = false;
		try{
			$this->db->select('header_id');
			$this->db->where('env_id', $env_id);
			if( $IDs ){
				$this->db->where_not_in('header_id', $IDs);
			}
			$headers = $this->db->get($this->_table)->result();
			if( $headers ){
				foreach($headers as $header){
					$result[] = $this->delete($header->header_id);
				}
			}

		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}
}
