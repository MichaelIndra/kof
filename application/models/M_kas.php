<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class m_kas extends CI_Model{
        var $TABLE_NAME = 'cash_flow';
        var $TABLE_MASTER_CASH = 'master_keuangan';
        
        function saveKas($data)
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

        function getCashMaster(){
            $this->db->order_by('JenisTransaksi', 'asc');
            $this->db->order_by('NamaTransaksi', 'asc');
            $result = $this->db->get($this->TABLE_MASTER_CASH);
            if($result->result() > 0){
                foreach ($result->result() as $row){
                    $dd[$row->ID_Transaksi] = $row->NamaTransaksi;
                }
            }
            return $dd;
        }

        function Datatables($dt)
        {
            $columns = implode(', ', $dt['col-display']) . ', ' . $dt['id-table'];
            $columnsjoin = implode(', ', $dt['col-join']) . ', ' . $dt['id-table'];
            $join = $dt['join'];
             $sql  = "SELECT {$columnsjoin} FROM {$dt['table']} {$join}";
            // $sql  = "SELECT {$columns} FROM {$dt['table']} ";
            $data = $this->db->query($sql);
            $rowCount = $data->num_rows();
            $data->free_result();
            // pengkondisian aksi seperti next, search dan limit
            $columnd = $dt['col-display'];
            $count_c = count($columnd);
            // search
            $columndsearch = $dt['col-search'];
            $count_search = count($columndsearch);
            // search
            $search = $dt['search']['value'];
            /**
             * Search Global
             * pencarian global pada pojok kanan atas
             */
            $where = '';
            if ($search != '') {   
                for ($i=0; $i < $count_search ; $i++) {
                    $where .= $columndsearch[$i] .' LIKE "%'. $search .'%"';
                    
                    if ($i < $count_search - 1) {
                        $where .= ' OR ';
                    }
                }
            }
            
            /**
             * Search Individual Kolom
             * pencarian dibawah kolom
             */
            for ($i=0; $i < $count_c; $i++) { 
                $searchCol = $dt['columns'][$i]['search']['value'];
                if ($searchCol != '') {
                    $where = $columnd[$i] . ' LIKE "%' . $searchCol . '%" ';
                    break;
                }
            }
            /**
             * pengecekan Form pencarian
             * pencarian aktif jika ada karakter masuk pada kolom pencarian.
             */
            if ($where != '') {
                $sql .= " WHERE " . $where;
                
            }
            
            // sorting
            $sql .= " ORDER BY {$columnd[$dt['order'][0]['column']]} {$dt['order'][0]['dir']}";
            
            // limit
            $start  = $dt['start'];
            $length = $dt['length'];
            $sql .= " LIMIT {$start}, {$length}";
            
            $list = $this->db->query($sql);
            /**
             * convert to json
             */
            $option['draw']            = $dt['draw'];
            $option['recordsTotal']    = $rowCount;
            $option['recordsFiltered'] = $rowCount;
            $option['data']            = array();
            foreach ($list->result() as $row) {
            /**
             * custom gunakan
             * $option['data'][] = array(
             *                       $row->columnd[0],
             *                       $row->columnd[1],
             *                       $row->columnd[2],
             *                       $row->columnd[3],
             *                       $row->columnd[4],
             *                       .....
             *                     );
             */

            $option['data'][] = array(
                $row->ID_Transaksi,
                $row->Nama,
                $row->Jumlah,
                $row->TanggalTransaksi,
                $row->TanggalInput,
                $row->Keterangan,
                $row->JenisTransaksi
            );
            
            // $rows = array();
            // for ($i=0; $i < $count_c; $i++) { 
            //     $rows[] = $row->ID_Anggota;
            // }
            // $rows[] = "<button class='btn btn-sm btn-primary' onclick=edit_jemaat('". $row->ID_Anggota ."')><i class='glyphicon glyphicon-pencil'></i></button>";
            // $option['data'][] = $rows;
            }
            // eksekusi json
            echo json_encode($option);
        }

    }