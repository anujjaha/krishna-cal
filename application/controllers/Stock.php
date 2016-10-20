<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

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
		$this->load->model('stock_model');
		$this->load->library(array('form_validation'));
		$this->load->helper(array('url','language'));
	} 
	
	/**
	 * Show List of all Customers
	 * 
	 */
	public function index()
	{
		$data['name'] = $data['page_title'] = "List of Stock";
		$data['stock'] = $this->stock_model->getAllStock();
		$this->template->load('stock/index',$data);
	}

	public function add()
	{
		$data['name'] = $data['page_title'] = "Add New Stock";

		if($this->input->post())
		{
			$input = $this->input->post();
			
			$data = array(
				'title' => $input['title'],
				'stock' => $input['stock']
			);

			$status = $this->stock_model->create($data);

			redirect('stock/index', "refresh");
		}
		$this->template->load('stock/add',$data);	
	}
	
	public function view($id = null)
	{
		$data['name'] = $data['page_title'] = "View Account";
		$data['accounts'] = $this->account_model->getCustomerEntriesById($id);
		$data['customerInfo'] = $this->customer_model->getCustomerById($id);
		$this->template->load('accounts/account_view',$data);
	}
}
