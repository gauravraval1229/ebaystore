<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('UserModel','userModel');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->load->view('login');
	}

	public function login()
	{
		$email = $this->input->post("email");
		$password = md5($this->input->post("password"));

		$this->form_validation->set_rules("email", "email", "trim|required");
		$this->form_validation->set_rules("password", "password", "trim|required");
		if ($this->form_validation->run() == FALSE) /**** Validation Fails ****/
		{
			$this->session->set_flashdata('error','Invalid Login Credential!');
			redirect(base_url('/'));
		}
		else
		{
			$checkAdmin = $this->userModel->login($email,$password);

			if (count($checkAdmin) > 0) // emailid is exist and admin is active
			{
				$session_arr = array(
					"id" => $checkAdmin[0]['id'],
					"firstName" => $checkAdmin[0]['firstName'],
					"lastName" => $checkAdmin[0]['lastName'],
					"email" => $checkAdmin[0]['email'],
					"mobile" => $checkAdmin[0]['mobile'],
				);

				$this->session->set_userdata('logged_in',$session_arr);

				//redirect(base_url('ProductController/index'));
				redirect(base_url('TokenController/index'));
			}
			else
			{
				$this->session->set_flashdata('error','Invalid Login Credential!');
				redirect(base_url('/'));
			}
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('success','Logout Successfully.');
		redirect(base_url('/'));
	}
}