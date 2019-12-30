<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . 'third_party/ebay-sdk/autoload.php';
//use \DTS\eBaySDK\OAuth\Services;
//use \DTS\eBaySDK\OAuth\Types;

use \DTS\eBaySDK\OAuth\Services as OauthService;
use \DTS\eBaySDK\OAuth\Types as OauthType;

class Userlogin {

    //public function userDatas()
    //{
        /*$config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php'; // Pulling from external config file - It does work!
 
        $appID = $config['sandbox']['credentials']['appId'];  // These are valid values
        $certID = $config['sandbox']['credentials']['certId'];
        $ruName = $config['sandbox']['ruName'];

        $endpoint = 'https://api.sandbox.ebay.com/identity/v1/oauth2/token';  // URL to call

        // Create the request to be POSTed

        $request = "grant_type=authorization_code&code=".urlencode($_GET['code'])."&redirect_uri=".$ruName;  // I have tried urlencode, no urlencode, etc

        // Set up the HTTP headers
        $headers = [
             'Content-Type: application/x-www-form-urlencoded',
             'Authorization: Basic '.base64_encode($appID.":".$certID)
         ];

        $session  = curl_init($endpoint);                    // create a curl session
        curl_setopt($session, CURLOPT_POST, true);           // POST request type
        curl_setopt($session, CURLOPT_HTTPHEADER, $headers); // set headers using $headers array
        curl_setopt($session, CURLOPT_POSTFIELDS, $request); // set the body of the POST
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // return values as a string, not to std out

        $response = curl_exec($session);                     // send the request
        curl_close($session);                                // close the session

        echo $response;*/





        /*require_once APPPATH . 'third_party/ebay-sdk/autoload.php';
 
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
         );*/
    //}

    public function userDatas()
    {

        //require_once APPPATH . 'third_party/ebay-sdk/autoload.php';
 
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
          'scope' => 'https://api.ebay.com/oauth2/api_scope'
        ];
        $urlParam = '';
        $query = [];
        foreach($oauthParam as $key => $param) {
            $query[] = "$key=$param";
        }
        $urlParam = '?' . implode('&', $query);

        //$url = 'https://signin.sandbox.ebay.com/authorize' . $urlParam;
        $url = 'https://auth.sandbox.ebay.com/oauth2/authorize' . $urlParam;
        
        if(isset($_GET['code'])) 
        {
            $token = $_GET['code'];

            $request = new OauthType\GetUserTokenRestRequest();
            $request->code = $token;

            $response = $service->getUserToken($request);
            print_r($response);

        }
        else 
        {
            echo "code na malyo.";
           //@header('location: ' . $url);
        }
    }
}