<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . 'third_party/ebay-sdk/autoload.php';
use \DTS\eBaySDK\Inventory\Services;
use \DTS\eBaySDK\Inventory\Types;
use \DTS\eBaySDK\Inventory\Enums;

class Inventory {

    public function listInventory() 
    {
        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';
        
        $service = new Services\InventoryService([
            'authorization' => $config['sandbox']['oauthUserToken'],
            'requestLanguage'  => 'en-US',
            'responseLanguage' => 'en-US'
        ]);
        
        $request = new Types\GetInventoryItemsRestRequest();

        //$request->offset = '0';
        //$request->limit = '2';
        
        $response = $service->getInventoryItems($request);
        
        $product =[];
        if ($response->getStatusCode() === 200) {
            $product = json_decode($response);
        }
        return $product;
    }

    public function deleteInventory($sku) 
    {
        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';
        /**
         * Create the service object.
         */
        $service = new Services\InventoryService([
            'authorization' => $config['sandbox']['oauthUserToken']
        ]);
        /**
         * Create the request object.
         */
        $request = new Types\DeleteInventoryItemRestRequest();
        
        /**
         * Note how URI parameters are just properties on the request object.
         */
        $request->sku = "$sku";
        $response = $service->deleteInventoryItem($request);

        if($response->getStatusCode()== "204" || $response->getStatusCode()=="200")
        {
            $details['status'] =1;
        }
        else
        {
            $details['status'] =0;
        }
        return $details;
    }

    public function editInventory($sku) 
    {
        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';
        
        $service = new Services\InventoryService([
            'authorization' => $config['sandbox']['oauthUserToken']
        ]);
        
        $request = new Types\GetInventoryItemRestRequest();
        
        $request->sku = $sku;
        
        $response = $service->getInventoryItem($request);
                
        $product =[];
        if ($response->getStatusCode() === 200) {
            $product = json_decode($response->product);
        }
        return $product;
    }

    public function createOrUpdateInventory($data) 
    {
        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';

        $service = new Services\InventoryService([
            'authorization'    => $config['sandbox']['oauthUserToken'],
            'requestLanguage'  => 'en-US',
            'responseLanguage' => 'en-US',
            'sandbox'          => true
        ]);
        
        $request = new Types\CreateOrReplaceInventoryItemRestRequest();
       
        $request->sku = $data['sku'];

        $request->availability = new Types\Availability();

        $request->availability->pickupAtLocationAvailability->merchantLocationKey = "{123456}";
        $request->availability->pickupAtLocationAvailability->quantity = 50;


        $request->availability->shipToLocationAvailability = new Types\ShipToLocationAvailability();
        $request->availability->shipToLocationAvailability->quantity = (int)$data['quantity'];

        $request->condition = Enums\ConditionEnum::C_NEW_OTHER;
        //$request->condition = 'NEW';

        $request->product = new Types\Product();
        $request->product->title = $data['title'];
        $request->product->description = $data['description'];

        $brand=$data['brand'];
        $type=$data['type'];
        $storageType=$data['storageType'];
        $recordingDefinition=$data['recordingDefinition'];
        $mediaFormat=$data['mediaFormat'];
        $opticalZoom=$data['opticalZoom'];


        $request->product->aspects = [
            'Brand'                => [$brand],
            'Type'                 => [$type],
            'Storage Type'         => [$storageType],
            'Recording Definition' => [$recordingDefinition],
            'Media Format'         => [$mediaFormat],
            'Optical Zoom'         => [$opticalZoom]
        ];

        $request->product->imageUrls = [
            'http://i.ebayimg.com/images/i/182196556219-0-1/s-l1000.jpg',
            'http://i.ebayimg.com/images/i/182196556219-0-1/s-l1001.jpg',
            'http://i.ebayimg.com/images/i/182196556219-0-1/s-l1002.jpg'
        ];

        $response = $service->createOrReplaceInventoryItem($request);

        if($response->getStatusCode()== "204" || $response->getStatusCode()=="200")
        {
            $details['status'] =1;
        }
        else
        {
            $details['status'] =0;
        }
    
        return $details;
    }

    public function getLocation() 
    {
        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';

        $service = new Services\InventoryService([
            'authorization' => $config['sandbox']['oauthUserToken'],
            'requestLanguage'  => 'en-US',
            'responseLanguage' => 'en-US',
            'sandbox' => true
        ]);
        
        $request = new Types\GetInventoryLocationsRestRequest();

        //$request->offset = '0';
        //$request->limit = '3';
        
        $response = $service->GetInventoryLocations($request);

        $product =[];
        if($response->getStatusCode() === 200 )
        {
            $product = json_decode($response);
        }
        return $product;
    }

