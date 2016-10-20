<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct() {
		
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('customer_model');
		$this->load->library(array('form_validation'));
		$this->load->helper(array('url','language'));
	} 
	
	/**
	 * Show List of all Customers
	 * 
	 */
	public function index()
	{
		$data['name'] = $data['page_title'] = "List of all Customers";
		$data['customers'] = $this->customer_model->getAllCustomers();
		$this->template->load('customers/index',$data);
	}
	
	/**
	 * Add New Customer
	 * 
	 */ 
	public function add()
	{
		$data['name'] = $data['page_title'] = "Add New Customer";
		
		if($this->input->post())
		{
			$post 		= $this->input->post();
			$saveData 	= array(
				'company_name' 		=> $post['company_name'],
				'name' 				=> $post['name'],
				'mobile' 			=> $post['mobile'],
				'contact_number' 	=> $post['contact_number'],
				'emailid' 			=> $post['emailid'],
				'address' 			=> $post['address'],
				'city' 				=> $post['city'],
				'state' 			=> $post['state'],
				'pincode' 			=> $post['pincode']
			);
			
			$status = $this->customer_model->addCustomer($saveData);
			
			if($status)
			{
				redirect('customers/index', "refresh");
			}
			else
			{
				echo "ERROR !";
			}
		}
		
		$this->template->load('customers/add',$data);
	}
	
	public function edit($id = null)
	{
		$data['customerInfo'] = $this->customer_model->getCustomerById($id);
		$data['name'] = $data['page_title'] = "Edit Customer";
		
		if($this->input->post())
		{
			$post 		= $this->input->post();
			$id			= $post['id'];
			$updateData = array(
				'company_name' 		=> $post['company_name'],
				'name' 				=> $post['name'],
				'mobile' 			=> $post['mobile'],
				'contact_number' 	=> $post['contact_number'],
				'emailid' 			=> $post['emailid'],
				'address' 			=> $post['address'],
				'city' 				=> $post['city'],
				'state' 			=> $post['state'],
				'pincode' 			=> $post['pincode']
			);
			
			$status = $this->customer_model->updateCustomer($id, $updateData);
			
			if($status)
			{
				redirect('customers/index', "refresh");
			}
			else
			{
				echo "ERROR !";
			}
		}
		
		$this->template->load('customers/edit',$data);
	}
}
