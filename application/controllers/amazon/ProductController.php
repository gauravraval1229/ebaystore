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
		$this->checklogintoken->checkLogin(); // check user is loggedin or not
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

		include_once (APPPATH.'libraries/amazon/product/Client.php');
		include_once (APPPATH.'libraries/amazon/product/Mock.php');
		include_once (APPPATH.'libraries/amazon/product/MarketplaceWebServiceProducts/Model/GetMatchingProductForIdRequest.php');
		include_once (APPPATH.'libraries/amazon/product/MarketplaceWebServiceProducts/Model/IdListType.php');
		include_once (APPPATH.'libraries/amazon/product/MarketplaceWebServiceProducts/Model/GetMatchingProductForIdResponse.php');
	}

	public function generateRandomString($length = 12) {

		$chars = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		return substr(str_shuffle($chars),0,$length);
	}

	public function generateManufacture() {

		$chars = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$nums = '123456789';
		return substr(str_shuffle($chars),0,6).'-'.substr(str_shuffle($nums),0,4);
	}

	/***************************** Report Functions Start ***************************/

		public function index() {

			$productList = array();

			$getAllProductData = $this->getAllProductData();

			if($getAllProductData['status'] == 1 ) { // data found so no need to call another api

				$data['msgName'] = $this->msgName;
				$data['page'] = 'product/productListAmazon';
				$data['amazonProductList'] = $getAllProductData['data'];
				$this->load->view('includes/template',$data);
			}
			else { // call one more api ReportType wil created.

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

				if($requestReportArr['status'] == 1) {

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

		// make request to generate report id
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

		// get report id
		function invokeGetReportList(MarketplaceWebService_Interface $service, $request) {

			$status = 0;
			$data = array();

			try {
					$response = $service->getReportList($request);
					if ($response->isSetGetReportListResult()) { //
						$getReportListResult = $response->getGetReportListResult();
						$reportInfoList = $getReportListResult->getReportInfoList();

						$loopFlage = 0; // if flage is 1 that means type matched so need to loop more exit loop
						foreach ($reportInfoList as $reportInfo) {

							if($loopFlage == 0) { //
								if ($reportInfo->getReportType() == "_GET_MERCHANT_LISTINGS_ALL_DATA_") {
									$loopFlage = 1; // type matched so end the loop
									return array('status'=>1,'data'=>$reportInfo->getReportId());
								}
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

		// get report using id
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

		// common function to get report data.
		function getAllProductData() {

			$parameters = array (
				'Merchant' => MERCHANT_ID,
				//'ReportType' => '_GET_MERCHANT_LISTINGS_ALL_DATA_',
				'ReportTypeList.Type.1' => '_GET_MERCHANT_LISTINGS_ALL_DATA_',
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

	/***************************** Report Functions End ***************************/

	/********************** Delete product functions Start **********************/

		public function deleteProduct($sku) {

			$feed = $this->feedDelete($sku); // create xml here
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

			$this->session->set_flashdata('success', 'Product deleted successfully! To refresh the list, it may take 25-30 minutes.');
			redirect(base_url('amazon/ProductController/index'));
		}

		function feedDelete($sku) {

			return '<?xml version="1.0" encoding="UTF-8"?>
						<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
							<Header>
								<DocumentVersion>1.01</DocumentVersion>
								<MerchantIdentifier>MARKETPLACE_ID</MerchantIdentifier>
							</Header>
							<MessageType>Product</MessageType>
							<Message>
								<MessageID>1</MessageID>
								<OperationType>Delete</OperationType>
								<Product>
									<SKU>'.$sku.'</SKU>
								</Product>
							</Message>
						</AmazonEnvelope>';
		}

	/********************** Delete product functions End **********************/

	/********************** Add product functions Start **********************/

		public function addNewProduct() {

			if(isset($_POST['btnAddNewProductSubmit'])) { // request for submit new product

				$sku = $this->generateRandomString().time();

				if(!file_exists(createFolderAmazonImage)) { // create folder on root/assets
					mkdir(createFolderAmazonImage, 0777, true);
				}

				if(!file_exists(createFolderAmazonImage.'/'.$sku)) { // create folder of sku
					mkdir(createFolderAmazonImage.'/'.$sku, 0777, true);
				}

				$imageNewName = uniqid().'-'.time().'.'.strtolower(pathinfo($_FILES["prodcutImage"]['name'], PATHINFO_EXTENSION));
				$config['upload_path'] = createFolderAmazonImage.'/'.$sku;
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['file_name'] = $imageNewName;

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('prodcutImage')) { // Product upload fail

					$this->session->set_flashdata('error', 'The Product not added due to image uploading failed. Please try after some time.');
					redirect(base_url('amazon/ProductController/index'));
				}
				else {
					
					$title = trim($this->input->post('title'));
					$brand = trim($this->input->post('brand'));
					$price = trim($this->input->post('price'));
					$qty = trim($this->input->post('qty'));
					$description = trim($this->input->post('description'));
					$manufacturer = trim($this->input->post('manufacturer'));
					$manufacturerNo = $this->generateManufacture();

					/************* Add Product Basic Detail Start *************/

						$feed = "";
						$feedHandle = "";
						$request = "";
						$parameters = array();

						$feed = $this->createFeed($sku,$title,$brand,$description,$manufacturer,$manufacturerNo); // create xml here
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

					/************* Add Product Basic Detail End *************/


					/************* Add Product Qty Start *************/

						$feed = "";
						$feedHandle = "";
						$request = "";
						$parameters = array();

						$feed = $this->feedQty($sku,$qty); // create xml here

						$feedHandle = @fopen('php://temp', 'rw+');
						fwrite($feedHandle, $feed);
						rewind($feedHandle);

						$parameters = array (
								'Merchant' => MERCHANT_ID,
								'MarketplaceIdList' => $marketplaceIdArray,
								'FeedType' => '_POST_INVENTORY_AVAILABILITY_DATA_',
								'FeedContent' => $feedHandle,
								'PurgeAndReplace' => false,
								'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
								'MWSAuthToken' => MWS_AUTH_TOKEN, // Optional
						);

						$request = new MarketplaceWebService_Model_SubmitFeedRequest($parameters);
						$this->invokeSubmitFeed($this->service, $request);
						@fclose($feedHandle);

					/************* Add Product Qty End *************/


					/************* Add Product Price Start *************/

						$feed = "";
						$feedHandle = "";
						$request = "";
						$parameters = array();

						$feed = $this->feedPrice($sku,$price); // create xml here

						$feedHandle = @fopen('php://temp', 'rw+');
						fwrite($feedHandle, $feed);
						rewind($feedHandle);

						$parameters = array (
								'Merchant' => MERCHANT_ID,
								'MarketplaceIdList' => $marketplaceIdArray,
								'FeedType' => '_POST_PRODUCT_PRICING_DATA_',
								'FeedContent' => $feedHandle,
								'PurgeAndReplace' => false,
								'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
								'MWSAuthToken' => MWS_AUTH_TOKEN, // Optional
						);

						$request = new MarketplaceWebService_Model_SubmitFeedRequest($parameters);
						$this->invokeSubmitFeed($this->service, $request);
						@fclose($feedHandle);

					/************* Add Product Price Start *************/


					/************* Add Product Image Start *************/

						$imagePath = uploadAmazonImage.'/'.$sku.'/'.$imageNewName;

						$feed = "";
						$feedHandle = "";
						$request = "";
						$parameters = array();

						$feed = $this->feedImage($sku,$imagePath); // create xml here

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
						@fclose($feedHandle);

					/************* Add Product Image End *************/

					$this->session->set_flashdata('success', 'Product added successfully! For the display in the list, it may take 25-30 minutes.');
					redirect(base_url('amazon/ProductController/index'));
				}
			}
			else { // Just display add proudct page

				$data['msgName'] = $this->msgName;
				$data['page'] = 'product/addNewProductAmazon';
				$this->load->view('includes/template',$data);
			}
		}

		// add basic data of product
		function createFeed($sku,$title,$brand,$description,$manufacturer,$manufacturerNo) {

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
								<Type>ASIN</Type>
								<Value>1633182649</Value>
							</StandardProductID>
							<ProductTaxCode>A_GEN_NOTAX</ProductTaxCode>
							<DescriptionData>
								<Title>'.$title.'</Title>
								<Brand>'.$brand.'</Brand>
								<Description>'.$description.'</Description>
								<Manufacturer>'.$manufacturer.'</Manufacturer>
								<MfrPartNumber>'.$manufacturerNo.'</MfrPartNumber>
							</DescriptionData>
						</Product>
					</Message>
				</AmazonEnvelope>';
		}

	/********************** Add product functions End **********************/

	/***************************** Edit Functions Start ***************************/

		public function editProduct() {

			if(isset($_POST['btnUpdate'])) {

				$sku = trim($this->input->post('sku'));
				$title = trim($this->input->post('title'));
				$price = trim($this->input->post('price'));
				$description = trim($this->input->post('description'));
				$qty = trim($this->input->post('qty'));
				$old_qty = trim($this->input->post('old_qty'));
				
				if($old_qty != $qty) { // new qty added by admin so add into old qty
					$qty = $qty + $old_qty;
				}

				/************* Update Product Basic Detail Start *************/

					$feed = "";
					$feedHandle = "";
					$request = "";
					$parameters = array();

					$feed = $this->updateFeed($sku,$title,$description); // create xml here
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

				/************* Update Product Basic Detail End *************/
				
				/************* Update Product Qty Start *************/

						$feed = "";
						$feedHandle = "";
						$request = "";
						$parameters = array();

						$feed = $this->feedQty($sku,$qty); // create xml here

						$feedHandle = @fopen('php://temp', 'rw+');
						fwrite($feedHandle, $feed);
						rewind($feedHandle);

						$parameters = array (
								'Merchant' => MERCHANT_ID,
								'MarketplaceIdList' => $marketplaceIdArray,
								'FeedType' => '_POST_INVENTORY_AVAILABILITY_DATA_',
								'FeedContent' => $feedHandle,
								'PurgeAndReplace' => false,
								'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
								'MWSAuthToken' => MWS_AUTH_TOKEN, // Optional
						);

						$request = new MarketplaceWebService_Model_SubmitFeedRequest($parameters);
						$this->invokeSubmitFeed($this->service, $request);
						@fclose($feedHandle);

				/************* Update Product Qty End *************/

				/************* Update Product Price Start *************/

					$feed = "";
					$feedHandle = "";
					$request = "";
					$parameters = array();

					$feed = $this->feedPrice($sku,$price); // create xml here

					$feedHandle = @fopen('php://temp', 'rw+');
					fwrite($feedHandle, $feed);
					rewind($feedHandle);

					$parameters = array (
							'Merchant' => MERCHANT_ID,
							'MarketplaceIdList' => $marketplaceIdArray,
							'FeedType' => '_POST_PRODUCT_PRICING_DATA_',
							'FeedContent' => $feedHandle,
							'PurgeAndReplace' => false,
							'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
							'MWSAuthToken' => MWS_AUTH_TOKEN, // Optional
					);

					$request = new MarketplaceWebService_Model_SubmitFeedRequest($parameters);
					$this->invokeSubmitFeed($this->service, $request);
					@fclose($feedHandle);

				/************* Update Product Price Start *************/

				/************* Update Product Image Start *************/

					if($_FILES["prodcutImageNew"]['name'] != "") {

						if(!file_exists(createFolderAmazonImage)) { // create folder on root/assets
							mkdir(createFolderAmazonImage, 0777, true);
						}

						if(!file_exists(createFolderAmazonImage.'/'.$sku)) { // create folder of sku
							mkdir(createFolderAmazonImage.'/'.$sku, 0777, true);
						}

						$imageNewName = uniqid().'-'.time().'.'.strtolower(pathinfo($_FILES["prodcutImageNew"]['name'], PATHINFO_EXTENSION));
						$config['upload_path'] = createFolderAmazonImage.'/'.$sku;
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['file_name'] = $imageNewName;

						$this->load->library('upload', $config);

						if (!$this->upload->do_upload('prodcutImageNew')) { // product upload fail

							$this->session->set_flashdata('error', 'The Product image uploading failed. Please try after some time.');
							redirect(base_url('amazon/ProductController/index'));
						}
						else {

							$imagePath = uploadAmazonImage.'/'.$sku.'/'.$imageNewName;

							$feed = "";
							$feedHandle = "";
							$request = "";
							$parameters = array();

							$feed = $this->feedImage($sku,$imagePath); // create xml here

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
							@fclose($feedHandle);

							$this->session->set_flashdata('success', 'Product updated successfully! For the display in the list, it may take 25-30 minutes.');
							redirect(base_url('amazon/ProductController/index'));
						}
					}

				/************* Update Product Image End *************/

				$this->session->set_flashdata('success', 'Product updated successfully! For the display in the list, it may take 25-30 minutes.');
				redirect(base_url('amazon/ProductController/index'));
			}
			else {

				$data['msgName'] = $this->msgName;
				$data['page'] = 'product/editProductAmazon';
				$this->load->view('includes/template',$data);
			}
		}

		// Update basic data of product
		function updateFeed($sku,$title,$description) {

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
							<ProductTaxCode>A_GEN_NOTAX</ProductTaxCode>
							<DescriptionData>
								<Title>'.$title.'</Title>
								<Description>'.$description.'</Description>
							</DescriptionData>
						</Product>
					</Message>
				</AmazonEnvelope>';
		}

	/***************************** Edit Functions Start ***************************/

	/***************************** Common Functions Start ***************************/

		// Add/update price of prodcut
		function feedPrice($sku,$price) {

			return '<?xml version="1.0" encoding="utf-8"?>
						<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
							<Header>
								<DocumentVersion>1.01</DocumentVersion>
								<MerchantIdentifier>MARKETPLACE_ID</MerchantIdentifier>
							</Header>
							<MessageType>Price</MessageType>
							<Message>
								<MessageID>1</MessageID>
								<OperationType>Update</OperationType>
								<Price>
									<SKU>'.$sku.'</SKU>
									<StandardPrice currency="GBP">'.$price.'</StandardPrice>
									<MinimumSellerAllowedPrice currency="GBP">1</MinimumSellerAllowedPrice>
									<MaximumSellerAllowedPrice currency="GBP">10000000</MaximumSellerAllowedPrice>
								</Price>
							</Message>
						</AmazonEnvelope>';
		}

		// Add/update qty of prodcut
		function feedQty($sku,$qty) {

			return '<?xml version="1.0" encoding="utf-8"?>
						<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
							<Header>
								<DocumentVersion>1.01</DocumentVersion>
								<MerchantIdentifier>MARKETPLACE_ID</MerchantIdentifier>
							</Header>
							<MessageType>Inventory</MessageType>
							<Message>
								<MessageID>1</MessageID>
								<OperationType>Update</OperationType>
								<Inventory>
									<SKU>'.$sku.'</SKU>
									<Quantity>'.$qty.'</Quantity>
								</Inventory>
							</Message>
						</AmazonEnvelope>';
		}

		// add/update image of product
		function feedImage($sku,$imagePath){

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
									<SKU>'.$sku.'</SKU> 
									<ImageType>Main</ImageType>
									<ImageLocation>'.$imagePath.'</ImageLocation>
								</ProductImage> 
							</Message>
						</AmazonEnvelope>';
		}

		// All request submit/upload/delete (basic data,image,price,qty etc)
		function invokeSubmitFeed(MarketplaceWebService_Interface $service, $request) { //submit product data

			//$response = $service->submitFeed($request);

			/************************* Example Start ****************************/

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

			/************************* Example End ****************************/
		}

	/***************************** Common Functions End ***************************/
}