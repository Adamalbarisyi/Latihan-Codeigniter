<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {


	public function __construct()
	{
        parent::__construct();
        $this->load->model('user_model');
    }

    public function profile()
    {
        if(!$this->user_model->is_LoggedIn()){
            redirect('login');
        }

        $data['user'] = $this->user_model->get_user('id',$_SESSION['user_id']);
        $this->load->view('layouts/header');
        $this->load->view('user/profile',$data);
    }
}
 