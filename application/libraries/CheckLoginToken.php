<?php

class CheckLoginToken {

	public function __construct() {

		$CI =& get_instance(); // create instance so use $CI instead of $this
		$CI->load->library('TokenData');
		$CI->load->model('UserModel','userModel');
		$CI->load->helper('url');
		$CI->load->library('session');

		if($CI->session->userdata['logged_in']['id']=="" || !$CI->session->userdata('logged_in')) { // if user is not logged in

			$CI->session->set_flashdata('error','Kindly login again');
			redirect(base_url('/'));
			exit();
		}
	}

	public function checkLogin() { // check user is logged in or not

		$CI =& get_instance(); // create instance so use $CI instead of $this

		if($CI->session->userdata['logged_in']['id']=="" || !$CI->session->userdata('logged_in')) { // if user is not logged in

			$CI->session->set_flashdata('error','Kindly login again');
			redirect(base_url('/'));
			exit();
		}
	}

	public function checkToken() { // check token expired or not

		$CI =& get_instance(); // create instance so use $CI instead of $this

		//$where = "";
		//$where = "expired_datetime >='".currentTime."'";

		$isTokenExpired = $CI->userModel->tableData('tokenmaster');

		//if(count($isTokenExpired) == 0 ) { // Token expired so need to generate new token
		if(strtotime($isTokenExpired[0]['expired_datetime'])<=strtotime(currentTime)) { // Token expired so need to generate new token

			redirect(base_url('ebay/TokenController/index'));
		}
		else { // token is not expired refresh that

			//redirect(base_url('ebay/TokenController/getRefreshToken'));
			
			$tokenData = $CI->tokendata->refreshToken($isTokenExpired[0]['refresh_token']);

			if($tokenData['status'] == 1) { // refresh token found

				$expiredTime = date("Y-m-d H:i:s", time() + $tokenData['data']->expires_in); // expand expire time.

				$data = array(
								"access_token" => $tokenData['data']->access_token,
								"expired_datetime" => $expiredTime
						);

				$CI->userModel->updateData('tokenmaster',$data); // update token data
				$CI->session->unset_userdata('userToken'); // unset userToken session so old data removed
				$CI->session->set_userdata('userToken',$tokenData['data']->access_token); // assign new token
			}
			else {
				echo $tokenData['message'];
			}
		}
	}
}