<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItemGroupController extends CI_Controller {

	public $msgName = "Item Group";

	public function __construct() 
	{
		parent::__construct();
		$this->load->library('Inventory');
		$this->load->helper('url');

		if($this->session->userdata['logged_in']['id']=="")
		{
			$this->session->set_flashdata('error','Kindly login again');
			redirect(base_url('/'));
			exit();
		}
	}

    public function generateRandomString($length = 4)
    {
	    $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
	    return substr(str_shuffle($chars),0,$length);
	}

    public function index()
    {
    	$data['msgName'] = $this->msgName;
		//$data['itemGroupList'] = $this->inventory->getItemGroup();
       	$data['page'] = 'itemGroup/itemGroupList';
        $this->load->view('includes/template', $data);
    }

    public function addNewItemGroup()
    {
    	if(isset($_POST['btnAddNewItemGroupSubmit'])) // request for submit new inventory
    	{
    		$inventoryItemGroupKey = $this->generateRandomString().time();
	    	$title=$this->input->post('title');
	    	$description=$this->input->post('description');


	    	$insertData= array('inventoryItemGroupKey'=>$inventoryItemGroupKey,
	    						'title'=>$title,
	    						'description'=>$description
	    					);

	    	$createItemGroup = $this->inventory->createOrUpdateItemGroup($insertData); // upadate and create method are same.
	    	if ($createItemGroup['status']==1) 
	    	{
	    		$this->session->set_flashdata('success', 'Product added successfully!');
                redirect(base_url('itemGroup/itemGroupList'));
			}
			else
			{
				$this->session->set_flashdata('error', 'Product is not added successfully!');
			}
    	}
    	else // add new item group page
    	{
    		$data['msgName'] = $this->msgName;
			$data['page'] = 'itemGroup/addNewItemGroup';
			$this->load->view('includes/template', $data); 
		}
    }

    public function deleteItemGroup($inventoryItemGroupKey)
    {
        $deleteItemGroup = $this->inventory->deleteItemGroup($inventoryItemGroupKey);

    	if ($deleteItemGroup['status']==1) 
    	{
    		$this->session->set_flashdata('success', 'Item group deleted successfully!');
            redirect(base_url('ItemGroupController/index'));
		}
		else
		{
			$this->session->set_flashdata('error', 'Item group is not deleted!');
		}
    }
}
