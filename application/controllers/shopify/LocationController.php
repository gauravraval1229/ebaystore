<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LocationController extends CI_Controller {

	public $msgName = "Location";
	public $title = "Shopify";

	public function __construct() {

		parent::__construct();
		$this->load->library('TokenData');
		$this->load->library('CheckLoginToken');
		$this->load->library('Inventory');
		$this->load->model('UserModel','userModel');
		$this->load->helper('url');

		$this->checklogintoken->checkCredential(); // check user is loggedin or not and token expired or not
	}

	public function generateRandomString($length = 4) {

		$chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
		return substr(str_shuffle($chars),0,$length);
	}

	public function index() {

		$data['title'] = $this->title;
		$data['msgName'] = $this->msgName;
		$data['locationList'] = $this->inventory->getLocation();
		$data['page'] = 'location/locationList';
		$this->load->view('includes/template', $data);
	}

	public function addNewLocation() {

		if(isset($_POST['btnAddNewLocationSubmit'])) // request for submit new location
		{

			$insertData = array(
						'merchantLocationKey' => $this->generateRandomString().time(),
						'address1' => $this->input->post('address1'),
						'address2' => $this->input->post('address2'),
						'city' => $this->input->post('city'),
						'state' => $this->input->post('state'),
						'country' => $this->input->post('country'),
						'postalCode' => $this->input->post('postalCode'),
						'locationInstruction' => $this->input->post('locationInstruction'),
						'name' => $this->input->post('name'),
						'phone' => $this->input->post('phone'),
						'locationType' => $this->input->post('locationType')
			);

			$createLocation = $this->inventory->createLocation($insertData); // create location

			if ($createLocation['status']==1) {

				$this->session->set_flashdata('success', 'Location created successfully!');
				redirect(base_url('LocationController/index'));
			}
			else {
				$this->session->set_flashdata('error', 'Location is not created successfully!');
			}
		}
		else { // just redirect on add new location page

			$data['title'] = $this->title;
			$data['msgName'] = $this->msgName;
			$data['page'] = 'location/addNewLocation';
			$this->load->view('includes/template', $data); 
		}
	}

	public function deleteLocation($merchantLocationKey)
	{
		$deleteLocation = $this->inventory->deleteLocation($merchantLocationKey);

		if ($deleteLocation['status']==1) {
			$this->session->set_flashdata('success', 'Location deleted successfully!');
			redirect(base_url('LocationController/index'));
		}
		else {
			$this->session->set_flashdata('error', 'Location is not deleted!');
		}
	}

	public function enableDisableLocation($action,$merchantLocationKey) {

		if($action=="enable") {
			$actionResult = $this->inventory->enableDisableLocation($action,$merchantLocationKey);
		}
		else if($action=="disable") {
			$actionResult = $this->inventory->enableDisableLocation($action,$merchantLocationKey);
		}

		if ($actionResult['status']==1) {
			$this->session->set_flashdata('success', 'Location '.$action.' successfully!');
			redirect(base_url('LocationController/index'));
		}
		else {
			$this->session->set_flashdata('error', 'Some error accurred in enable/disable.');
		}
	}
}
