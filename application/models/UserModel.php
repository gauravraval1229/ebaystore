<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
    class UserModel extends CI_Model {
        
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

        public function login($email,$password){
            $this->db->select('*');
            $this->db->from('admin_users');
            $this->db->where('email',$email);
            $this->db->where('password',$password);
            $this->db->where('isDeleted',1); //1= acitve; 0=inactive
            return $this->db->get()->result_array();
        }

        public function tableData($tableName,$where=NULL)
        {
            $this->db->select('*');
            $this->db->from($tableName);

            if($where!="") //return specific where data otherwise return table's all data
            {
                $this->db->where($where);
            }

            return $this->db->get()->result_array();
        }

        public function insertData($tableName,$data)
        {
            return $this->db->insert($tableName,$data);
        }

        public function updateData($tableName,$data)
        {
            return $this->db->update($tableName,$data);
        }
    }