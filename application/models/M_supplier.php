<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class m_supplier extends CI_Model{
        var $TABLE_NAME = 'k_supplier';

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

        function editMaster($dt, $id){
            $this->db->where('ID_Supp',$id);
            if (!$this->db->update($this->TABLE_NAME,$dt)){
                $res = 0;
            }else
            {
                $res = $this->db->affected_rows();
            }
            return $res;
        }

        function getSupplierbyId($id, $dt){
            $columnd = $dt['col-display'];
            $count_c = count($columnd);
            $sql = "SELECT * FROM $this->TABLE_NAME WHERE ID_Supp ='$id'";
            $list = $this->db->query($sql);
            foreach ($list->result() as $row) {
                $rows = array();
                // for ($i=0; $i < $count_c; $i++) { 
                //     $rows[$columnd[$i]] = $row->$columnd[$i];
                // }
                $rows['Nama'] = $row->Nama;
                $rows['Alamat'] = $row->Alamat;
                $rows['No_Telp'] = $row->No_Telp;
                $rows['No_WA'] = $row->No_WA;
                

                $option= $rows;
            }
            
            echo json_encode($option);
        }

        function Datatables($dt)
        {
            $columns = implode(', ', $dt['col-display']) . ', ' . $dt['id-table'];
            // $columnsjoin = implode(', ', $dt['col-join']) . ', ' . $dt['id-table'];
            // $join = $dt['join'];
            //  $sql  = "SELECT {$columnsjoin} FROM {$dt['table']} {$join}";
            $sql  = "SELECT {$columns} FROM {$this->TABLE_NAME} ";
            $data = $this->db->query($sql);
            $rowCount = $data->num_rows();
            $data->free_result();
            // pengkondisian aksi seperti next, search dan limit
            $columnd = $dt['col-display'];
            $count_c = count($columnd);
            // search
            // $columndsearch = $dt['col-search'];
            // $count_search = count($columndsearch);
            // search
            $search = $dt['search']['value'];
            /**
             * Search Global
             * pencarian global pada pojok kanan atas
             */
            $where = '';
            if ($search != '') {   
                for ($i=0; $i < $count_c ; $i++) {
                    $where .= $columnd[$i] .' LIKE "%'. $search .'%"';
                    
                    if ($i < $count_search - 1) {
                        $where .= ' OR ';
                    }
                }
            }
            // $coljoinsearch = $dt['col-join'];
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
                $row->Nama,
                $row->Alamat,
                $row->No_Telp,
                $row->No_WA,
                "<button class='btn btn-sm btn-primary' onclick=edit_supplier('". $row->ID_Supp ."')><i class='glyphicon glyphicon-pencil'></i></button>"                           
            );
            $option ['sql'] = $sql;
            
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