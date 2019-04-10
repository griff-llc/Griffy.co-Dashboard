<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('setting_model');        
    }

    /**
     * key Page
     */
    public function index() {
        $this->load->view('setting/index');
    }

    /**
     * Get user list
     */
    public function ajax_list()
    {
        $list = $this->setting_model->getInfo();
        
        $data = array();
        $no = $_POST['start'];
        $ss = 0;
        foreach ($list as $person) {
            $no++;
            $ss++;
            $row = array();
            $row[] = $person->order;
            $row[] = $person->name;            
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_user('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->setting_model->count_all(),
            "recordsFiltered" => $this->setting_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //Get User by id
    public function ajax_edit($id)
    {
        $data = $this->setting_model->get_by_id($id);
        echo json_encode($data);
    }    

    public function ajax_update()
	{
		$data = array(
            'name' => $this->input->post('name'),			
		);
		$this->setting_model->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
}
