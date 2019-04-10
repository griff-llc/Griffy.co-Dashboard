<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

    var $table = 'persons';	
    
	var $column = array('username','email','password','insert_date','key');
    var $order = array('id' => 'desc');
    
    function __construct() {
        parent::__construct();        
        $this->load->database();
        $this->search = '';
    }

    public function Authentification() {
        $notif = array();
        $email = $this->input->post('email');
        $password = Utils::hash('sha1', $this->input->post('password'), AUTH_SALT);

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            $row = $query->row();
            
            $sess_data = array(
                'users_id' => $row->id,
                'email' => $row->email,
                'username' => $row->username,
                'flag' => $row->flag,
            );                
            $this->session->set_userdata('logged_in', $sess_data);                            
        } else {
            $notif['message'] = 'Username or password incorrect !';
            $notif['type'] = 'danger';
        }

        return $notif;
    }

    public function register() {
        $notif = array();

        $user_id = $this->db->query('SELECT NEXT VALUE FOR person_seq id')->row()->id;

        $data = array(
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => Utils::hash('sha1', $this->input->post('password'), AUTH_SALT),
            'insert_date'  => date("Y-m-d"),
            'id'    => $user_id
        );

        $this->db->insert($this->table, $data);

        $data = array(
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => Utils::hash('sha1', $this->input->post('password'), AUTH_SALT),
            'users_id' => $user_id,
            'flag' => 0
        );  

        if ($this->db->affected_rows() > 0) {
            $notif['message'] = 'Saved successfully';
            $notif['type'] = 'success';
            unset($_POST);
            $this->session->set_userdata('logged_in', $data);                
        } else {
            $notif['message'] = 'Fail to sign up !';
            $notif['type'] = 'danger';
        }
        return $notif;
    }

    public function check_email($email) {
        $sql = "SELECT * FROM persons WHERE email = " . $this->db->escape($email);
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            $row = $res->row();
            return $row;
        }
        return null;
    }

    /**
     * Get User List
     */
    function getUsers()
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
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
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
