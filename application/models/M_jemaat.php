<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class m_jemaat extends CI_Model{
        var $TABLE_NAME = 'anggota';
    
        function getAllJemaat($dt)
        {
            $columnd = $dt['col-display'];
            $count_c = count($columnd);
            $supp = $this->db->get('anggota');
            foreach ($supp->result() as $row) {
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
                $rows = array();
                for ($i=0; $i < $count_c; $i++) { 
                    $rows[] = $row->$columnd[$i];
                }
                $option['data'][] = $rows;
                }


                echo json_encode($option);
        }

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

        function getJemaatbyId($id, $dt){
            $columnd = $dt['col-display'];
            $count_c = count($columnd);
            $sql = "SELECT * FROM $this->TABLE_NAME WHERE ID_ANGGOTA ='$id'";
            $list = $this->db->query($sql);
            foreach ($list->result() as $row) {
                $rows = array();
                // for ($i=0; $i < $count_c; $i++) { 
                //     $rows[$columnd[$i]] = $row->$columnd[$i];
                // }
                $rows['Nama'] = $row->Nama;
                $rows['Nama_Panggilan'] = $row->Nama_Panggilan;
                $rows['Komsel'] = $row->Komsel;
                $rows['Alamat'] = $row->Alamat;
                $rows['JenisKelamin'] = $row->JenisKelamin;
                $rows['No_HP'] = $row->No_HP;
                $rows['No_WA'] = $row->No_WA;
                $rows['TGL_Lahir'] = $row->TGL_Lahir;
                $rows['Email'] = $row->Email;


                $option= $rows;
            }
            
            echo json_encode($option);
        }

        function updateJemaat($data){
            $this->db->set('Nama',$data['Nama']);
            $this->db->set('Nama_Panggilan',$data['Nama_Panggilan']);
            $this->db->set('Komsel',$data['Komsel']);
            $this->db->set('Alamat',$data['Alamat']);
            $this->db->set('JenisKelamin',$data['JenisKelamin']);
            $this->db->set('No_HP',$data['No_HP']);
            $this->db->set('No_WA',$data['No_WA']);
            $this->db->set('TGL_Lahir',$data['TGL_Lahir']);
            $this->db->set('Email',$data['Email']);
            
            $this->db->where('ID_Anggota',$data['ID_Anggota']);
            $this->db->update($this->TABLE_NAME);
        }

        function Datatablescoba($dt){
            $columns = implode(', ', $dt['col-display']) . ', ' . $dt['id-table'];
            $columnsjoin = implode(', ', $dt['col-join']) . ', ' . $dt['id-table'];
            $join = $dt['join'];
            // echo $columns;
            // $sql  = "SELECT ".$columns." FROM {$dt['table']} {$join}";
            $sql  = "SELECT {$columnsjoin} FROM {$dt['table']} {$join}";
           
        //    $sql = 'SELECT b1.Nama, b2.Komsel, b1.Alamat FROM anggota as b1 INNER JOIN komsel as b2 ON b1.Komsel = b2.no';
        //    $this->db->select('anggota.Nama,komsel.Komsel, anggota.Alamat');
        //    $this->db->from('anggota ');
        //    $this->db->join('komsel ','anggota.Komsel = komsel.no');
        //    $data = $this->db->get();
        //    print_r($data);
           $data = $this->db->query($sql);
           $rowCount = $data->num_rows();
        //    $data->free_result();
           $columnd = $dt['col-display'];
           $count_c = count($columnd);
           $list = $this->db->query($sql);
           /**
            * convert to json
            */
           foreach ($data->result() as $row) {
               
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
           $rows = array();
           for ($i=0; $i < $count_c; $i++) { 
               $rows[] = $row->$columnd[$i];
           }
        $option['data'][] = $rows;
        //    $option['data'][] = array(
        //        $row['Nama'],
        //        $row['Komsel'],
        //        $row['Alamat']
        //    );
           }
           // eksekusi json
           echo json_encode($option);

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
            $coljoinsearch = $dt['col-join'];
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
                $row->Nama_Panggilan,
                $row->Komsel,
                $row->Alamat,
                $row->JenisKelamin,
                $row->No_HP,
                $row->No_WA,
                $row->TGL_Lahir,
                $row->Email,
                "<button class='btn btn-sm btn-primary' onclick=edit_jemaat('". $row->ID_Anggota ."')><i class='glyphicon glyphicon-pencil'></i></button>"                           
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

        function Datatables_absensi($dt)
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
                $row->Nama,
                $row->Komsel,
                $row->Alamat,
                '<button class="btn btn-sm btn-primary" onclick="inputAbsen(\''. $row->ID_Anggota .'\',\''.$row->Nama.'\')">Absen</button>'
            );
                // $rows = array();
                // for ($i=0; $i < $count_c; $i++) { 
                //     $rows[] = $row->$columnd[$i];
                // }
                // $rows[] = '<button class="btn btn-sm btn-primary" onclick="inputAbsen(\''. $row->ID_Anggota .'\',\''.$row->Nama.'\')">Absen</button>';
                // $option['data'][] = $rows;
            }
            // eksekusi json
            echo json_encode($option);
        }


    }