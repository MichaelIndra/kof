<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class transaksi extends CI_Controller
	{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('M_login');
            $this->load->model('M_transaksi');
            $this->load->model('M_hargadagang');
        }

        function index(){
            if ($this->M_login->logged_id()){
                $data = array(
                    'title'     => 'Transaksi Kantin',
                    'judul'     => 'Transaksi kantin KOG Young Pro'
                );
                $this->load->view('header', $data);
                $this->load->view('dashboard_kantin');
                $this->load->view('transaksi', $data);
                $this->load->view('footer', $data);
            }else{
                redirect("login");
            }
        }

        function search()
        {
            $datatables['col-join'] = array(
                'mstr.Nama',
                'mstr.Nama_Dagangan',
                'k_hargadagang.Harga_Hpp',
                'k_hargadagang.Harga_Jual',
                'k_hargadagang.ID_Dagang'
            );
            $datatables['join']    = 'inner join (SELECT k_supplier.Nama, k_dagangan.Nama_Dagangan, k_dagangan.ID_Dagang FROM k_dagangan inner join k_supplier on k_dagangan.ID_Supp = k_supplier.ID_Supp) mstr ON mstr.ID_Dagang = k_hargadagang.ID_Dagang';
            $res = $this->M_hargadagang->getDagangan($datatables);
            if($res->num_rows()>0){
                foreach ($res->result_array() as $row)
                {
                    $rowset[]=$row;
                }
                echo json_encode($rowset);
            }
        }

        function saveStok(){
            $datamaster = array(
                'Stok_Awal'     => $this->input->post('Stok_Awal'),
                'Tanggal_Stok'  => $this->input->post('Tanggal_Stok'),
                'ID_Dagang'     => $this->input->post('ID_Dagang'),
                'Status'        => 'IN'            
            );
            $res = $this->M_transaksi->saveMaster($datamaster);
            echo json_encode(array('res'=>$res));
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
                    'Stok_Awal',
                    'Stok_Sisa',
                    'Stok_Akhir',
                    'Pok',
                    'Harga_Hpp',
                    'Harga_Jual',
                    ''
                    );

                $datatables['col-join'] = array(
                    'mstr.Nama',
                    'mstr.Nama_Dagangan',
                    'k_hargadagang.Harga_Hpp',
                    'k_hargadagang.Harga_Jual',
                    'k_hargadagang.ID_Dagang'
                );

                $datatables['col-search'] = array(
                    'mstr.Nama',
                    'mstr.Nama_Dagangan'
                    );        
                /**
                * menggunakan table join
                */
//                 SELECT mstr_brg.Nama, mstr_brg.Nama_Dagangan, k_transaksi.Stok_Awal, k_transaksi.Stok_Sisa, k_transaksi.Stok_Akhir, (mstr_brg.Harga_Hpp * k_transaksi.Stok_awal) Total_Hpp, (mstr_brg.Harga_Jual * k_transaksi.Stok_awal) Total_Jual
//                  FROM k_transaksi inner join mstr_brg on mstr_brg.ID_Dagang = k_transaksi.ID_Dagang
                $datatables['join']    = 'inner join (SELECT k_supplier.Nama, k_dagangan.Nama_Dagangan, k_dagangan.ID_Dagang FROM k_dagangan inner join k_supplier on k_dagangan.ID_Supp = k_supplier.ID_Supp) mstr ON mstr.ID_Dagang = k_hargadagang.ID_Dagang';
                $this->M_hargadagang->Datatables($datatables);
            }
            return;
        }




    }