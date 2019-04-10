<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('auth_model');        
    }

    /**
     * Get User Page
     */
    public function getuser() {
        $this->load->view('auth/userlist');
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
            //add html for action
            $row[] = ' <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_user('."'".$person->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
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

    public function ajax_delete($id)
    {
        $this->auth_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function setting()
    {
        $user = $this->auth_model->get_by_id($this->session->userdata('logged_in')['users_id']);        
        $this->load->view('auth/profile',$user);
    }

    public function ajax_save()
    {        
        
        $data['notif'] = [];
        $data['status'] = TRUE;
        $this->load->helper('security');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        
        if ($this->form_validation->run() == false) {
            $data['notif']['message'] = validation_errors();
            $data['notif']['type'] = 'danger';
        } 
        else {
            $data = array(
                'password' => Utils::hash('sha1', $this->input->post('password'), AUTH_SALT),                 
            );
            $this->auth_model->update(array('id' => $this->session->userdata('logged_in')['users_id']), $data);
            $data['notif']['message'] = 'Saved successfully';
            $data['notif']['type'] = 'success';
        }      
        echo json_encode($data);  
    }
}
