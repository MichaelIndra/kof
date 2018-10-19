<?php
    // Status ada 4
    // IN  -> inputan pertama
    // RB  -> Rekap per item barang
    // RS  -> Rekap Supplier (supplier ambil)
    // RK  -> Rekap kantin (rekap semua) 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class m_transaksi extends CI_Model{
        var $TABLE_NAME = 'k_transaksi';

        function saveMaster($data)
        {
            if(!$this->db->insert($this->TABLE_NAME, $data) )
            {
                $res = 0;
            }else
            {
                $res = $this->db->affected_rows();
            }
            return $res;
            
        }
        
    }