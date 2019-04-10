<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('auth_model');
        if ($this->session->userdata('logged_in')) {
            redirect(base_url('welcome'));
            exit;
        }
    }

    /**
     *    Login Page 
     */
    public function index() {
        redirect(base_url('auth/signin'));
    }

    /**
     *   Sign in
     */
    public function login() {
        $data['title'] = 'Login';
        

        if (count($_POST)) {
            $this->load->helper('security');
            $this->form_validation->set_rules('email', 'Email address', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

            if ($this->form_validation->run() == false) {
                $data['notif']['message'] = validation_errors();
                $data['notif']['type'] = 'danger';
            } 
            else {
                $data['notif'] = $this->auth_model->Authentification();
            }
        }        
        if ($this->session->userdata('logged_in')) {            
            redirect(base_url('welcome'));
            exit;
        }
        
        $this->load->view('auth/signin',$data);
    }

    /**
     *   User Sign Up
     */
    public function signup() {
        $data['title'] = 'Sign Up';

        if (count($_POST)) {
            $this->load->helper('security');
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[persons.email]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
            
            if ($this->form_validation->run() == false) {
                $data['notif']['message'] = validation_errors();
                $data['notif']['type'] = 'danger';
            } 
            else {
                $data['notif'] = $this->auth_model->register();
            }
        }
        
        if ($this->session->userdata('logged_in')) {
            redirect(base_url('welcome'));
            exit;
        }

        $this->load->view('auth/signup', $data);        
    }

    /*
     * Custom callback function
     */

    public function password_check($str) {
        if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
            return true;
        }
        return false;
    }
}
