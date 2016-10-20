<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {

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
		$this->load->model('stock_model');
		$this->load->model('customer_model');
		$this->load->model('job_model');
		$this->load->library(array('form_validation'));
		$this->load->helper(array('url','language'));
	} 
	
	/**
	 * Dashboard Job List
	 *
	 */ 
	public function index()
	{
		$data['name'] = $data['page_title'] = "List of All Jobs";
		$data['jobs'] = $this->job_model->getDashboardJobList();
		$this->template->load('jobs/index',$data);
	}

	/**
	 * Show List of all Jobs
	 *
	 */ 
	public function all()
	{
		$data['name'] = $data['page_title'] = "List of All Jobs";
		$data['jobs'] = $this->job_model->getAllJobList();
		$this->template->load('jobs/index',$data);
	}
	
	/**
	 * Create New Job
	 * 
	 */ 
	public function add() { 
	    $data['name'] = $data['page_title'] = "Create New Job";
	    if($this->input->post())
	    {
			$input 		= $this->input->post();
			$partyType 	= $input['partyType'];
			
			if($partyType == 1 )
			{
				$saveCustomer = array(
					'name' 			=> $input['name'],
					'mobile' 		=> $input['customer_mobile'],
					'company_name' 	=> $input['company_name'],
					'address' 		=> $input['address'],
				);
				
				$customerId = $this->customer_model->addCustomer($saveCustomer);
			}
			else
			{
				$customerId = $input['customer_id'];
			}
			
			$saveJob = array(
				'customer_id'	 	=> $customerId,
				'job_name' 			=> $input['job_name'],
				'job_total' 		=> $input['sub_total'],
				'job_advance' 		=> $input['advance'],
				'job_due' 			=> $input['due'],
				'job_payment_term' 	=> $input['payment_term'],
			);
			
			$jobId = $this->job_model->addJob($saveJob);
			
			if($jobId)
			{
				for($i=0; $i<=5; $i++)
				{
					if(isset($input['details_'.$i]) && !empty($input['details_'.$i]))
					{
						$jobDetails = array(
							'job_id' => $jobId,
							'customer_id' => $customerId,
							'category' => $input['category_'.$i],
							'details' => $input['details_'.$i],
							'qty' => $input['qty_'.$i],
							'rate' => $input['rate_'.$i],
							'sub_total' => $input['subtotal_'.$i],
						);
						
						$this->job_model->addJobDetails($jobDetails);

						if($input['category_'.$i] != "General")
						{
							$this->stock_model->reduceStock($input['category_'.$i], $input['qty_'.$i]);
						}
					}
				}
			}	
			
			$createAccountEntry = array(
				'customer_id' 	=> $customerId,
				'job_id'		=> $jobId,
				'amount'		=> $input['sub_total'],
				'title' 		=> 'Created New Job',
				't_type' 		=> DEBIT,
				'created_by'	=> getUserId()
			);
			$accountId = $this->account_model->customerAccountEntry($createAccountEntry);
			
			if($input['advance'] > 0 )
			{
				$createAccountEntry = array(
					'customer_id' 	=> $customerId,
					'job_id'		=> $jobId,
					'amount'		=> $input['advance'],
					'title' 		=> 'Advanced',
					'details' 		=> $input['payment_term'],
					't_type' 		=> CREDIT,
					'created_by'	=> getUserId()
				);
				$accountId = $this->account_model->customerAccountEntry($createAccountEntry);
			}

			$userInfo = getUserInfoById($customerId);
			if($userInfo)
			{
				$smsText = "Dear " .$userInfo->name. ", Your Calendar Job is created. Reference Job Id " .$jobId. " Job Cost ". $input['sub_total'] ." Advance Paid " .$input['advance']. " Due amount is " .$input['due']. ". Thank You.";
				send_sms($userInfo->mobile, $smsText);	

				if($userInfo->emailid)
				{	
					$jobInfo 	= $this->job_model->getJobById($jobId);
					$jobDetails = $this->job_model->getJobDetailsByJobId($jobId);
					$fileLink 	= getPdfReceipt($jobInfo, $jobDetails);
					$content 	= getReceiptContent($jobInfo, $jobDetails);
					send_mail($userInfo->emailid, FROM_EMAIL_ID, FROM_EMAIL_NAME, "", $fileLink, $content);	
				}
				
			}
			redirect('jobs/jobprint/'.$jobId, "refresh");
		}
	    $this->template->load('jobs/add',$data);
	}

	public function jobprint($jobId = null)
	{
		$data['jobInfo'] 	= $this->job_model->getJobById($jobId);
		$data['jobDetails'] = $this->job_model->getJobDetailsByJobId($jobId);
		$this->template->load('jobs/job_print',$data);
	}
	
	/**
	 * Edit Job
	 *
	 * @param int Id
	 */ 
	public function edit($id = null)
	{
		$data['name'] = $data['page_title'] = "Edit Job";
		
		if($this->input->post())
		{
			$input 		= $this->input->post();
			$jobId 		= $input['id'];
			$customerId	= $input['customer_id'];
			
			$updateJob = array(
				'customer_id' 		=> $input['customer_id'],
				'job_name' 			=> $input['job_name'],
				'job_total' 		=> $input['sub_total'],
				'job_advance' 		=> $input['advance'],
				'job_due' 			=> $input['due'],
				'job_payment_term' 	=> $input['payment_term'],
			);
			
			$this->job_model->updateJob($jobId, $updateJob);
			
			$this->account_model->customerAccountRemoveEntrybyJobId($jobId);
			
			$createAccountEntry = array(
				'customer_id' 	=> $customerId,
				'job_id'		=> $jobId,
				'amount'		=> $input['sub_total'],
				'title' 		=> 'Updated Job',
				't_type' 		=> DEBIT,
				'created_by'	=> getUserId()
			);
			$accountId = $this->account_model->customerAccountEntry($createAccountEntry);
			
			if($accountId && $input['advance'] > 0 )
			{
				$createAccountEntry = array(
					'customer_id' 	=> $customerId,
					'job_id'		=> $jobId,
					'amount'		=> $input['advance'],
					'title' 		=> 'Advanced',
					'details' 		=> $input['payment_term'],
					't_type' 		=> CREDIT,
					'created_by'	=> getUserId()
				);
				$accountId = $this->account_model->customerAccountEntry($createAccountEntry);

			}
			
			$this->job_model->removeJobDetailsByJobId($jobId);
			
			for($i=0; $i<=5; $i++)
			{
				if(isset($input['details_'.$i]) && !empty($input['details_'.$i]))
				{
					$jobDetails = array(
						'job_id' => $jobId,
						'customer_id' => $customerId,
						'category' => $input['category_'.$i],
						'details' => $input['details_'.$i],
						'qty' => $input['qty_'.$i],
						'rate' => $input['rate_'.$i],
						'sub_total' => $input['subtotal_'.$i],
					);
					
					$this->job_model->addJobDetails($jobDetails);

					if($input['category_'.$i] != "General")
					{
						$this->stock_model->reduceStock($input['category_'.$i], $input['qty_'.$i]);
					}
				}
			}
			
			redirect('jobs/jobprint/'.$jobId, "refresh");
		}
		
		$data['jobInfo'] 	= $this->job_model->getJobById($id);
		$data['jobDetails'] = $this->job_model->getJobDetailsByJobId($id);
		
		$this->template->load('jobs/edit',$data);
	}
}
