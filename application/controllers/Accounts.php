<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

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
		$this->load->model('account_model');
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
		$data['name'] = $data['page_title'] = "List of Accounts";
		$data['customers'] = $this->customer_model->getAllCustomers();
		$this->template->load('accounts/index',$data);
	}
	
	public function view($id = null)
	{
		$data['name'] = $data['page_title'] = "View Account";
		$data['accounts'] = $this->account_model->getCustomerEntriesById($id);
		$data['customerInfo'] = $this->customer_model->getCustomerById($id);
		$this->template->load('accounts/account_view',$data);
	}
}
