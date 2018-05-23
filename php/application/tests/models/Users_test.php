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
	// public function get()
	// {
	// 	$hoge = "";
	// }
}
