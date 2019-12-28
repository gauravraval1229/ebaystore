<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
    class userModel extends CI_Model {
        
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

        function login($email,$password){
            $this->db->select('*');
            $this->db->from('admin_users');
            $this->db->where('email',$email);
            $this->db->where('password',$password);
            $this->db->where('isDeleted',1); //1= acitve; 0=inactive
            return $this->db->get()->result_array();
        }
    }