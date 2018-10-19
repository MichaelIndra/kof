<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class m_dagangan extends CI_Model{
        var $TABLE_NAME = 'k_dagangan';
        var $TABLE_KEY  = 'ID_Dagang';

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
            $this->db->where('ID_Dagang',$id);
            if (!$this->db->update($this->TABLE_NAME,$dt)){
                $res = 0;
            }else
            {
                $res = $this->db->affected_rows();
            }
            return $res;
        }

        function getDaganganbyId($id){
            
            $sql = "SELECT k_supplier.Nama, k_dagangan.Nama_Dagangan, k_dagangan.Keterangan, k_dagangan.Pok, k_dagangan.ID_Dagang FROM $this->TABLE_NAME INNER JOIN k_supplier ON k_supplier.ID_Supp = k_dagangan.ID_Supp WHERE $this->TABLE_KEY ='$id'";
            $list = $this->db->query($sql);
            foreach ($list->result() as $row) {
                $rows = array();
                $rows['Nama'] = $row->Nama;
                $rows['Nama_Dagangan'] = $row->Nama_Dagangan;
                $rows['Keterangan'] = $row->Keterangan;
                $rows['Pok'] = $row->Pok;
                $option= $rows;
            }
            
            echo json_encode($option);
        }

        function getDaganganbyIdSupp(){
            $rows = '';
            $sql = "SELECT k_supplier.Nama, k_dagangan.Nama_Dagangan, k_dagangan.ID_Dagang FROM $this->TABLE_NAME INNER JOIN k_supplier ON k_supplier.ID_Supp = k_dagangan.ID_Supp ORDER BY k_supplier.Nama";
            $list = $this->db->query($sql);
            $count = $list->num_rows();
            
            foreach ($list->result() as $row) {
                 $rows[$row->ID_Dagang]     = $row->Nama_Dagangan.' - '.$row->Nama;             
                
            }   
            
            return $rows;
        }

        

        function Datatables($dt)
        {
            // $columns = implode(', ', $dt['col-display']) . ', ' . $dt['id-table'];
            $columnsjoin = implode(', ', $dt['col-join']) . ', ' . $dt['id-table'];
            $join = $dt['join'];
            $sql  = "SELECT {$columnsjoin} FROM {$this->TABLE_NAME} {$join}";
            // $sql  = "SELECT {$columns} FROM {$this->TABLE_NAME} ";
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
            // $coljoinsearch = $dt['col-join'];
            /**
             * Search Individual Kolom
             * pencarian dibawah kolom
             */
            for ($i=0; $i < $count_search; $i++) { 
                $searchCol = $dt['columns'][$i]['search']['value'];
                if ($searchCol != '') {
                    $where = $columndsearch[$i] . ' LIKE "%' . $searchCol . '%" ';
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
            $sql .= " ORDER BY {$columndsearch[$dt['order'][0]['column']]} {$dt['order'][0]['dir']}";
            
            // limit
            $start  = $dt['start'];
            $length = $dt['length'];
            $sql .= " LIMIT {$start}, {$length}";
            
            $list = $this->db->query($sql);
            /**
             * convert to json
             */
            $option ['sql'] = $sql;
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
                $row->Nama_Dagangan,
                $row->Keterangan,
                $row->Pok,
                "<button class='btn btn-sm btn-primary' onclick=edit_dagangan('". $row->ID_Dagang ."')><i class='glyphicon glyphicon-pencil'></i></button>
                <button class='btn btn-sm btn-danger' onclick=delete_dagangan('". $row->ID_Dagang ."')><i class='glyphicon glyphicon-remove'></i></button>"
                                           
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