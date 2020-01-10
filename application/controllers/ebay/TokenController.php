<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TokenController extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		$this->load->library('TokenData');
		$this->load->helper('url');
        $this->load->model('UserModel','userModel');
        $this->load->library('session');
	}

    public function index()
    {
        // client id & redirect uri define in constant.php

    	$url = "https://auth.sandbox.ebay.com/oauth2/authorize?client_id=".appId."&response_type=code&redirect_uri=".ruName."&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/buy.order.readonly https://api.ebay.com/oauth/api_scope/buy.guest.order https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.marketplace.insights.readonly https://api.ebay.com/oauth/api_scope/commerce.catalog.readonly https://api.ebay.com/oauth/api_scope/buy.shopping.cart https://api.ebay.com/oauth/api_scope/buy.offer.auction https://api.ebay.com/oauth/api_scope/commerce.identity.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.email.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.phone.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.address.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.name.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.status.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.item.draft https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/sell.item";

        redirect($url); // redirect on i-agree page of ebay
    }

    public function newToken()
    {
        if($_GET['code']!="")
        {
            $authCode = urldecode($_GET['code']); // get code is already encoded so need to decode that.

            // get user access token
            $userAccessToken = $this->tokendata->getAccessToken($authCode);

            if($userAccessToken['status'] == 1) // token generated successfully.
            {
                $createdTime = date('Y-m-d H:i:s'); // token creation time
                $expiredTime = date("Y-m-d H:i:s", time() + $userAccessToken['data']->expires_in); // add expired time so we will get token expire time. approximately token expired in 2 hours from creation time.

                $authToken  =   md5(date('Y-m-d H:i:s'));
                
                $data = array(
                            "created" => $createdTime,
                            "access_token" => $userAccessToken['data']->access_token,
                            "token_type" => $userAccessToken['data']->token_type,
                            "expires_in" => $userAccessToken['data']->expires_in, // this one is in seconds
                            "refresh_token" => $userAccessToken['data']->refresh_token,
                            "refresh_token_expires_in" => $userAccessToken['data']->refresh_token_expires_in,
                            "expired_datetime" => $expiredTime
                        );

                $this->userModel->updateData('tokenmaster',$data); // insert data in table for use token data

                $this->session->unset_userdata('userToken'); // unset userToken session so old data removed
                $this->session->unset_userdata('Admin_Auth_Token');


                $this->session->set_userdata('userToken',$userAccessToken['data']->access_token); // assign new token in userToken.
                $this->session->set_userdata('Admin_Auth_Token',$authToken); 

                redirect(base_url('ebay/ProductController/index'));
            }
            else
            {
                echo $userAccessToken['message'];
            }            
        }
        else
        {
            echo "Some error in token generation";
        }
    }

    public function failToken()
    {
        echo "Some error in token generation";
    }
}