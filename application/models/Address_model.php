<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Address_model extends CI_Model {

    var $table = 'address';	
    
	var $column = array('identify','street_number','street_name','street_suffix','city','state','zipcode','data_addtime','data_starttime');
    var $order = array('id' => 'desc');
    
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->search = '';
    }

    public function getTotalAddress()
    {
        $this->db->from($this->table);
		$user_id = $this->session->userdata('logged_in')['users_id'];
        $this->db->where('user_id',$user_id);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get User List
     */
    public function getAddress()
	{
		$this->_get_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }
    
    /**
     * Generate Query
     */
    private function _get_query()
	{
		
		$this->db->from($this->table);
		$i = 0;
        
        if($_POST['search']['value'])
            $this->db->group_start();
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])
                ($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);                        
			$column[$i] = $item;
			$i++;
        }
        
        if($_POST['search']['value'])
            $this->db->group_end();
        
        $user_id = $this->session->userdata('logged_in')['users_id'];
        $this->db->where('user_id',$user_id);

		if(isset($_POST['order']))
		{
            //if(in_array($_POST['order'],$column))
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
		$this->_get_query();
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
    
    /**
     * Save
     */
    public function save($data)
	{
        $id = $this->db->query('SELECT NEXT VALUE FOR address_seq id')->row()->id;
        $data['id'] = $id;        
        $data['user_id'] = $this->session->userdata('logged_in')['users_id'];
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
    }   
    
    public function insert_csv($data)
    {
        foreach($data as $row)
        {
            $id = $this->db->query('SELECT NEXT VALUE FOR address_seq id')->row()->id;
            $row['id'] = $id;        
            $this->db->insert($this->table, $row);
        }
    }

    private function callAPI($method, $url, $data){
        $curl = curl_init();
     
        switch ($method){
           case "POST":
              curl_setopt($curl, CURLOPT_POST, 1);
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              break;
           case "PUT":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
              break;
           default:
              if ($data)
                 $url = sprintf("%s?%s", $url, http_build_query($data));
        }
     
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           //'APIKEY: 111111111111111111111',
           'Content-Type: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
     
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
     }

     public function getApiData($id)
     {
        $row = $this->get_by_id($id);
        $key = $this->get_by_id_from_person();

        $data_array =  array(
            "zws-id"        => $key->key,
            "address"       => sprintf('%s %s %s',$row->street_number,$row->street_name,$row->state),             //8920 TAHOE LN
            'citystatezip'  => $row->city,
        );
      
        $make_call = $this->callAPI('GET', 'http://www.zillow.com/webservice/GetDeepSearchResults.htm', ($data_array));        
        $rt = simplexml_load_string($make_call);        
        $rt = json_decode(json_encode($rt),true);

        if($this->checkData($rt)) {
            $result =  $rt['response']['results']['result'];
            $data = array(
                'xml' => $make_call ,
                'data_starttime' => date('Y-m-d'),           
            );
            $this->address_model->update(array('id' => $id), $data);  
        } else {
        }
    }

    public function get_by_id_from_person()
	{
		$this->db->from("persons");
		$this->db->where('id',$this->session->userdata('logged_in')['users_id']);
        $query = $this->db->get();        
		return $query->row();
    }

    public function checkData($data) {

        if(!isset($data['message']['text'])) {
            return false;
        }

        if(strpos($data['message']['text'],'Error')>0) {
            return false;
        }

        if(!isset($data['response']['results'])) {
            return false;
        }
            
        if(sizeof($data['response']['results']) != 1) {
            return false;
        }            
        return true;
    }
}
