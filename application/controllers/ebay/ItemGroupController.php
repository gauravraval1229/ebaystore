<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItemGroupController extends CI_Controller {

	public $msgName = "Item Group";

	public function __construct() 
	{
		parent::__construct();

		$this->load->library('TokenData');
		$this->load->library('CheckLoginToken');
		$this->load->library('Inventory');
		$this->load->model('UserModel','userModel');
		$this->load->helper('url');

		$this->checklogintoken->checkCredential(); // check user is loggedin or not and token expired or not
	}

    public function generateRandomString($length = 4)
    {
	    $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
	    return substr(str_shuffle($chars),0,$length);
	}

    public function index()
    {
    	$data['msgName'] = $this->msgName;
		$data['itemGroupList'] = $this->inventory->getItemGroup();
       	$data['page'] = 'itemGroup/itemGroupList';
        $this->load->view('includes/template', $data);
    }

    public function addNewItemGroup()
    {
    	if(isset($_POST['btnAddNewItemGroupSubmit'])) // request for submit new item group
    	{
	    	$insertData= array('inventoryItemGroupKey' => $this->generateRandomString().time(),
	    						'title' => $this->input->post('title'),
	    						'description'=> $this->input->post('description')
	    					);
   	
	    	$createItemGroup = $this->inventory->createOrUpdateItemGroup($insertData); // upadate and create method are same.
	    	if ($createItemGroup['status']==1) 
	    	{
	    		$this->session->set_flashdata('success', 'Group item added successfully!');
                redirect(base_url('ebay/ItemGroupController/index'));
			}
			else
			{
				$this->session->set_flashdata('error', 'Group item is not added successfully!');
				redirect(base_url('ebay/ItemGroupController/index'));
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
            redirect(base_url('ebay/ItemGroupController/index'));
		}
		else
		{
			$this->session->set_flashdata('error', 'Item group is not deleted!');
		}
    }
}