    public function createLocation($data) 
    {
        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';
        
        $service = new Services\InventoryService([
            'authorization'    => $config['sandbox']['oauthUserToken'],
            'requestLanguage'  => 'en-US',
            'responseLanguage' => 'en-US',
            'sandbox'          => true
        ]);
        
        $request = new Types\CreateInventoryLocationRestRequest();
       
        $request->merchantLocationKey = $data['merchantLocationKey'];

        $request->location = new Types\LocationDetails();

        $request->location->address = new Types\Address();

        $request->location->address->addressLine1 = $data['address1'];
        $request->location->address->addressLine2 = $data['address2'];
        $request->location->address->city = $data['city'];
        $request->location->address->country = $data['country'];
        $request->location->address->postalCode = $data['postalCode'];
        $request->location->address->stateOrProvince = $data['state'];

        $request->locationInstructions = $data['locationInstruction'];

        $request->name = $data['name'];
        $request->phone = $data['phone'];

        // location is store or warehouse this code is need to check
        /*if($data['locationType'] == "STORE")
        {
            $storeEnumObject = new Enums\StoreTypeEnum();
            $finalStore = $storeEnumObject::C_STORE;

            $requests = new Types\InventoryLocationResponse();
            $requests->locationTypes = $finalStore;
        }
        else if($data['locationType'] == "WAREHOUSE")
        {
            $warehouseEnumObject = new Enums\StoreTypeEnum();
            $finalWarehouse = $warehouseEnumObject::C_WAREHOUSE;
            $request->locationTypes = $finalWarehouse;

            //$request->locationTypes =  Enums\StoreTypeEnum::C_WAREHOUSE;
        }*/

        $response = $service->CreateInventoryLocation($request);

        if($response->getStatusCode()== "204" || $response->getStatusCode()=="200")
        {
            $details['status'] =1;
        }
        else
        {
            $details['status'] =0;
        }
    
        return $details;
    }

    public function enableDisableLocation($action,$merchantLocationKey) 
    {
        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';
        
        $service = new Services\InventoryService([
            'authorization'    => $config['sandbox']['oauthUserToken'],
            'requestLanguage'  => 'en-US',
            'responseLanguage' => 'en-US',
            'sandbox'          => true
        ]);

        if($action == "disable")
        {
            $request = new Types\DisableInventoryLocationRestRequest();
       
            $request->merchantLocationKey = $merchantLocationKey;

            $response = $service->DisableInventoryLocation($request);
        }
        else if($action == "enable")
        {
            $request = new Types\EnableInventoryLocationRestRequest();
       
            $request->merchantLocationKey = $merchantLocationKey;

            $response = $service->EnableInventoryLocation($request);
        }
        

        if($response->getStatusCode()== "204" || $response->getStatusCode()=="200")
        {
            $details['status'] =1;
        }
        else
        {
            $details['status'] =0;
        }
    
        return $details;
    }

    public function deleteLocation($merchantLocationKey) 
    {
        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';

        $service = new Services\InventoryService([
            'authorization' => $config['sandbox']['oauthUserToken'],
            'requestLanguage'  => 'en-US',
            'responseLanguage' => 'en-US',
            'sandbox' => true
        ]);
        
        $request = new Types\DeleteInventoryLocationRestRequest();

        $request->merchantLocationKey = $merchantLocationKey;
        
        $response = $service->DeleteInventoryLocation($request);

        if($response->getStatusCode()== "204" || $response->getStatusCode()=="200")
        {
            $details['status'] =1;
        }
        else
        {
            $details['status'] =0;
        }
    
        return $details;
    }

    public function getItemGroup() 
    {
        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';

        $service = new Services\InventoryService([
            'authorization' => $config['sandbox']['oauthUserToken'],
            'requestLanguage'  => 'en-US',
            'responseLanguage' => 'en-US',
            'sandbox' => true
        ]);
        
        $request = new Types\GetInventoryItemGroupRestRequest();

        //$request->offset = '0';
        //$request->limit = '3';
        
        $response = $service->GetInventoryItemGroup($request);

        $product =[];
        if($response->getStatusCode() === 200 )
        {
            $product = json_decode($response);
        }
        return $product;
    }

    public function createOrUpdateItemGroup($data) 
    {
        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';

        $service = new Services\InventoryService([
            'authorization'    => $config['sandbox']['oauthUserToken'],
            'requestLanguage'  => 'en-US',
            'responseLanguage' => 'en-US',
            'sandbox'          => true
        ]);
        
        $request = new Types\CreateOrReplaceInventoryItemGroupRestRequest();
       
        $request->inventoryItemGroupKey = $data['inventoryItemGroupKey'];

        //$request->inventoryItemGroup = new Types\InventoryItemGroup();

        //$request->inventoryItemGroup->title = $data['title'];
        //$request->inventoryItemGroup->description = $data['description'];

        $response = $service->CreateOrReplaceInventoryItemGroup($request);

        if($response->getStatusCode()== "204" || $response->getStatusCode()=="200")
        {
            $details['status'] =1;
        }
        else
        {
            $details['status'] =0;
        }
    
        return $details;
    }

    public function deleteItemGroup($inventoryItemGroupKey) 
    {
        $frontReplace=str_replace("%7B","{","$inventoryItemGroupKey"); // replace front code to html special chars
        $inventoryItemGroupKey=str_replace("%7D","}","$frontReplace"); // replace last code to html special chars

        $config = require_once APPPATH . 'third_party/ebay-sdk/configuration.php';

        $service = new Services\InventoryService([
            'authorization' => $config['sandbox']['oauthUserToken'],
            'requestLanguage'  => 'en-US',
            'responseLanguage' => 'en-US',
            'sandbox' => true
        ]);
        
        $request = new Types\DeleteInventoryLocationRestRequest();

        $request->inventoryItemGroupKey = $inventoryItemGroupKey;
        
        $response = $service->DeleteInventoryLocation($request);

        if($response->getStatusCode()== "204" || $response->getStatusCode()=="200")
        {
            $details['status'] =1;
        }
        else
        {
            $details['status'] =0;
        }
    
        return $details;
    }
}