<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Key extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('auth_model');        
    }

    /**
     * key Page
     */
    public function index() {
        $this->load->view('key/index');
    }

    /**
     * Get user list
     */
    public function ajax_list()
    {
        $list = $this->auth_model->getUsers();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $no++;
            $row = array();
            $row[] = $person->username;
            $row[] = $person->email;
            $row[] = $person->insert_date;
            $row[] = $person->key;
            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_user('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->auth_model->count_all(),
            "recordsFiltered" => $this->auth_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //Get User by id
    public function ajax_edit($id)
    {
        $data = $this->auth_model->get_by_id($id);
        echo json_encode($data);
    }    

    public function ajax_update()
	{
		$data = array(
            'key' => $this->input->post('key'),			
		);
		$this->auth_model->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
}
