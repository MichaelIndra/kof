<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class dagangan extends CI_Controller
	{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('M_login');
            $this->load->model('M_dagangan');
            $this->load->model('M_supplier');
        }

        function index(){
            if ($this->M_login->logged_id()){
                $data = array(
                    'title'     => 'Kantin KOF',
                    'judul'     => 'Data Dagangan Kantin KOF',
                    'supplier'  => $this->M_supplier->getSupplier()
                );
                $this->load->view('header', $data);
                $this->load->view('dashboard_kantin');
                $this->load->view('dagangan', $data);
                $this->load->view('footer', $data);
            }else{
                redirect("login");
            }
        }

        function editDagangan(){
            $id = $this->input->post('idDagang');
            $this->M_dagangan->getDaganganbyId($id);
            
        }
        function doInputDagangan(){
            $pok = ($this->input->post('cekpok')) == 1 ? 'T' : 'F';
            $idsupp = strtoupper($this->input->post('idsupp'));
            $ID_Dagang = $idsupp.'.'.str_replace(" ", "", $this->input->post('namadagangan'));
            
            $datamaster = array(
                'ID_Supp'       => $idsupp,         
                'ID_Dagang'     => strtoupper($ID_Dagang),
                'Nama_Dagangan' => strtoupper($this->input->post('namadagangan')),
                'Keterangan'    => strtoupper($this->input->post('keterangan')),
                'Pok'   => $pok                
            );
            $res = $this->M_dagangan->saveMaster($datamaster);
            
            $result = array('res'=>$res);
            echo json_encode($result);
        }
        
        function doEditDagangan(){
            $pok = ($this->input->post('cekpok')) == 1 ? 'T' : 'F';
            $datamaster = array(
                'Nama_Dagangan'=>strtoupper($this->input->post('namadagangan')),
                'Keterangan'=>strtoupper($this->input->post('keterangan')),
                'Pok'=>$pok
            );
            $id = $this->input->post('iddagang');
            $res = $this->M_dagangan->editMaster($datamaster, $id);
            
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
                $datatables['id-table'] = 'k_dagangan.ID_Dagang';
                
                /**
                 * Kolom yang ditampilkan
                 */
                $datatables['col-display'] = array(
                    'Nama',
                    'Nama_Dagangan',
                    'Keterangan',
                    'Pok'
                    );

                $datatables['col-join'] = array(
                    'k_supplier.Nama',
                    'k_dagangan.Nama_Dagangan',
                    'k_dagangan.Keterangan',
                    'k_dagangan.Pok'
                    );

                $datatables['col-search'] = array(
                    'k_supplier.Nama',
                    'k_dagangan.Nama_Dagangan',
                    'k_dagangan.Keterangan',
                    'k_Pok'
                    );        
                /**
                * menggunakan table join
                */
                $datatables['join']    = 'INNER JOIN k_supplier ON k_supplier.ID_Supp = k_dagangan.ID_Supp';
                $this->M_dagangan->Datatables($datatables);
            }
            return;
        }

    }