<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Model
*
* Version: 2.5.2
*
* Author:  Ben Edmunds
* 		   ben.edmunds@gmail.com
*	  	   @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Last Change: 3.22.13
*
* Changelog:
* * 3-22-13 - Additional entropy added - 52aa456eef8b60ad6754b31fbdcc77bb
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/

class Job_model extends CI_Model
{
	public $table 						= "jobs";
	public $tablePrimarykey 			= "id";
	public $tableCustomers				= "customers";
	public $tableCustomersPrimarykey 	= "id";
	public $tableDetails				= "job_details";
	public $tableDetailsPrimarykey 		= "id";
	
	/**
	 * Add New Job
	 * 
	 * @param array Data
	 * @param boolean Date
	 * @return int
	 */
	public function addJob($data = null, $date = true)
	{
		if($date)
		{
			$now = date('Y-m-d H:i:s');
			$data = array_merge($data, array( 
				'job_month'		=> date('M-Y'),
				'created_at' 	=> $now,
				'updated_at' 	=> $now
			));
		}
		
		// Insert Job
		$this->db->insert($this->table, $data);
		
		//Job Id
		$jobId =$this->db->insert_id();
		
		addUserBalance(null, $data['customer_id'], $data['job_total']);
		addUserBalance('add', $data['customer_id'], $data['job_advance']);
		
		return $jobId;
	}
	
	/**
	 * Update Job
	 * 
	 * @param int Job Id
	 * @param array Data
	 * @param boolean Update date Flag
	 * @return boolean flag
	 */
	public function updateJob($jobId = null, $data = array(), $date = true)
	{
		$jobInfo = $this->getJobById($jobId);
		addUserBalance('add', $data['customer_id'], $jobInfo['job_due']);
		
		if($date)
		{
			$data = array_merge($data, array('updated_at' => date('Y-m-d H:i:s')));
		}
		addUserBalance(null, $data['customer_id'], $data['job_total']);
		addUserBalance('add', $data['customer_id'], $data['job_advance']);
		
		$this->db->where('id', $jobId);
		return $this->db->update($this->table, $data);
	}

	public function updateJobStatus($jobId = null, $data = array())
	{
		$this->db->where('id', $jobId);
		$this->db->update($this->table, $data);

		return true;
	}

	/**
	  * Pay Job
	  *
	  * @param int Job Id
	  * @param array Data
	  * @return boolean Success/Failure Flag
	  */
	public function payJob($jobId, $data = array())
	{
		if($jobId)
		{
			$this->db->where('id', $jobId);
			return $this->db->update($this->table, $data);
		}
	}
	
	/**
	 * Add New Job Details
	 * 
	 * @param array Data
	 * @param boolean Date
	 * @return int
	 */
	public function addJobDetails($data = null, $date = true)
	{
		if($date)
		{
			$data = array_merge($data, array('created_at' => date('Y-m-d H:i:s')));
		}
		
		$this->db->insert($this->tableDetails, $data);
		
		return $this->db->insert_id();
	}
	
	/**
	 * Get All Job List
	 *
	 */  
	public function getAllJobList()
	{
		$this->db->select('*, '.$this->table.'.id as job_id')
				->from($this->table)
				->join($this->tableCustomers, $this->tableCustomers.'.'.$this->tableCustomersPrimarykey. ' = ' .$this->table. '.customer_id', 'left')
				->order_by($this->table. '.' .$this->tablePrimarykey, 'DESC');
				
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getDashboardJobList()
	{
		$this->db->select('*, '.$this->table.'.id as job_id')
				->from($this->table)
				->join($this->tableCustomers, $this->tableCustomers.'.'.$this->tableCustomersPrimarykey. ' = ' .$this->table. '.customer_id', 'left')
				->or_where('job_status', 'Pending')
				->order_by($this->table. '.' .$this->tablePrimarykey, 'DESC');
				
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	/**
	 * Get Job By Id
	 * 
	 * @param int Id
	 * @return array Job Info
	 */ 
	public function getJobById($id = null)
	{
		$this->db->select('*, '.$this->table.'.id as job_id')
				->from($this->table)
				->join($this->tableCustomers, $this->tableCustomers.'.'.$this->tableCustomersPrimarykey. ' = ' .$this->table. '.customer_id', 'left')
				->where($this->table. '.' .$this->tablePrimarykey, $id)
				->order_by($this->table. '.' .$this->tablePrimarykey, 'DESC');
				
		$query = $this->db->get();
		return (array) $query->row();
	}
	
	/**
	 * Get Job Details by Job Id
	 * 
	 * @param int Job Id
	 */ 
	public function getJobDetailsByJobId($jobId = null)
	{
		if($jobId)
		{
			$this->db->select('*')
					 ->from($this->tableDetails)
					 ->where('job_id', $jobId)
					 ->order_by($this->tableDetails. '.' .$this->tableDetailsPrimarykey);
			
			$query = $this->db->get();
			return $query->result_array();
		}
		
		return false;
	}
	
	public function removeJobDetailsByJobId($jobId = null )
	{
		if($jobId)
		{
			$this->db->select('*')
					 ->from($this->tableDetails)
					 ->where('job_id', $jobId);

			$query = $this->db->get();
			$this->load->model('stock_model');
			  
			foreach($query->result_array() as $jobInfo)
			{
				if($jobInfo['category'] != 'General')
				{
					$this->stock_model->addStock($jobInfo['category'], $jobInfo['qty']);
				}
			}

			$this->db->where('job_id', $jobId);
			return $this->db->delete($this->tableDetails);
		}
		
		return false;
	}
}	
