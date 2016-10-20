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

class Customer_model extends CI_Model
{
	public $table 			= "customers";
	public $tablePrimarykey = "id";
	
	/**
	 * Get All Customers
	 *
	 */
	public function getAllCustomers()
	{
		$this->db->select('*,'. $this->table . ".". $this->tablePrimarykey . ' as id')
				->from($this->table)
				->order_by($this->table . ".". $this->tablePrimarykey);
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	/**
	 * Get Single Customer
	 *
	 */
	public function getCustomerById($id = null)
	{
		if($id)
		{
			$this->db->select('*,'. $this->table . ".". $this->tablePrimarykey . ' as id')
				->from($this->table)
				->where('id', $id)
				->order_by($this->table . ".". $this->tablePrimarykey);
			$query = $this->db->get();
			
			return (array)$query->row();
		}	
		
		return false;
	}
	
	/**
	 * Add New Customer
	 * 
	 * @param array
	 * @param boolean - default false
	 * @return boolean
	 */
	public function addCustomer($data, $created = true)
	{
		if($created)
		{
			$data = array_merge($data, array('created' => date('Y-m-d H:i:s')) );
		}
		
		if($this->db->insert($this->table, $data))
		{
			return $this->db->insert_id();
		}
		
		return false;
	}
	
	public function updateCustomer($id, $data = null )
	{
		if($data)
		{
			$this->db->where('id', $id);
			if($this->db->update($this->table, $data))
			{
				return true;
			}
		}
		
		return false;
	}
        
}
