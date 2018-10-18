<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class supplier extends CI_Controller
	{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('M_login');
            $this->load->model('M_supplier');
        }

        function index(){
            if ($this->M_login->logged_id()){
                $data = array(
                    'title' => 'Kantin KOF',
                    'judul' => 'Data Supplier Kantin KOF'                    
                );
                $this->load->view('header', $data);
                $this->load->view('dashboard_kantin');
                $this->load->view('supplier', $data);
                $this->load->view('footer', $data);
            }else{
                redirect("login");
            }
        }

        function editSupplier(){
            $id = $this->input->post('idSupp');
            $datatables['col-display'] = array(
                'Nama',
                'Alamat',
                'No_Telp',
                'No_WA'
            );
            $this->M_supplier->getSupplierbyId($id, $datatables);
            
        }
        function doInputJemaat(){

            $namaSupp = strtoupper($this->input->post('namasupp'));
            $idsupp = str_replace(' ', '', $namaSupp);
            $datamaster = array(
                'ID_Supp'=>$idsupp,         
                'Nama'=>$namaSupp,
                'Alamat'=>strtoupper($this->input->post('alamat')),
                'No_Telp'=>strtoupper($this->input->post('notelp')),
                'No_WA'=>strtoupper($this->input->post('nowa'))                
            );
            $res = $this->M_supplier->saveMaster($datamaster);
            
            $result = array('res'=>$res);
            echo json_encode($result);
        }
        
        function doEditSupplier(){
            $datamaster = array(
                'Nama'=>strtoupper($this->input->post('nama')),
                'Alamat'=>strtoupper($this->input->post('alamat')),
                'No_Telp'=>strtoupper($this->input->post('notelp')),
                'No_WA'=>strtoupper($this->input->post('nowa'))                
            );
            $id = $this->input->post('idsupp');
            $res = $this->M_supplier->editMaster($datamaster, $id);
            
            $result = array('res'=>$res);
            echo json_encode($result);            
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
                $datatables['id-table'] = 'ID_Supp';
                
                /**
                 * Kolom yang ditampilkan
                 */
                $datatables['col-display'] = array(
                    'Nama',
                    'Alamat',
                    'No_Telp',
                    'No_WA'
                    );
                /**
                * menggunakan table join
                */
                // $datatables['join']    = 'INNER JOIN komsel ON komsel.no = anggota.Komsel';
                $this->M_supplier->Datatables($datatables);
            }
            return;
        }

    }