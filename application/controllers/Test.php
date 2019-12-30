<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		$this->load->library('Userlogin');
		$this->load->helper('url');
	}

	public function index()
	{
		$data['productList'] = $this->userlogin->userDatas();
		//print_r($data['productList']);
    }
}