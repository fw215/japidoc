<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Benchmarks_model extends CI_Model
{
	protected $_table;

	public function __construct() {
		parent::__construct();

		$this->_table = 'benchmarks';
	}

	/**
	 * recent
	 *
	 * 最近の一覧情報を取得
	 *
	 * @return object|bool
	 */
	public function recent()
	{
		$result = false;
		try{
			$select = array(
				'benchmarks.benchmark_id',
				'benchmarks.env_id',
				'benchmarks.times',
				'benchmarks.shortest',
				'benchmarks.longest',
				'benchmarks.average',
				'DATE_FORMAT(benchmarks.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(benchmarks.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(benchmarks.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(benchmarks.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
				'projects.project_id',
				'projects.name',
				'projects.description',
				'apis.api_id AS api_id',
				'apis.name AS api_name',
				// 'envs.name AS env_name',
			);
			$this->db->select($select);

			$this->db->join('envs', 'benchmarks.env_id = envs.env_id');
			$this->db->join('apis', 'apis.api_id = envs.api_id');
			$this->db->join('projects', 'projects.project_id = apis.project_id');
			$this->db->order_by('benchmarks.modified', 'DESC');
			$this->db->limit(5);

			$result = $this->db->get($this->_table)->result();
		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
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
				'benchmarks.benchmark_id',
				'benchmarks.env_id',
				'benchmarks.times',
				'benchmarks.shortest',
				'benchmarks.longest',
				'benchmarks.average',
				'DATE_FORMAT(benchmarks.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(benchmarks.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(benchmarks.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(benchmarks.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
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

			$this->db->order_by('benchmarks.created', 'DESC');

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
				'benchmarks.benchmark_id',
				'benchmarks.env_id',
				'benchmarks.times',
				'benchmarks.shortest',
				'benchmarks.longest',
				'benchmarks.average',
				'DATE_FORMAT(benchmarks.created, "%Y/%m/%d") as created_ymd',
				'DATE_FORMAT(benchmarks.created, "%Y/%m/%d %H:%i:%S") as created_ymd_his',
				'DATE_FORMAT(benchmarks.modified, "%Y/%m/%d") as modified_ymd',
				'DATE_FORMAT(benchmarks.modified, "%Y/%m/%d %H:%i:%S") as modified_ymd_his',
			);
			$this->db->select($select);

			if($search && is_array($search)){
				foreach($search as $column => $value){
					switch ($column) {
						case 'env_id':
							$this->db->where('env_id', $value);
							break;
						case 'benchmark_id':
							$this->db->where('benchmark_id', $value);
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
	 * @param int $benchmark_id
	 * @param array $update
	 * @return object|bool
	 */
	public function update(int $benchmark_id, array $update)
	{
		$result = false;
		try{
			$conditions = array(
				'benchmark_id' => $benchmark_id
			);
			$benchmark = $this->get($conditions);
			if( !$benchmark ){
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
					'benchmark_id' => $this->db->insert_id()
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
	 * @param int $benchmark_id
	 * @return bool
	 */
	public function delete(int $benchmark_id)
	{
		$result = false;
		try{
			$conditions = array(
				'benchmark_id' => $benchmark_id
			);
			$benchmark = $this->get($conditions);
			if( !$benchmark ){
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
	 * 不要なBenchmarkを削除
	 *
	 * @param int $env_id
	 * @param array $IDs
	 * @return array
	 */
	public function eliminate($env_id, $IDs=false)
	{
		$result = false;
		try{
			$this->db->select('benchmark_id');
			$this->db->where('env_id', $env_id);
			if( $IDs ){
				$this->db->where_not_in('benchmark_id', $IDs);
			}
			$benchmarks = $this->db->get($this->_table)->result();
			if( $benchmarks ){
				foreach($benchmarks as $form){
					$result[] = $this->delete($form->benchmark_id);
				}
			}

		}catch(Exception $e){
			log_message('error', $e->getMessage());
		}
		return $result;
	}
}
