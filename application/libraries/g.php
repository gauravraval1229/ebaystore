<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . 'third_party/ebay-sdk/autoload.php';
/*use \DTS\eBaySDK\OAuth\Services;
use \DTS\eBaySDK\OAuth\Types;*/

use \DTS\eBaySDK\OAuth\Services as OauthService;
use \DTS\eBaySDK\OAuth\Types as OauthType;

class Userlogin {

   /* public function userDatas()
    {
        require_once APPPATH . 'third_party/ebay-sdk/autoload.php';
 
        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';
                  
        $service = new Services\OAuthService([
         'credentials' => $config['sandbox']['credentials'],
         'ruName'      => $config['sandbox']['ruName'],
         'sandbox'     => true
        ]);
         
        $request = new Types\GetUserTokenRestRequest();
        //$request->code = $_GET['code'];
         
        $response = $service->getUserToken($request);

        echo "<pre>";
        print_r($response);
         
         printf(
             "%s\n%s\n%s\n%s\n\n",
             $response->access_token,
             $response->token_type,
             $response->expires_in,
             $response->refresh_token
         );
    }*/

    public function userDatas()
    {

        require_once APPPATH . 'third_party/ebay-sdk/autoload.php';
 
        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';

        $service = new OauthService\OAuthService([
            'credentials' => $config['sandbox']['credentials'],
            'ruName'      => $config['sandbox']['ruName'],
            'sandbox'     => true
        ]);

        $oauthParam = [
          'client_id' => $config['sandbox']['credentials']['appId'],
          'redirect_uri' => 'Xune_Ltd-XuneLtd-XuneSaa-fmhjitmw',
          'response_type' => 'code',
          'scope' => 'https://api.ebay.com/oauth/api_scope'
        ];
        $urlParam = '';
        $query = [];
        foreach($oauthParam as $key => $param) {
            $query[] = "$key=$param";
        }
        $urlParam = '?' . implode('&', $query);

        //$url = 'https://signin.sandbox.ebay.com/authorize' . $urlParam;
        $url = 'https://auth.sandbox.ebay.com/oauth2/authorize' . $urlParam;
        @session_start();

        /*`https://signin.sandbox.ebay.com/authorize?
        client_id=<your-client-id-value>&
        redirect_uri=<your-RuName-value>&
        response_type=code&
        scope=https%3A%2F%2Fapi.ebay.com%2Foauth%2Fapi_scope%2Fsell.account%20
        https%3A%2F%2Fapi.ebay.com%2Foauth%2Fapi_scope%2Fsell.inventory`*/

        if(isset($_SESSION['ebay_oauth_token'])) 
        {
            $token = $_SESSION['ebay_oauth_token']['code'];
        }
        else 
        {
            if(isset($_GET['code'])) 
            {
                $token = $_GET['code'];
                $_SESSION['ebay_oauth_token']['code'] = $token;

                $request = new OauthType\GetUserTokenRestRequest();
                $request->code = $token;

                $response = $service->getUserToken($request);

                if ($response->getStatusCode() !== 200) 
                {
                    //Error
                } 
                else 
                {
                    $_SESSION['ebay_oauth_token']['access_token'] = $response->access_token;
                }
            }
            else 
            {
                @header('location: ' . $url);
            }

        }

echo $userOauthToken = $_SESSION['ebay_oauth_token']['access_token'];
    }
}