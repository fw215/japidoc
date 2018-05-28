<?php

class Apis_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();

		$this->CI->load->library('migration');
		$this->CI->migration->version(0);
		$this->CI->migration->latest();

		$this->CI->load->model('Apis_model', 'Apis');
	}

	/**
	 * @test
	 */
	public function search()
	{
		$result = $this->CI->Apis->search();
		$this->assertEmpty($result);
	}

	/**
	 * @test
	*/
	public function get()
	{
		$result = $this->CI->Apis->get();
		$this->assertNull($result);
	}

	/**
	 * @test
	*/
	public function update()
	{
		$data = array();
		$result = $this->CI->Apis->update(0, $data);
		$this->assertFalse($result);
	}

	/**
	 * @test
	*/
	public function insert()
	{
		$data = array('name' => 'name');
		$result = $this->CI->Apis->insert($data);
		$this->assertEquals('name', $result->name);
	}
}
