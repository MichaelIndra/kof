<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class jemaat extends CI_Controller
	{
        // function __construct(){
        //     parent::__construct();

        //     // if($this->session->userdata('status') != "login"){
        //     //     redirect("login");
        //     // }
        // }

        public function __construct()
        {
            parent::__construct();
            //load model admin
            $this->load->model('M_login');
        }

        function index(){
            // $master = $this->jemaat->getAllJemaat()->result();
            // $data['datamaster'] = $master;

            if ($this->M_login->logged_id()){
                $this->load->model('m_komsel');
                $data = array(
                    'title' => 'Jemaat KOF',
                    'judul' => 'Data Jemaat KOF',
                    'datakomsel' => $this->m_komsel->getKomsel()
                    
                );
                $this->load->view('header', $data);
                $this->load->view('dashboard_detail');
                $this->load->view('jemaat_v', $data);
                $this->load->view('footer', $data);
            }else{
                redirect("login");
            }
        }

        function editJemaat(){
            $this->load->model('m_jemaat');
            $id = $this->input->post('idAnggota');
            $datatables['col-display'] = array(
                'Nama',
                'Nama_Panggilan',
                'Komsel',
                'Alamat',
                'JenisKelamin',
                'No_HP',
                'No_WA',
                'TGL_Lahir',
                'Email'
            );
            $this->m_jemaat->getJemaatbyId($id, $datatables);
        }

        function doEditJemaat(){
            
            $namalengkap = strtoupper($this->input->post('namajemaat'));
            
            $this->load->model('m_jemaat');
            $datamaster = array(
                'ID_Anggota'=>$this->input->post('idanggota'),         
                'Nama'=>strtoupper($this->input->post('namajemaat')),
                'Nama_Panggilan'=>strtoupper($this->input->post('namapanggilan')),
                'Komsel'=>strtoupper($this->input->post('komsel')),
                'Alamat'=>strtoupper($this->input->post('alamat')),
                'JenisKelamin'=>strtoupper($this->input->post('jeniskelamin')),
                'No_HP'=>strtoupper($this->input->post('nohp')),
                'No_WA'=>strtoupper($this->input->post('nowa')),
                'Email'=>strtoupper($this->input->post('email')),
                'TGL_Lahir'=>strtoupper($this->input->post('tgllahir'))
                
            );
            $res = $this->m_jemaat->updateJemaat($datamaster);
            
            $result = array('res'=>$res);
            echo json_encode($result);            
        }

        function datakomsel(){
            $this->load->model('m_komsel');
            $data = $this->m_komsel->getKomsel();
            print_r($data);
        }

        function insertJemaatView(){
            $this->load->model('m_komsel');
            $data = array(
                'title' => 'Jemaat KOF',
                'judul' => 'Input Jemaat KOF',
                'datakomsel' => $this->m_komsel->getKomsel()
            );
            $this->load->view('header', $data);
            $this->load->view('jemaat_i', $data);
            $this->load->view('footer', $data);
        }

        public function valid_date($date)
        {
            $d = DateTime::createFromFormat('Y-m-d', $date);
            return $d && $d->format('Y-m-d') === $date;
        }

        function insertJemaatData(){
            $this->form_validation->set_rules('namajemaat','Nama Jemaat','required');
            $this->form_validation->set_rules('namapanggilan','Nama Panggilan','required');
            $this->form_validation->set_rules('komsel','Komsel','required');
            $this->form_validation->set_rules('alamat','Alamat','required');
            $this->form_validation->set_rules('jeniskelamin','Jenis Kelamin','required');
            $this->form_validation->set_rules('nohp','No HP','required|numeric');
            $this->form_validation->set_rules('tgllahir','Tanggal Lahir','required');
            if($this->form_validation->run() == FALSE){
                $data = array(
                    'title' => 'Jemaat KOF',
                    'judul' => 'Input Jemaat KOF'
                );
                $this->load->view('header', $data);
                $this->load->view('jemaat_i', $data);
                $this->load->view('footer', $data);
            }else{
                $namalengkap = strtoupper($this->input->post('namajemaat'));
                $arr = explode(' ',$namalengkap);
                $id_anggota = "";
                $pass = "";
                foreach ($arr as $kata){
                    $id_anggota .= substr($kata, 0, 1);
                    $pass .= $kata;
                }
                $password = md5($pass);

                $this->load->model('m_jemaat');
                $datamaster = array(
                    'ID_Anggota'=>$id_anggota.rand(0,9999),         
                    'Nama'=>strtoupper($this->input->post('namajemaat')),
                    'Nama_Panggilan'=>strtoupper($this->input->post('namapanggilan')),
                    'Komsel'=>strtoupper($this->input->post('komsel')),
                    'Password'=>$password,
                    'Alamat'=>strtoupper($this->input->post('alamat')),
                    'JenisKelamin'=>strtoupper($this->input->post('jeniskelamin')),
                    'No_HP'=>strtoupper($this->input->post('nohp')),
                    'No_WA'=>strtoupper($this->input->post('nowa')),
                    'Email'=>strtoupper($this->input->post('email')),
                    'TGL_Lahir'=>strtoupper($this->input->post('tgllahir'))
                    
                );
                $res = $this->m_jemaat->saveMaster($datamaster);
                if($res == 1){
                     redirect('jemaat');
                }  else {
                    
                    $data = array(
                        'title' => 'Jemaat KOF',
                        'judul' => 'Input Jemaat KOF',
                        'error' => 'Ada data yang sama dengan id '.strtoupper($this->input->post('idsupp')).'. Mohon periksa kembali'
                    );
                    $this->load->view('header', $data);
                    $this->load->view('jemaat_i', $data);
                    $this->load->view('footer', $data);
                
                }
            }
        }

        function iseng(){
            $this->load->model('m_jemaat');
                /**
                 * Mengambil Parameter dan Perubahan nilai dari setiap 
                 * aktifitas pada table
                *
                */
                $datatables  = $_POST;
                $datatables['table']    = 'anggota';
                $datatables['id-table'] = 'ID_Anggota';
                
                /**
                 * Kolom yang ditampilkan
                 */
                $datatables['col-display'] = array(
                            'Nama',
                            'Komsel',
                            'Alamat'
                            
                            );
                $datatables['col-join'] = array(
                    'anggota.Nama',
                    'komsel.Komsel',
                    'anggota.Alamat'
                    
                    );            
                /**
                * menggunakan table join
                */
                $datatables['join']    = 'INNER JOIN komsel ON komsel.no = anggota.Komsel';
                $this->m_jemaat->Datatablescoba($datatables);
            
        }

        function datatables_ajax()
        {
            /** AJAX Handle */
            if( $this->input->is_ajax_request() )  {
                $this->load->model('m_jemaat');
                /**
                 * Mengambil Parameter dan Perubahan nilai dari setiap 
                 * aktifitas pada table
                *
                */
                $datatables  = $_POST;
                $datatables['table']    = 'anggota';
                $datatables['id-table'] = 'ID_Anggota';
                
                /**
                 * Kolom yang ditampilkan
                 */
                $datatables['col-join'] = array(
                            'anggota.ID_Anggota',
                            'anggota.Nama',
                            'anggota.Nama_Panggilan',
                            'komsel.Komsel',
                            'anggota.Alamat',
                            'anggota.JenisKelamin',
                            'anggota.No_HP',
                            'anggota.No_WA',
                            'anggota.TGL_Lahir',
                            'anggota.Email'
                            );
                $datatables['col-search'] = array(
                    'anggota.Nama',
                    'anggota.Nama_Panggilan',
                    'komsel.Komsel',
                    'anggota.Alamat',
                    'anggota.JenisKelamin',
                    'anggota.No_HP',
                    'anggota.No_WA',
                    'anggota.TGL_Lahir',
                    'anggota.Email'
                    );            
                $datatables['col-display'] = array(
                    'Nama',
                    'Nama_Panggilan',
                    'Komsel',
                    'Alamat',
                    'JenisKelamin',
                    'No_HP',
                    'No_WA',
                    'TGL_Lahir',
                    'Email'
                    );
                /**
                * menggunakan table join
                */
                $datatables['join']    = 'INNER JOIN komsel ON komsel.no = anggota.Komsel';
                $this->m_jemaat->Datatables($datatables);
            }
            return;
        }

    }