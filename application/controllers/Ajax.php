<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function changeUserStatus()
	{
		if($this->input->post())
		{
			$id 		= $this->input->post('id');
			$updateData	= array(
				'status' => $this->input->post('status')
			);
			
			$this->load->model('customer_model');
			$status = $this->customer_model->updateCustomer($id, $updateData);
			if($status)
			{
				echo json_encode( array(
					'status' 	=> true,
					'message'	=> 'Customer Updated Successfully'
				));	
				die;
			}
			
			echo json_encode( array(
					'status' 	=> false,
					'message'	=> 'Error.. Unable to Update Customer'
				));	
				die;
		}
	}
	
	public function getCustomerMobileNumberById()
	{
		if($this->input->post())
		{
			$id = $this->input->post('id');
			
			$this->load->model('customer_model');
			$customer = $this->customer_model->getCustomerById($id);
			
			if($customer)
			{
				echo json_encode( array(
					'status' 	=> true,
					'mobile'	=> $customer['mobile']
				));	
				die;
			}
			
			echo json_encode( array(
					'status' 	=> false,
				));	
				die;
			
		}
	}
	
	public function addCashUserAccount()
	{
		if($this->input->post())
		{
			$this->load->model('account_model');
			$amount 	= $this->input->post('amount');
			$customerId = $this->input->post('customerId');
			$details 	= $this->input->post('details');
			
			$accEntry = array(
				'customer_id'	=> $customerId,
				'amount' 		=> $amount,
				'details'		=> $details,
				'created_by' 	=> getUserId(),
				't_type'		=> CREDIT
			);
			
			$accStatus = $this->account_model->customerAccountEntry($accEntry);
			
			if($accStatus)
			{
				addUserBalance('add', $customerId, $amount);
				echo json_encode(array(
					'status' => true
				));
				die;
			}
			
			echo json_encode(array(
					'status' => false
			));
			die;
		}
	}

	public function getAjaxJobDetails()
	{
		if($this->input->post())
		{
			$this->load->model('job_model');

			$jobId 	=  $this->input->post('id');
			$data 	= array(
				'name' 			=> "Edit Job",
				'page_title' 	=> "Edit Job",
				'jobInfo' 		=> $this->job_model->getJobById($jobId),
				'jobDetails' 	=> $this->job_model->getJobDetailsByJobId($jobId)
			);

			$this->load->view('ajax/view_job', $data);
		}	
	}

	public function getAjaxQuickJobEdit()
	{
		if($this->input->post())
		{
			$this->load->model('job_model');

			$jobId 	=  $this->input->post('id');
			$data 	= array(
				'name' 			=> "Edit Job",
				'page_title' 	=> "Edit Job",
				'jobInfo' 		=> $this->job_model->getJobById($jobId),
				'jobDetails' 	=> $this->job_model->getJobDetailsByJobId($jobId)
			);

			$this->load->view('ajax/quick_edit_job', $data);
		}	
	}

	public function ajaxPayJob()
	{
		if($this->input->post())
		{
			$jobId 			= $this->input->post('jobId');
			$amount 		= $this->input->post('amount');
			$details 		= $this->input->post('details');
			$customerId 	= $this->input->post('customerIid');

			$this->load->model('job_model');
			$this->load->model('account_model');
			
			$jobInfo = $this->job_model->getJobById($jobId);

			$jobAdvance = $jobInfo['job_advance'] + $amount ;
			$jobDue 	= $jobInfo['job_due'] - $amount ;

			$updateJob = array(
				'customer_id' 	=> $customerId,
				'job_advance' 	=> $jobAdvance,
				'job_due'		=> $jobDue
			);

			$status = $this->job_model->payJob($jobId, $updateJob);

			if($status)
			{
				$createAccountEntry = array(
					'customer_id' 	=> $customerId,
					'job_id'		=> $jobId,
					'amount'		=> $amount,
					'title' 		=> $details,
					'details' 		=> $details,
					't_type' 		=> CREDIT,
					'created_by'	=> getUserId()
				);
				$accountId = $this->account_model->customerAccountEntry($createAccountEntry);

				addUserBalance('add', $customerId, $amount);

				echo  json_encode(array(
					'status' => true
				));
				die;
			}
			
			echo json_encode(array(
				'status' => false
			));
			die;
		}
		return false;
	}

	public function updateJobStatus()
	{
		if($this->input->post())
		{
			$jobId = $this->input->post('job_id');
			$updateJobStatus = array(
				'job_status' =>	$this->input->post('job_status')
			);
			
			$this->load->model('job_model');

			$status = $this->job_model->updateJobStatus($jobId, $updateJobStatus);			

			if($status)
			{
				echo  json_encode(array(
					'status' => true
				));
				die;
			}
		}

		echo json_encode(array(
			'status' => false
		));
		die;
	}

}
