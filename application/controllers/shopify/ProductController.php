<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends CI_Controller {

	public $msgName = "Product";

	public function __construct() 
	{
		parent::__construct();
		$this->load->library('TokenData');
		$this->load->library('CheckLoginToken');
		$this->load->model('UserModel','userModel');
		$this->load->helper('url','form');

		$this->checklogintoken->checkLogin(); // check user is loggedin or not
	}

    public function index()
	{
		$_POST  = json_decode(file_get_contents('php://input'), true);
		$shopifyProdutList = json_decode($this->userModel->getProductListWithDetail());

		if($shopifyProdutList->status == "1") // record found
    	{
    		$data['msgName'] = $this->msgName;
			$data['shopifyProdutList'] = $shopifyProdutList;
	    	$data['page'] = 'product/productListShopify';
	    	$this->load->view('includes/template', $data);
    	}
    	else
    	{
    		$data['msgName'] = $this->msgName;
			$data['shopifyProdutList'] = $shopifyProdutList;
	    	$data['page'] = 'product/productListShopify';
	    	$this->load->view('includes/template', $data);
    		//$this->session->set_flashdata('error', $shopifyProdutList->message);
    	}	
    }

    public function addNewProductShopify()
    {
    	if(isset($_POST['btnAddNewProductShopifySubmit'])) // request for submit new inventory
    	{
    		$this->userModel->productStore(); 
	    	
	    	/*$createInventory = $this->inventory->createOrUpdateInventory($insertData); // upadate and create method are same.
			if ($createInventory['status']==1) 
			{
				$this->session->set_flashdata('success', 'Product added successfully!');
				redirect(base_url('ProductController/index'));
			}
			else
			{
				$this->session->set_flashdata('error', 'Product is not added successfully!');
			}*/
    	}
    	else // add new product page
    	{
    		$data['msgName'] = $this->msgName;
			$data['page'] = 'product/addNewProductShopify';
			$this->load->view('includes/template', $data); 
		}
    }
}
