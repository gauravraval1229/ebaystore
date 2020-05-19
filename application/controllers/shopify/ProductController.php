<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends CI_Controller {

	public $msgName = "Shopify Product";

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
    	if(isset($_POST['btnAddNewProductShopifySubmit'])) // request for submit new product
    	{
    		$insertProduct = json_decode($this->userModel->productStore()); 

			if ($insertProduct->status == 1) // product added successfully
			{
				$this->session->set_flashdata('success', 'Product added successfully!');
				redirect(base_url('shopify/ProductController/index'));
			}
			else
			{
				$this->session->set_flashdata('error', 'Product is not added successfully!');
				redirect(base_url('shopify/ProductController/index'));
			}
    	}
    	else // add new product page
    	{
    		$data['msgName'] = $this->msgName;
			$data['page'] = 'product/addNewProductShopify';
			$this->load->view('includes/template', $data); 
		}
	}

	public function synchWithShopify()
	{
		$synchProduct = json_decode($this->userModel->synchWithShopify());

		if ($synchProduct->status == 1) // product added successfully
		{
			$this->session->set_flashdata('success', 'Synchronize with shopify successfully!');
			redirect(base_url('shopify/ProductController/index'));
		}
		else
		{
			$this->session->set_flashdata('error', 'Synchronize with shopify not added successfully!');
			redirect(base_url('shopify/ProductController/index'));
		}
	}

	public function deleteProduct($productId)
	{
        $deleteProduct = json_decode($this->userModel->deleteProduct($productId));

        if ($deleteProduct->status == 1) // product deleted successfully
		{
			$this->session->set_flashdata('success', 'Product deleted successfully!');
			redirect(base_url('shopify/ProductController/index'));
		}
		else if($deleteProduct->status == 2) // product is not deleted
		{
			$this->session->set_flashdata('error', 'Product is not deleted successfully!');
			redirect(base_url('shopify/ProductController/index'));
		}
		else // some parameters are missing
		{
			$this->session->set_flashdata('error', 'Product id is missing!');
			redirect(base_url('shopify/ProductController/index'));
		}
    }

    public function editProduct($productId)
	{
		if(isset($_POST['btnUpdateShopify'])) // request for update product
		{
			$updateProduct = json_decode($this->userModel->updateProduct());

			if ($updateProduct->status == 1) // product updated successfully
			{
				$this->session->set_flashdata('success', 'Product updated successfully!');
				redirect(base_url('shopify/ProductController/index'));
			}
			else
			{
				$this->session->set_flashdata('error', 'Product is not updated successfully!');
				redirect(base_url('shopify/ProductController/index'));
			}
		}
		else // redirect on edit product page
		{
	        $productData = json_decode($this->userModel->getProductDataById($productId));

	        if ($productData->status == 1) // product data successfully
			{
				$data['msgName'] = $this->msgName;
	    		$data['shopifyProdutList'] = $productData;
		       	$data['page'] = 'product/editProductShopify';
		        $this->load->view('includes/template', $data);
			}
			else
			{
				$this->session->set_flashdata('error', 'No data found');
				redirect(base_url('shopify/ProductController/index'));
			}
		}
    }
	
}