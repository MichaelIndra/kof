<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class absensi extends CI_Controller
	{
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
                $data = array(
                    'title' => 'Absensi KOF',
                    'judul' => 'Data Absen KOF'
                );
                $this->load->view('header', $data);
                $this->load->view('dashboard_detail');
                $this->load->view('absen_i', $data);
                $this->load->view('footer', $data);
            }else{
                redirect("login");
            }
        }

        function saveAbsen(){
            $this->load->model('m_absensi');
            $nama = $this->input->post('nama');
            $datamaster = array(
                'ID_Anggota'=>strtoupper($this->input->post('idanggota')),         
                'Tanggal'=>strtoupper($this->input->post('tanggal'))               
            );
            $res = $this->m_absensi->saveAbsensi($datamaster);
            $res = array('res'=>$res);
            echo json_encode($res);
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
                            'anggota.Alamat'
                            );
                $datatables['col-display'] = array(
                    'Nama',
                    'Komsel',
                    'Alamat'
                    );
                $datatables['col-search'] = array(
                    'anggota.ID_Anggota',
                    'anggota.Nama',
                    'anggota.Nama_Panggilan',
                    'anggota.Komsel',
                    'anggota.Alamat'
                    );
                /**
                * menggunakan table join
                */
                $datatables['join']    = 'INNER JOIN komsel ON komsel.no = anggota.Komsel';
                $this->m_jemaat->Datatables_absensi($datatables);
            }
            return;
        }


    }