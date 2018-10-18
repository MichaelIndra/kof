<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kantin extends CI_Controller {
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
                'title' => 'Kantin',
                'judul' => 'Dashboard Kantin KOF'
                
            );
            $this->load->view('header', $data);
            $this->load->view("kantin");   
            //$this->load->view('footer', $data);
                  

        }else{

            //jika session belum terdaftar, maka redirect ke halaman login
            redirect("login");

        }
    }
}