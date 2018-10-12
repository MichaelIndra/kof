<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
                //jika memang session sudah terdaftar, maka redirect ke halaman dahsboard
                redirect("dashboard");

            }else{

                //jika session belum terdaftar

                //set form validation
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');

                //set message form validation
                $this->form_validation->set_message('required', '<div class="alert alert-danger" style="margin-top: 3px">
                    <div class="header"><b><i class="fa fa-exclamation-circle"></i> {field}</b> harus diisi</div></div>');

                //cek validasi
                if ($this->form_validation->run() == TRUE) {

                //get data dari FORM
                $username = $this->input->post("username", TRUE);
                $password = md5($this->input->post('password', TRUE));

                //checking data via model
                $checking = $this->M_login->check_login(array('Nama' => $username), array('Password' => $password));

                //jika ditemukan, maka create session
                if ($checking != FALSE) {
                    foreach ($checking as $apps) {

                        $session_data = array(
                            'id_anggota'=> $apps->ID_Anggota,
                            'user_name' => $apps->Nama,
                            'user_pass' => $apps->Password,
                        );
                        //set session userdata
                        $this->session->set_userdata($session_data);

                        redirect('dashboard/');

                    }
                }else{
                    $data = array(
                        'title' => 'Login',
                        'judul' => 'Login Jemaat KOF',
                        'error' => '<div class="alert alert-danger" style="margin-top: 3px">
                                    <div class="header"><b><i class="fa fa-exclamation-circle"></i> ERROR</b> username atau password salah!</div></div>'
                    );
                    $this->load->view('header', $data);
                    $this->load->view('login', $data);
                }

            }else{
                $data = array(
                    'title' => 'Login',
                    'judul' => 'Login Jemaat KOF'
                );
                $this->load->view('header', $data);
                $this->load->view('login');
                //$this->load->view('footer', $data);
                
            }

        }

    }
}