<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model {

    var $table = 'table_header';	
    
	var $column = array('name','order');
    var $order = array('id' => 'asc');
    
    function __construct() {
        parent::__construct();        
        $this->load->database();
        $this->search = '';
    }

    public function getAllList()
    {
        $this->db->from($this->table);		
		$query = $this->db->get();
		return $query->result();
    }

    /**
     * Get List
     */
    public function getInfo()
	{
		$this->_get_user_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }
    
    /**
     * Generate Query
     */
    private function _get_user_query()
	{
		
		$this->db->from($this->table);
		$i = 0;

		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])
				($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
			$column[$i] = $item;
			$i++;
		}
		
		// if(isset($_POST['order']))
		// {
		// 	$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		// } 
		//else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
    }
    
    /**
     * Get User by id
     */
    public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
    }
    
    /**
     * Get all user count
     */
    public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
    }
    
    /**
     * Get filtered user count
     */
    function count_filtered()
	{
		$this->_get_user_query();
		$query = $this->db->get();
		return $query->num_rows();
    }
    
    /**
     * Delete user
     */
    public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
    }
    
    /**
     * Update
     */
    public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
}
