<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends CI_Controller {

	public $msgName = "Product";

	public function __construct() 
	{
		parent::__construct();
		$this->load->library('Inventory');
		$this->load->library('TokenData');
		$this->load->model('UserModel','userModel');
		$this->load->helper('url');

		if($this->session->userdata['logged_in']['id']=="")
		{
			$this->session->set_flashdata('error','Kindly login again');
			redirect(base_url('/'));
			exit();
		}

		//require_once APPPATH . 'third_party/ebay-sdk/configuration.php';

		// token expired or not

		$where = "";
		$where = "expired_datetime >='".currentTime."'";

		$isTokenExpired = $this->userModel->tableData('tokenmaster',$where);
		if(count($isTokenExpired) == 0 ) // Token expired and need to generate new token
		{
			redirect(base_url('TokenController/index'));
		}
	}

	public function generateRandomString($length = 5)
	{
		$chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
		return substr(str_shuffle($chars),0,$length);
	}
	
	public function index()
	{
		$data['msgName'] = $this->msgName;
		$data['productList'] = $this->inventory->listInventory();
    	$data['page'] = 'product/productList';
    	$this->load->view('includes/template', $data);
    }


    public function addNewProduct()
    {
    	if(isset($_POST['btnAddNewProductSubmit'])) // request for submit new inventory
    	{
	    	$insertData= array('sku'=>$this->generateRandomString().time(),
	    						'quantity'=>$this->input->post('quantity'),
	    						'brand'=>$this->input->post('brand'),
	    						'opticalZoom'=>$this->input->post('opticalZoom'),
	    						'type'=>$this->input->post('type'),
	    						'recordingDefinition'=>$this->input->post('recordingDefinition'),
	    						'mediaFormat'=>$this->input->post('mediaFormat'),
	    						'storageType'=>$this->input->post('storageType'),
	    						'description'=>$this->input->post('description'),
	    						'title'=>$this->input->post('title')
	    					);

	    	$createInventory = $this->inventory->createOrUpdateInventory($insertData); // upadate and create method are same.
			if ($createInventory['status']==1) 
			{
				$this->session->set_flashdata('success', 'Product added successfully!');
				redirect(base_url('ProductController/index'));
			}
			else
			{
				$this->session->set_flashdata('error', 'Product is not added successfully!');
			}
    	}
    	else // add new product page
    	{
    		$data['msgName'] = $this->msgName;
			$data['page'] = 'product/addNewProduct';
			$this->load->view('includes/template', $data); 
		}
    }

    public function deleteInventory($sku)
    {
		$deleteInventory = $this->inventory->deleteInventory($sku);

		if ($deleteInventory['status']==1) 
		{
			$this->session->set_flashdata('success', 'Product deleted successfully!');
			redirect(base_url('ProductController/index'));
		}
		else
		{
			$this->session->set_flashdata('error', 'Product is not deleted!');
		}
    }

    public function editInventory($sku)
    {
	   	if(isset($_POST['btnUpdate'])) // request for update product
    	{
    		
    		$sku = $this->generateRandomString().time();
    		$quantity=$this->input->post('quantity');
	    	$brand=$this->input->post('brand');
	    	$opticalZoom=$this->input->post('opticalZoom');
	    	$type=$this->input->post('type');
	    	$recordingDefinition=$this->input->post('recordingDefinition');
	    	$mediaFormat=$this->input->post('mediaFormat');
	    	$storageType=$this->input->post('storageType');
	    	$description=$this->input->post('description');
	    	$title=$this->input->post('title');


	    	$insertData= array('sku'=>$sku,
	    						'quantity'=>50,
	    						'brand'=>$brand,
	    						'opticalZoom'=>$opticalZoom,
	    						'type'=>$type,
	    						'recordingDefinition'=>$recordingDefinition,
	    						'mediaFormat'=>$mediaFormat,
	    						'storageType'=>$storageType,
	    						'description'=>$description,
	    						'title'=>$title
	    					);

	    	$createInventory = $this->inventory->createOrUpdateInventory($insertData); // upadate and create method are same.
	    	if ($createInventory['status']==1) 
	    	{
	    		$this->session->set_flashdata('success', 'Product upadated successfully!');
                redirect(base_url('ProductController/index'));
			}
			else
			{
				$this->session->set_flashdata('error', 'Product is not upadated successfully!');
			}
    	}
    	else
    	{
    		$data['msgName'] = $this->msgName;
    		$data['productList'] = $this->inventory->editInventory($sku);
	    	$data['skuName'] = $sku;
	       	$data['page'] = 'product/editProduct';
	        $this->load->view('includes/template', $data);
	    }    	
    }

    /*public function getLocation()
    {
    	//$merchantKey = $this->generateRandomString().time();
		$data['locationList'] = $this->inventory->getLocation();
       	$data['page'] = 'location/locationList';
        $this->load->view('includes/template', $data);
    }*/

    /*public function deleteLocation($merchantLocationKey)
    {
        $deleteLocation = $this->inventory->deleteLocation($merchantLocationKey);

    	if ($deleteLocation['status']==1) 
    	{
    		$this->session->set_flashdata('success', 'Location deleted successfully!');
            redirect(base_url('Home/getLocation'));
		}
		else
		{
			$this->session->set_flashdata('error', 'Location is not deleted!');
		}
    }*/
}
