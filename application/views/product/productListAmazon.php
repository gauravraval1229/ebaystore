  <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-body">

          <div>
            <?php if ($this->session->flashdata('error')) { ?>
              <div class="alert alert-danger" id="msg">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:black">&times;</a>
                  <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
              </div>
            <?php }
            if ($this->session->flashdata('success')) { ?>
              <div class="alert alert-success" id="msg">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:black">&times;</a>
                  <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
              </div>
            <?php } ?>
          </div>
          <?php //echo base_url(); echo "<pre>";  print_r($productList->inventoryItems); ?>
<?php
/*******************************************************************************
 * Copyright 2009-2018 Amazon Services. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the "License"); 
 *
 * You may not use this file except in compliance with the License. 
 * You may obtain a copy of the License at: http://aws.amazon.com/apache2.0
 * This file is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR 
 * CONDITIONS OF ANY KIND, either express or implied. See the License for the 
 * specific language governing permissions and limitations under the License.
 *******************************************************************************
 * PHP Version 5
 * @category Amazon
 * @package  Marketplace Web Service Products
 * @version  2011-10-01
 * Library Version: 2017-03-22
 * Generated: Thu Oct 11 10:46:02 PDT 2018
 */

/**
 * Get Service Status Sample
 */
require_once(APPPATH.'libraries/amazon_order_api/Samples/.config.inc.php');
require_once(APPPATH.'libraries/amazon_order_api/Client.php');

/************************************************************************
 * Instantiate Implementation of MarketplaceWebServiceProducts
 *
 * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants
 * are defined in the .config.inc.php located in the same
 * directory as this sample
 ***********************************************************************/
// More endpoints are listed in the MWS Developer Guide
// North America:
//$serviceUrl = "https://mws.amazonservices.com/Products/2011-10-01";
// Europe
//$serviceUrl = "https://mws-eu.amazonservices.com/Products/2011-10-01";
// Japan
//$serviceUrl = "https://mws.amazonservices.jp/Products/2011-10-01";
// China
//$serviceUrl = "https://mws.amazonservices.com.cn/Products/2011-10-01";

$serviceUrl = "https://mws.amazonservices.co.uk/Products/2011-10-01";

 $config = array (
   'ServiceURL' => $serviceUrl,
   'ProxyHost' => null,
   'ProxyPort' => -1,
   'ProxyUsername' => null,
   'ProxyPassword' => null,
   'MaxErrorRetry' => 3,
 );

 $service = new MarketplaceWebServiceProducts_Client(
        AWS_ACCESS_KEY_ID,
        AWS_SECRET_ACCESS_KEY,
        APPLICATION_NAME,
        APPLICATION_VERSION,
        $config);

/************************************************************************
 * Uncomment to try out Mock Service that simulates MarketplaceWebServiceProducts
 * responses without calling MarketplaceWebServiceProducts service.
 *
 * Responses are loaded from local XML files. You can tweak XML files to
 * experiment with various outputs during development
 *
 * XML files available under MarketplaceWebServiceProducts/Mock tree
 *
 ***********************************************************************/
 // $service = new MarketplaceWebServiceProducts_Mock();

/************************************************************************
 * Setup request parameters and uncomment invoke to try out
 * sample for Get Service Status Action
 ***********************************************************************/
 // @TODO: set request. Action can be passed as MarketplaceWebServiceProducts_Model_GetServiceStatus
 $request = new MarketplaceWebServiceProducts_Model_GetServiceStatusRequest();
 $request->setSellerId(MERCHANT_ID);
 // object or array of parameters
 invokeGetServiceStatus($service, $request);

/**
  * Get Get Service Status Action Sample
  * Gets competitive pricing and related information for a product identified by
  * the MarketplaceId and ASIN.
  *
  * @param MarketplaceWebServiceProducts_Interface $service instance of MarketplaceWebServiceProducts_Interface
  * @param mixed $request MarketplaceWebServiceProducts_Model_GetServiceStatus or array of parameters
  */

  function invokeGetServiceStatus(MarketplaceWebServiceProducts_Interface $service, $request)
  {
      try {
        $response = $service->GetServiceStatus($request);

        echo ("Service Response\n");
        echo ("=============================================================================\n");

        $dom = new DOMDocument();
        $dom->loadXML($response->toXML());
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        echo $dom->saveXML();
        echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");

     } catch (MarketplaceWebServiceProducts_Exception $ex) {
        echo("Caught Exception: " . $ex->getMessage() . "\n");
        echo("Response Status Code: " . $ex->getStatusCode() . "\n");
        echo("Error Code: " . $ex->getErrorCode() . "\n");
        echo("Error Type: " . $ex->getErrorType() . "\n");
        echo("Request ID: " . $ex->getRequestId() . "\n");
        echo("XML: " . $ex->getXML() . "\n");
        echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
     }
 }




?>

          <!-- DOM - jQuery events table --
          <section id="dom">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                      <h4 class="card-title"><?php echo $msgName; ?> List</h4>
                      <a href="<?php echo base_url('ebay/ProductController/addNewProduct'); ?>" class="btn btn-info heading-elements" style="float:right;">Add New <?php echo $msgName; ?></a>
                  </div>

                  <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                          <thead>
                            <tr>
                              <th>SKU</th>
                              <th>Quantity</th>
                              <th>Title</th>
                              <th>Brand</th>
                              <th>Description</th>
                              <th></th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- DOM - jQuery events table -->

        </div>
      </div>
    </div>
  <!-- END: Content-->
