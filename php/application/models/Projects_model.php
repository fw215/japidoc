<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects_model extends CI_Model
{
	protected $_table;

	public function __construct() {
		parent::__construct();

		$this->_table = 'projects';
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
				'projects.project_id',
				'projects.name',
				'projects.description',
				'DATE_FORMAT(projects.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(projects.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(projects.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(projects.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
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

			$this->db->order_by('projects.name', 'ASC');

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
				'projects.project_id',
				'projects.name',
				'projects.description',
				'DATE_FORMAT(projects.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(projects.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(projects.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(projects.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'project_id':
							$this->db->where('project_id', $value);
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
	 * @param int $project_id
	 * @param array $update
	 * @return object|bool
	 */
	public function update(int $project_id, array $update)
	{
		$result = false;
		try{
			$conditions = array(
				'project_id' => $project_id
			);
			$project = $this->get($conditions);
			if( !$project ){
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
					'project_id' => $this->db->insert_id()
				);
				$result = $this->get($conditions);
			}
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}
}
