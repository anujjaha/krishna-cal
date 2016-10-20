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

class Account_model extends CI_Model
{
	public $table 				= "customer_account";
	public $tablePrimarykey 	= "id";
	public $tableJob 			= "jobs";
	public $tableJobPrimarykey 	= "id";
	
	/**
	 * Create Customer Account Entry
	 * 
	 * @param array Data
	 * @return int Last Insert Id
	 */
	public function customerAccountEntry($data = array())
	{
		if($data)
		{
			$data = array_merge($data, array( 'created_at' => date('Y-m-d H:i:s')));
			$this->db->insert($this->table, $data);
			return $this->db->insert_id();
		}
		
		return false;
	}
	
	/**
	 * Remove Job Transactions
	 * 
	 * @param int JobId
	 * @return boolean flag
	 */ 
	public function customerAccountRemoveEntrybyJobId($jobId = null)
	{
		if($jobId)
		{
			$this->db->where('job_id', $jobId);
			return $this->db->delete($this->table);
		}
		
		return false;
	}
	
	public function getCustomerEntriesById($customerId = null)
	{
		if($customerId)
		{
			$this->db->select('*, '.$this->table.'.'.$this->tablePrimarykey .' as id,'. $this->table.'.created_at as created_at,'. $this->tableJob.'.job_name as job_name')
					->from($this->table)
					->join($this->tableJob, $this->table. '.job_id = '. $this->tableJob. '.' .$this->tableJobPrimarykey, 'left')
					->where($this->table.'.customer_id', $customerId)
					->order_by($this->table.'.'.$this->tablePrimarykey );
			$query = $this->db->get();
			
			return $query->result_array();
		}
		
		return false;
	}
}
