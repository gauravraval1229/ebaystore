<?php

class CheckLoginToken {

    public function checkCredential()
    {
        $CI =& get_instance(); // create instance so use $CI instead of $this

        if($CI->session->userdata['logged_in']['id']=="") // if user is not logged in
        {
            $CI->session->set_flashdata('error','Kindly login again');
            redirect(base_url('/'));
            exit();
        }

        // check token expired or not

        $where = "";
        $where = "expired_datetime >='".currentTime."'";

        $isTokenExpired = $CI->userModel->tableData('tokenmaster',$where);
        if(count($isTokenExpired) == 0 ) // Token expired and need to generate new token
        {
            redirect(base_url('ebay/TokenController/index'));
        }
    }
}