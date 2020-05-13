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
		include_once (APPPATH.'libraries/amazon/feed/Mock.php');
		include_once (APPPATH.'libraries/amazon/feed/MarketplaceWebService/Model/SubmitFeedRequest.php');
		include_once (APPPATH.'libraries/amazon/feed/MarketplaceWebService/Model/GetReportRequest.php');
		include_once (APPPATH.'libraries/amazon/feed/MarketplaceWebService/Model/GetReportListRequest.php');
		include_once (APPPATH.'libraries/amazon/feed/MarketplaceWebService/Model/RequestReportRequest.php');

		$this->cofig = array ('ServiceURL'=>SERVICE_URL,'ProxyHost' =>null,'ProxyPort'=>-1,'MaxErrorRetry'=>3);
		$this->service = new MarketplaceWebService_Client(AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,$this->cofig,APPLICATION_NAME,APPLICATION_VERSION);

	}

	public function generateRandomString($length = 5) {

		$chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
		return substr(str_shuffle($chars),0,$length);
	}


	/***************************** Report Functions Start ***************************/

		public function index() {

			$productList = array();

			/*$config = array (
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
							APPLICATION_VERSION);*/

			$getAllProductData = $this->getAllProductData();

			if($getAllProductData['status'] == 1 ) { // data found so no need to call another api

				$getAllProductData['data'];

				$data['msgName'] = $this->msgName;
				$data['page'] = 'product/productListAmazon';
				$data['amazonProductList'] = $getAllProductData['data'];
				$this->load->view('includes/template',$data);
			}
			else { // call one more api ReportType wil created.

				/*$config = array (
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
								APPLICATION_VERSION);*/

				$marketplaceIdArray = array("Id" => array(MARKETPLACE_ID));

				$parameters = array (
					'Merchant' => MERCHANT_ID,
					'MarketplaceIdList' => $marketplaceIdArray,
					'ReportType' => '_GET_MERCHANT_LISTINGS_ALL_DATA_',
					'ReportOptions' => 'ShowSalesChannel=true',
					'MWSAuthToken' => MWS_AUTH_TOKEN, // Optional
				);

				$request = new MarketplaceWebService_Model_RequestReportRequest($parameters);
				$request->setMarketplaceIdList($marketplaceIdArray);
				$request->setMerchant(MERCHANT_ID);
				$request->setReportType('_GET_MERCHANT_LISTINGS_ALL_DATA_');
				$request->setMWSAuthToken(MWS_AUTH_TOKEN); // Optional
				$request->setReportOptions('ShowSalesChannel=true');
				$requestReportArr = $this->invokeRequestReport($this->service, $request); // if condition here

				if($requestReportArr['status'] ==  1) {

					$getAllProductData = $this->getAllProductData();

					if($getAllProductData['status'] == 1 ) { // data found

						$data['msgName'] = $this->msgName;
						$data['page'] = 'product/productListAmazon';
						$data['amazonProductList'] = $getAllProductData['data'];
						$this->load->view('includes/template',$data);
					}
					else {

						$data['msgName'] = $this->msgName;
						$data['page'] = 'product/productListAmazon';
						$data['amazonProductList'] = $productList;
						$this->load->view('includes/template',$data);
					}
				}
				else {

					$data['msgName'] = $this->msgName;
					$data['page'] = 'product/productListAmazon';
					$data['amazonProductList'] = $productList;
					$this->load->view('includes/template',$data);
				}
			}
		}

		function invokeRequestReport(MarketplaceWebService_Interface $service, $request) {

			$status = 0;
			$data = array();

			try {
				$response = $service->requestReport($request);
				if ($response->isSetRequestReportResult()) {
					$requestReportResult = $response->getRequestReportResult();
					if ($requestReportResult->isSetReportRequestInfo()) {
						$reportRequestInfo = $requestReportResult->getReportRequestInfo();
						if ($reportRequestInfo->isSetReportRequestId() != "" && $reportRequestInfo->getReportType() == " _GET_MERCHANT_LISTINGS_ALL_DATA_" && $reportRequestInfo->getReportProcessingStatus() == "_SUBMITTED_") {
							return array('status'=>1,'data'=>$data);
						}
						else{
							return array('status'=>$status,'data'=>$data);
						}
					}
					else{
						return array('status'=>$status,'data'=>$data);
					}
				}
				else{
					return array('status'=>$status,'data'=>$data);
				}
			} 
			catch (MarketplaceWebService_Exception $ex) {
				return array('status'=>$status,'data'=>$data);
			}

			/************************* Example Start ****************************
				try {
					$response = $service->requestReport($request);
					echo "Service Response<br/>";
					echo "=============================================================================<br/>";
					echo "RequestReportResponse<br/>";
					if ($response->isSetRequestReportResult()) { 
						echo "RequestReportResult<br/>";
						$requestReportResult = $response->getRequestReportResult();
						if ($requestReportResult->isSetReportRequestInfo()) {
							$reportRequestInfo = $requestReportResult->getReportRequestInfo();
							echo "ReportRequestInfo<br/>";
							if ($reportRequestInfo->isSetReportRequestId()) {
								echo "ReportRequestId ".$reportRequestInfo->getReportRequestId()."<br/>";
							}
							if ($reportRequestInfo->isSetReportType()) {
								echo "ReportType ".$reportRequestInfo->getReportType()."<br/>";
							}
							if ($reportRequestInfo->isSetStartDate()) {
								echo "StartDate ".$reportRequestInfo->getStartDate()->format(DATE_FORMAT)."<br/>";
							}
							if ($reportRequestInfo->isSetEndDate()) {
								echo "EndDate ".$reportRequestInfo->getEndDate()->format(DATE_FORMAT)."<br/>";
							}
							if ($reportRequestInfo->isSetSubmittedDate()) {
								echo "SubmittedDate ".$reportRequestInfo->getSubmittedDate()->format(DATE_FORMAT)."<br/>";
							}
							if ($reportRequestInfo->isSetReportProcessingStatus()) {
								echo "ReportProcessingStatus ".$reportRequestInfo->getReportProcessingStatus()."<br/>";
							}
						}
					} 
					if ($response->isSetResponseMetadata()) { 
						echo "ResponseMetadata<br/>";
						$responseMetadata = $response->getResponseMetadata();
						if ($responseMetadata->isSetRequestId()) {
							echo "RequestId ".$responseMetadata->getRequestId()."<br/>";
						}
					}
					echo "ResponseHeaderMetadata: ".$response->getResponseHeaderMetadata()."<br/>";
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
			************************* Example End *****************************/
		}

		function invokeGetReportList(MarketplaceWebService_Interface $service, $request) {

			$status = 0;
			$data = array();

			try {
					$response = $service->getReportList($request);
					if ($response->isSetGetReportListResult()) { //
						$getReportListResult = $response->getGetReportListResult();
						$reportInfoList = $getReportListResult->getReportInfoList();
						foreach ($reportInfoList as $reportInfo) {
							if ($reportInfo->getReportType() == "_GET_MERCHANT_LISTINGS_ALL_DATA_") {
								return array('status'=>1,'data'=>$reportInfo->getReportId());
							}
						}
						
					}
					else{
						return array('status'=>$status,'data'=>$data);
					}
				} 
				catch (MarketplaceWebService_Exception $ex) {
					return array('status'=>$status,'data'=>$data);
				}

			/************************* Example Start ****************************
				try {
					$response = $service->getReportList($request);
					echo "Service Response<br/>";
					echo "=============================================================================<br/>";
					echo "GetReportListResponse<br/>";
					if ($response->isSetGetReportListResult()) { 
						echo "GetReportListResult<br/>";
						$getReportListResult = $response->getGetReportListResult();
						if ($getReportListResult->isSetNextToken()) {
							echo "NextToken ".$getReportListResult->getNextToken()."<br/>";
						}
						if ($getReportListResult->isSetHasNext()) {
							echo "HasNext ".$getReportListResult->getHasNext()."<br/>";
						}
						$reportInfoList = $getReportListResult->getReportInfoList();
						foreach ($reportInfoList as $reportInfo) {
							echo "ReportInfo<br/>";
							if ($reportInfo->isSetReportId()) {
								echo "ReportId ".$reportInfo->getReportId()."<br/>";
							}
							if ($reportInfo->isSetReportType()) {
								echo "ReportType ".$reportInfo->getReportType()."<br/>";
							}
							if ($reportInfo->isSetReportRequestId()) {
								echo "ReportRequestId".$reportInfo->getReportRequestId()."<br/>";
							}
							if ($reportInfo->isSetAvailableDate()) 		{
								echo "AvailableDate".$reportInfo->getAvailableDate()->format(DATE_FORMAT)."<br/>";
							}
							if ($reportInfo->isSetAcknowledged()) {
								echo "Acknowledged ".$reportInfo->getAcknowledged() . "<br/>";
							}
							if ($reportInfo->isSetAcknowledgedDate()) {
								echo "AcknowledgedDate ".$reportInfo->getAcknowledgedDate()->format(DATE_FORMAT)."<br/>";
							}
						}
					} 
					if ($response->isSetResponseMetadata()) { 
						echo "ResponseMetadata<br/>";
						$responseMetadata = $response->getResponseMetadata();
						if ($responseMetadata->isSetRequestId()) {
							echo "RequestId ".$responseMetadata->getRequestId()."<br/>";
						}
					} 
					echo "ResponseHeaderMetadata: ".$response->getResponseHeaderMetadata()."<br/>";
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
			/************************* Example Start *****************************/
		}

		function invokeGetReport(MarketplaceWebService_Interface $service, $request) {

			$status = 0; // not data found or any condition fails
			$data = array();

			try{
				$response = $service->getReport($request);
				$csvReportString = stream_get_contents($request->getReport());
				$csvReportRows = explode("\n", $csvReportString);
				$report = [];
				foreach ($csvReportRows as $c) {
					if ($c) { 
						$report[] = str_getcsv($c, "\t");
					}
				}
				
				// data is set and count is >=1 so if only find headers in array it will not count. 
				if(isset($report) && !empty($report) && sizeof($report)>=1) {
					return array('status'=>1,'data'=>$report);
				}
				else{
					return array('status'=>$status,'data'=>$data);
				}
			}
			catch (MarketplaceWebService_Exception $ex) {
				return array('status'=>$status,'data'=>$data);
			}

			/************************* Example Start ****************************
				try {
					$response = $service->getReport($request);

					echo "Service Response<br/>";
					echo "=============================================================================<br/>";
					echo "GetReportResponse<br/>";
					if ($response->isSetGetReportResult()) {
						$getReportResult = $response->getGetReportResult(); 
						echo "GetReport";
						if ($getReportResult->isSetContentMd5()) {
							echo "ContentMd5 ". $getReportResult->getContentMd5()."<br/>";
						}
					}
					if ($response->isSetResponseMetadata()) { 
						echo "ResponseMetadata<br/>";
						$responseMetadata = $response->getResponseMetadata();
						if ($responseMetadata->isSetRequestId()) {
							echo "RequestId ".$responseMetadata->getRequestId()."<br/>";
						}
					}
					echo "Report Contents<br/>";
					echo $csvReportString = stream_get_contents($request->getReport())."<br/>";

					$csvReportRows = explode("\n", $csvReportString);
					$report = [];
					foreach ($csvReportRows as $c) {
						if ($c) { 
							$report[] = str_getcsv($c, "\t");
						}
					}
					echo "<pre>";
					print_r($report);
					echo "ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata()."<br/>";
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
			/************************* Example End ****************************/
		}

		function getAllProductData() {

			$parameters = array (
				'Merchant' => MERCHANT_ID,
				//'ReportType' => '_GET_MERCHANT_LISTINGS_ALL_DATA_',
				'ReportTypeList.Type.1'  => '_GET_MERCHANT_LISTINGS_ALL_DATA_',
				'AvailableToDate' => new DateTime('now', new DateTimeZone('UTC')),
				'AvailableFromDate' => new DateTime('-6 months', new DateTimeZone('UTC')),
				'Acknowledged' => false, 
				'MWSAuthToken' => MWS_AUTH_TOKEN, // Optional
			);

			$request = new MarketplaceWebService_Model_GetReportListRequest($parameters);
			$request->setMerchant(MERCHANT_ID);
			$request->setAvailableToDate(new DateTime('now', new DateTimeZone('UTC')));
			$request->setAvailableFromDate(new DateTime('-3 months', new DateTimeZone('UTC')));
			$request->setAcknowledged(false);
			$request->setMWSAuthToken(MWS_AUTH_TOKEN); // Optional

			$getReportListId = $this->invokeGetReportList($this->service, $request);

			if($getReportListId['status'] == 1 && $getReportListId['data'] !="") {

				$reportId = $getReportListId['data'];

				$parameters = array (
					'Merchant' => MERCHANT_ID,
					'Report' => @fopen('php://memory', 'rw+'),
					'ReportId' => $reportId,
					'MWSAuthToken' => MWS_AUTH_TOKEN, // Optional
				);

				$request = new MarketplaceWebService_Model_GetReportRequest($parameters);
				$request->setMerchant(MERCHANT_ID);
				$request->setReport(@fopen('php://memory', 'rw+'));
				$request->setReportId($reportId);
				$request->setMWSAuthToken(MWS_AUTH_TOKEN); // Optional
				return $this->invokeGetReport($this->service, $request);
			}
			else{
				return array($status=>0,$data=>array());
			}
		}

	/***************************** Report Functions Start ***************************/


	/********************** Add/Update product functions Start **********************/

		public function addNewProduct() {

			if(isset($_POST['btnAddNewProductSubmit'])) { // request for submit new product
				
				/*$config = array (
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
								APPLICATION_VERSION);*/

				$sku = $this->generateRandomString().time();
				$title = trim($this->input->post('title'));
				$brand = trim($this->input->post('brand'));
				$price = trim($this->input->post('price'));
				$description = trim($this->input->post('description'));

				$feed = $this->createOrUpdateFeed($sku,$title,$brand,$description); // create xml here
				$marketplaceIdArray = array("Id" => array(MARKETPLACE_ID));

				$feedHandle = @fopen('php://temp','rw+');
				fwrite($feedHandle,$feed);
				rewind($feedHandle);
				$parameters = array (
						'Merchant' => MERCHANT_ID,
						'MarketplaceIdList' => $marketplaceIdArray,
						'FeedType' => '_POST_PRODUCT_DATA_',
						'FeedContent' => $feedHandle,
						'PurgeAndReplace' => false,
						'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
						'MWSAuthToken' => MWS_AUTH_TOKEN, // Optional
				);

				rewind($feedHandle);
				$request = new MarketplaceWebService_Model_SubmitFeedRequest($parameters);
				$this->invokeSubmitFeed($this->service, $request);
				@fclose($feedHandle);

				/********* Add product pirce*********/

				$feed = "";
				$feedHandle = "";
				$request = "";
				$parameters = array();

				$feed = $this->feedPrice($sku,$price); // create xml here
				$marketplaceIdArray = array("Id" => array(MARKETPLACE_ID));

				$feedHandle = @fopen('php://temp', 'rw+');
				fwrite($feedHandle, $feed);
				rewind($feedHandle);

				$parameters = array(
					'Merchant' => MERCHANT_ID,
					'MarketplaceIdList' => $marketplaceIdArray,
					'FeedType' => '_POST_PRODUCT_PRICING_DATA_',
					'FeedContent' => $feedHandle,
					'PurgeAndReplace' => false, //Leave this PurgeAndReplace to false so that it want replace whole product in amazon inventory
					'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true))
				);

				$request = new MarketplaceWebService_Model_SubmitFeedRequest($parameters);
				$this->invokeSubmitFeed($this->service, $request);
				@fclose($feedHandle);

				$this->session->set_flashdata('success', 'Product added successfully!');
				redirect(base_url('amazon/ProductController/index'));

				/**** for image ***/
				/*$feed = $this->feedImage(); // create xml here

				$feedHandle = @fopen('php://temp','rw+');
				fwrite($feedHandle,$feed);
				rewind($feedHandle);
				$parameters = array (
						'Merchant' => MERCHANT_ID,
						'MarketplaceIdList' => $marketplaceIdArray,
						'FeedType' => '_POST_PRODUCT_IMAGE_DATA_',
						'FeedContent' => $feedHandle,
						'PurgeAndReplace' => false,
						'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
						'MWSAuthToken' => MWS_AUTH_TOKEN, // Optional
				);

				rewind($feedHandle);
				$request = new MarketplaceWebService_Model_SubmitFeedRequest($parameters);
				$this->invokeSubmitFeed($this->service, $request);
				@fclose($feedHandle);*/

				

				/*if(!file_exists(createFolderAmazonImage)) { // create folder on root/assets
					mkdir(createFolderAmazonImage, 0777, true);
				}

				if(!file_exists(createFolderAmazonImage.'/'.$sku)) { // create folder of sku
					mkdir(createFolderAmazonImage.'/'.$sku, 0777, true);
				}

				$imageNewName = time().'.'.strtolower(pathinfo($_FILES["prodcutImage"]['name'], PATHINFO_EXTENSION));
				$config['upload_path'] = createFolderAmazonImage.'/'.$sku;
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['file_name'] = $imageNewName;

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('prodcutImage')) {
					echo "error";
				} else {
					echo "success";
				}*/

				//$this->session->set_flashdata('success', 'Product added successfully!');
				//redirect(base_url('amazon/ProductController/index'));
			}
			else { // Just display add proudct page

				$data['msgName'] = $this->msgName;
				$data['page'] = 'product/addNewProductAmazon';
				$this->load->view('includes/template',$data);
			}
		}

		function createOrUpdateFeed($sku,$title,$brand,$description) {

			return '<?xml version="1.0" encoding="iso-8859-1"?>
				<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
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
							<SKU>'.$sku.'</SKU>
							<StandardProductID>
								<Type>UPC</Type>
								<Value>463563647487</Value>
							</StandardProductID>
							<ProductTaxCode>A_GEN_NOTAX</ProductTaxCode>
							<DescriptionData>
								<Title>'.$title.'</Title>
								<Brand>'.$brand.'</Brand>
								<Description>'.$description.'</Description>
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
		}

		function feedImage(){

			return '<?xml version="1.0" encoding="utf-8"?>
					<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
						<Header>
							<DocumentVersion>1.01</DocumentVersion>
							<MerchantIdentifier>MARKETPLACE_ID</MerchantIdentifier>
						</Header>
						<MessageType>ProductImage</MessageType>
						<PurgeAndReplace>false</PurgeAndReplace> 
						<Message> 
							<MessageID>1</MessageID> 
							<OperationType>Update</OperationType> 
							<ProductImage> 
								<SKU>566666</SKU> 
								<ImageType>Main</ImageType>
								<ImageLocation>http://www.w3schools.com/html/img_chania.jpg</ImageLocation>
							</ProductImage> 
						</Message>
					</AmazonEnvelope>';
		}

		function feedPrice($sku,$price){

			return '<?xml version="1.0" encoding="utf-8"?>
					<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
						<Header>
							<DocumentVersion>1.01</DocumentVersion>
							<MerchantIdentifier>MARKETPLACE_ID</MerchantIdentifier>
						</Header>
						<MessageType>Price</MessageType>
						<Message>
							<MessageID>1</MessageID>
							<Price>
								<SKU>'.$sku.'</SKU>
								<StandardPrice currency="EUR">'.$price.'</StandardPrice>
							</Price>
						</Message>
					</AmazonEnvelope>';
		}

		function invokeSubmitFeed(MarketplaceWebService_Interface $service, $request) { //submit product data

			$response = $service->submitFeed($request);

			/*try {
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
			}*/
		}

	/********************** Add/Update product functions End **********************/

	/********************** Delete product functions Start **********************/

		public function deleteProduct($sku) {
		}

		function feedDelete() {

			return '<?xml version="1.0" encoding="UTF-8"?>
						<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
							<Header>
								<DocumentVersion>1.01</DocumentVersion>
								<MerchantIdentifier>MARKETPLACE_ID</MerchantIdentifier>
							</Header>
							<MessageType>Product</MessageType>
							<Message>
								<MessageID>1</MessageID>
								<OperationType>999999</OperationType>
								<Product>
									<SKU>999999</SKU>
								</Product>
							</Message>
						</AmazonEnvelope>';
		}

	/********************** Delete product functions End **********************/
}