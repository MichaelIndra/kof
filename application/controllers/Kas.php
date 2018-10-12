<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class Kas extends CI_Controller{
        function __construct()
        {
            parent::__construct();
            //load model admin
            $this->load->model('M_login');
            $this->load->model('M_kas');
            $this->load->model('M_counter');
        }

        function index(){
            if ($this->M_login->logged_id()){
                $data = array(
                    'title' => 'Kas KOF',
                    'judul' => 'Data Kas KOF',
                    'masterkas' =>$this->M_kas->getCashMaster()                    
                );
                $this->load->view('header', $data);
                $this->load->view('dashboard_detail');
                $this->load->view('kas', $data);
                $this->load->view('footer', $data);
            }else{
                redirect("login");
            }
        }
        
        function saveKas(){
            $tanggalskg = date('Ymd');
            $uang =  str_replace(".", "", $this->input->post('Jumlah'));
            $counter =$this->M_counter->getCounter();
            //001/tanggaltransaksi
            $ID_Transaksi = $counter.'/'.$tanggalskg;
            $datamaster = array(
                'ID_Transaksi'      => $ID_Transaksi,
                'ID_Anggota'        => $this->session->userdata("id_anggota"),
                'Jumlah'            => $uang,
                'TanggalTransaksi'  => $this->input->post('TanggalTransaksi'),
                'TanggalInput'      => $tanggalskg,
                'Keterangan'        => $this->input->post('Keterangan'),
                'KodeCashFlow'      => $this->input->post('KodeCashFlow')
            );
            $res = $this->M_kas->saveKas($datamaster);
            $this->M_counter->updateCounter($data);

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
                $datatables['table']    = 'cash_flow';
                $datatables['id-table'] = 'cash_flow.ID_Transaksi';
                
                /**
                 * Kolom yang ditampilkan
                 */
                $datatables['col-join'] = array(
                            'cash_flow.ID_Transaksi',
                            'anggota.Nama',
                            'cash_flow.Jumlah',
                            'cash_flow.TanggalTransaksi',
                            'cash_flow.TanggalInput',
                            'cash_flow.Keterangan',
                            'master_keuangan.JenisTransaksi'
                            );
                $datatables['col-search'] = array(
                    'cash_flow.ID_Transaksi',
                    'anggota.Nama',
                    'cash_flow.Jumlah',
                    'cash_flow.TanggalTransaksi',
                    'cash_flow.TanggalInput',
                    'cash_flow.Keterangan',
                    'master_keuangan.JenisTransaksi'
                    );            
                $datatables['col-display'] = array(
                    'ID_Transaksi',
                    'Nama',
                    'Jumlah',
                    'TanggalTransaksi',
                    'TanggalInput',
                    'Keterangan',
                    'JenisTransaksi'
                    );
                /**
                * menggunakan table join
                */
                $datatables['join']    = 'INNER JOIN anggota ON anggota.ID_Anggota = cash_flow.ID_Anggota 
                                        INNER JOIN master_keuangan ON master_keuangan.ID_Transaksi = cash_flow.KodeCashFlow';
                $this->M_kas->Datatables($datatables);
            }
            return;
        }




    }