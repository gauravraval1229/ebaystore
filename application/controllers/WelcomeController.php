<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WelcomeController extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();

		$this->load->model('UserModel','userModel');
		$this->load->helper('url');

		if($this->session->userdata['logged_in']['id']=="") // if user is not logged in
        {
            $this->session->set_flashdata('error','Kindly login again');
            redirect(base_url('/'));
            exit();
        }
	}

    public function index()
    {
       	$data['page'] = 'welcome/index';
        $this->load->view('includes/template', $data);
    }
}