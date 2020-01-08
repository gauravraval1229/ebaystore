<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . 'third_party/ebay-sdk/autoload.php';

use \DTS\eBaySDK\OAuth\Services;
use \DTS\eBaySDK\OAuth\Types;

class TokenData {

    public function getAccessToken($authCode)
    {
        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';

        $service = new Services\OAuthService([
            'credentials' => $config['sandbox']['credentials'],
            'ruName'      => $config['sandbox']['ruName']
        ]);
        
        $request = new Types\GetUserTokenRestRequest();
        $request->code = $authCode;
        
        $response = $service->getUserToken($request);
        
        $details = [];

        if ($response->getStatusCode() === 200) // authcode is correct and return required data
        {
            $details['status'] = 1;
            $details['data'] = json_decode($response);
        }
        else // on fail return error message.
        {
            $details['status'] = 0;
            $details['message'] = "Error in authrization token";
        }

        return $details;
    }
}