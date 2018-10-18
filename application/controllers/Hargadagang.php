<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class hargadagang extends CI_Controller
	{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('M_login');
            $this->load->model('M_dagangan');
            $this->load->model('M_hargadagang');
        }

        function index(){
            if ($this->M_login->logged_id()){
                $data = array(
                    'title'     => 'Kantin KOF',
                    'judul'     => 'Harga Dagangan Kantin KOF',
                    'dagangan'  => $this->M_dagangan->getDaganganbyIdSupp()
                );
                $this->load->view('header', $data);
                $this->load->view('dashboard_kantin');
                $this->load->view('hargadagang', $data);
                $this->load->view('footer', $data);
            }else{
                redirect("login");
            }
        }

        function saveHarga(){

            $namaSupp = strtoupper($this->input->post('namasupp'));
            $idsupp = str_replace(' ', '', $namaSupp);
            $datamaster = array(
                'ID_Dagang'     => strtoupper($this->input->post('iddagang')),
                'Harga_Hpp'     => $this->input->post('hargahpp'),
                'Harga_Jual'    => $this->input->post('hargajual'),
                'Tgl_Awal'      => $this->input->post('tglawal')            
            );
            $res = $this->M_hargadagang->saveMaster($datamaster);
            
            $result = array('res'=>$res);
            echo json_encode($result);
        }

        function getDaganganbyId(){
            $this->M_dagangan->getDaganganbyIdSupp();   
        }

        function getsupp(){
            echo json_encode($this->M_supplier->getSupplier());
        }
        
        function datatables_ajax()
        {
            /** AJAX Handle */
            if( $this->input->is_ajax_request() )  {
                /**
                 * Mengambil Parameter dan Perubahan nilai dari setiap 
                 * aktifitas pada table
                *
                */
                $datatables  = $_POST;
                $datatables['id-table'] = 'k_hargadagang.no';
                
                /**
                 * Kolom yang ditampilkan
                 */
                $datatables['col-display'] = array(
                    'Nama',
                    'Nama_Dagangan',
                    'Harga_Hpp',
                    'Harga_Jual',
                    'Tgl_Awal'
                    );

                $datatables['col-join'] = array(
                    'mstr.Nama',
                    'mstr.Nama_Dagangan',
                    'k_hargadagang.Harga_Hpp',
                    'k_hargadagang.Harga_Jual',
                    'k_hargadagang.Tgl_Awal'
                    );

                $datatables['col-search'] = array(
                    'mstr.Nama',
                    'mstr.Nama_Dagangan'
                    );        
                /**
                * menggunakan table join
                */
                $datatables['join']    = 'inner join (SELECT k_supplier.Nama, k_dagangan.Nama_Dagangan, k_dagangan.ID_Dagang FROM k_dagangan inner join k_supplier on k_dagangan.ID_Supp = k_supplier.ID_Supp) mstr ON mstr.ID_Dagang = k_hargadagang.ID_Dagang';
                $this->M_hargadagang->Datatables($datatables);
            }
            return;
        }

    }