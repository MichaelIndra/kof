<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->model('M_login');
    }

    public function index()
    {
        if($this->M_login->logged_id())
        {
            $data = array(
                'title' => 'Dashboard',
                'judul' => 'Dashboard KOF'
                
            );
            $this->load->view('header', $data);
            $this->load->view("dashboard");   
            //$this->load->view('footer', $data);
                  

        }else{

            //jika session belum terdaftar, maka redirect ke halaman login
            redirect("login");

        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

}