<?php

class Projects_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();

		$this->CI->load->library('migration');
		$this->CI->migration->version(0);
		$this->CI->migration->latest();

		$this->CI->load->model('Projects_model', 'Projects');
	}

	/**
	 * @test
	 */
	public function search()
	{
		$result = $this->CI->Projects->search();
		$this->assertEmpty($result);
	}

	/**
	 * @test
	*/
	public function get()
	{
		$result = $this->CI->Projects->get();
		$this->assertNull($result);
	}

	/**
	 * @test
	*/
	public function update()
	{
		$data = array();
		$result = $this->CI->Projects->update(0, $data);
		$this->assertFalse($result);
	}

	/**
	 * @test
	*/
	public function insert()
	{
		$data = array('name' => 'name');
		$result = $this->CI->Projects->insert($data);
		$this->assertEquals('name', $result->name);
	}
}
