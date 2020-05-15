<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WelcomeController extends CI_Controller {

   /* public function __construct() {
        parent::__construct();

        $this->load->model('UserModel','userModel');
        $this->load->helper('url');

        if($this->session->userdata['logged_in']['id']=="") { // if user is not logged in

            $this->session->set_flashdata('error','Kindly login again');
            redirect(base_url('/'));
            exit();
        }
    }*/

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
    }

   /* public function index() {

        $data['page'] = 'welcome/index';
        $this->load->view('includes/template', $data);
    }*/

    /***************************** Report Functions Start ***************************/

        public function index() {

            $productList = array();

            $getAllProductData = $this->getAllProductData();

            if($getAllProductData['status'] == 1 ) { // data found so no need to call another api

                $data['page'] = 'welcome/index';
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

                        $data['page'] = 'welcome/index';
                        $data['amazonProductList'] = $getAllProductData['data'];
                        $this->load->view('includes/template',$data);
                    }
                    else {

                        $data['page'] = 'welcome/index';
                        $data['amazonProductList'] = $getAllProductData['data'];
                        $this->load->view('includes/template',$data);
                    }
                }
                else {

                    $data['page'] = 'welcome/index';
                    $data['amazonProductList'] = $getAllProductData['data'];
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
                            if ($reportInfo->isSetAvailableDate())      {
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

    /***************************** Report Functions Start ***************************/
}