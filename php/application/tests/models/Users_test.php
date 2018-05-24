<?php

class Users_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();

		$this->CI->load->library('migration');
		$this->CI->migration->version(0);
		$this->CI->migration->latest();

		$this->CI->load->model('Users_model', 'Users');


	}

	/**
	 * @test
	 */
	public function search()
	{
		$result = $this->CI->Users->search();
		$this->assertEmpty($result);
	}

	/**
	 * @test
	*/
	public function get()
	{
		$result = $this->CI->Users->get();
		$this->assertNull($result);
	}

	/**
	 * @test
	*/
	public function update()
	{
		$data = array();
		$result = $this->CI->Users->update(0, $data);
		$this->assertFalse($result);
	}

	/**
	 * @test
	*/
	public function insert()
	{
		$data = array();
		$result = $this->CI->Users->insert($data);
		$this->assertFalse($result);

		$data = array('password' => 'password');
		$result = $this->CI->Users->insert($data);
		$this->assertEquals(1, $result->user_id);
	}
}
