<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends CI_Controller {

	public $msgName = "Amazon Product";

	public function __construct() {

		parent::__construct();
		$this->load->library('TokenData');
		$this->load->library('CheckLoginToken');
		$this->load->library('CheckLoginToken');
		$this->load->library('Inventory');
		$this->load->model('UserModel','userModel');
		$this->load->helper('url');
		//$this->checklogintoken->checkLogin(); // check user is loggedin or not
		//$this->checklogintoken->checkToken(); //token expired or not

		include_once (APPPATH.'libraries/amazon/feed/Client.php');
		include_once (APPPATH.'libraries/amazon/feed/Interface.php');
		include_once (APPPATH.'libraries/amazon/feed/MarketplaceWebService/Model/SubmitFeedRequest.php');
	}

	/*public function index() {

		$data['msgName'] = $this->msgName;
		$data['page'] = 'product/productListAmazon';
		$this->load->view('includes/template',$data);
	}*/
	
	public function index() {

		//if(isset($_POST['btnAddNewProductSubmit'])) { // request for submit new product

		$config = array (
			'ServiceURL' => SERVICE_URL,
			'ProxyHost' => null,
			'ProxyPort' => -1,
			'MaxErrorRetry' => 3,
		);

		$service = new MarketplaceWebService_Client(
						AWS_ACCESS_KEY_ID,
						AWS_SECRET_ACCESS_KEY,
						$config,
						APPLICATION_NAME,
						APPLICATION_VERSION);

		$feed =
'<?xml version="1.0" encoding="iso-8859-1"?>
<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
  <Header>
    <DocumentVersion>1.01</DocumentVersion>
    <MerchantIdentifier>MARKETPLACE_ID</MerchantIdentifier>
  </Header>
  <MessageType>Product</MessageType>
  <PurgeAndReplace>false</PurgeAndReplace>
  <Message>
    <MessageID>1</MessageID>
    <OperationType>Update</OperationType>
    <Product>
      <SKU>262626</SKU>
      <StandardProductID>
        <Type>UPC</Type>
        <Value>463563647487</Value>
      </StandardProductID>
      <ProductTaxCode>A_GEN_NOTAX</ProductTaxCode>
      <DescriptionData>
        <Title>Test Product Title</Title>
        <Brand>Example Product Brand</Brand>
        <Description>This is an example product description.</Description>
        <BulletPoint>Example Bullet Point 1</BulletPoint>
        <BulletPoint>Example Bullet Point 2</BulletPoint>
        <MSRP currency="USD">25.19</MSRP>
        <Manufacturer>Example Product Manufacturer</Manufacturer>
        <ItemType>example-item-type</ItemType>
      </DescriptionData>
      <ProductData>
        <Health>
          <ProductType>
            <HealthMisc>
              <Ingredients>Example Ingredients</Ingredients>
              <Directions>Example Directions</Directions>
            </HealthMisc>
          </ProductType>
        </Health>
      </ProductData>
    </Product>
  </Message>
</AmazonEnvelope>';

$marketplaceIdArray = array("Id" => array(MARKETPLACE_ID));

$feedHandle = @fopen('php://temp','rw+');
fwrite($feedHandle,$feed);
rewind($feedHandle);
			$parameters = array (
					'Merchant' => MERCHANT_ID,
					'MarketplaceIdList' => $marketplaceIdArray,
					//'FeedType' => '_POST_ORDER_FULFILLMENT_DATA_',
					'FeedType' => '_POST_PRODUCT_DATA_',
					'FeedContent' => $feedHandle,
					'PurgeAndReplace' => false,
					'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
					'MWSAuthToken' => MWS_AUTH_TOKEN, // Optional
			);

rewind($feedHandle);
$request = new MarketplaceWebService_Model_SubmitFeedRequest($parameters);
$this->invokeSubmitFeed($service, $request);
@fclose($feedHandle);
}

/*}
		else { // Just display add proudct page

			$data['msgName'] = $this->msgName;
			$data['page'] = 'product/addNewProductAmazon';
			$this->load->view('includes/template',$data);
		}

	}*/

	function invokeSubmitFeed(MarketplaceWebService_Interface $service, $request) { //submit product

		try {
			$response = $service->submitFeed($request);

			echo "Service Response<br/>";
			echo "=============================================================================<br/>";
			echo "SubmitFeedResponse<br/>";

			if ($response->isSetSubmitFeedResult()) {
				echo("SubmitFeedResult\n");
				$submitFeedResult = $response->getSubmitFeedResult();
				if ($submitFeedResult->isSetFeedSubmissionInfo()) {
					echo "FeedSubmissionInfo<br/>";
					$feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();
					if ($feedSubmissionInfo->isSetFeedSubmissionId()) {
						echo "FeedSubmissionId: ".$feedSubmissionInfo->getFeedSubmissionId()."<br/>";
					}
					if ($feedSubmissionInfo->isSetFeedType()) {
						echo "FeedType: ".$feedSubmissionInfo->getFeedType() . "<br/>";
					}
					if ($feedSubmissionInfo->isSetSubmittedDate()) {
						echo "SubmittedDate: ".$feedSubmissionInfo->getSubmittedDate()->format(DATE_FORMAT)."<br/>";
					}
					if ($feedSubmissionInfo->isSetFeedProcessingStatus()) {
					echo "FeedProcessingStatus: ".$feedSubmissionInfo->getFeedProcessingStatus()."<br>";
					}
					if ($feedSubmissionInfo->isSetStartedProcessingDate()) {
						echo "StartedProcessingDate: ".$feedSubmissionInfo->getStartedProcessingDate()->format(DATE_FORMAT)."<br/>";
					}
					if ($feedSubmissionInfo->isSetCompletedProcessingDate())
					{
						echo "CompletedProcessingDate: ".$feedSubmissionInfo->getCompletedProcessingDate()->format(DATE_FORMAT)."<br/>";
					}
				}
			}
			if ($response->isSetResponseMetadata()) {
				echo "<br/>ResponseMetadata<br/>";
				$responseMetadata = $response->getResponseMetadata();
				if ($responseMetadata->isSetRequestId()) {
					echo "RequestId: ".$responseMetadata->getRequestId()."<br/>";
				}
			}
			echo "ResponseHeaderMetadata: ".$response->getResponseHeaderMetadata()."<br/>" ;
		}
		catch (MarketplaceWebService_Exception $ex) {
			echo "Caught Exception: ".$ex->getMessage()."<br/>";
			echo "Response Status Code: ".$ex->getStatusCode()."<br/>";
			echo "Error Code: ".$ex->getErrorCode()."<br/>";
			echo "Error Type: ".$ex->getErrorType()."<br/>";
			echo "Request ID: ".$ex->getRequestId()."<br/>";
			echo "XML: ".$ex->getXML()."<br/>";
			echo "ResponseHeaderMetadata: ".$ex->getResponseHeaderMetadata()."<br/>";
		}
	}
}