<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
             
    }

    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        redirect(base_url('auth/login'));        
        exit;
    }

	public function index()
	{        
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('welcome/logout'));
            exit;
        }
        $data = $this->session->userdata('logged_in');
		$this->load->view('dashboard/welcome_message',$data);
    }
    
    public function Load_Notes()
    {
        $this->load->view('note/notes');
    }
}
