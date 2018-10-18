<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class m_hargadagang extends CI_Model{
        var $TABLE_NAME = 'k_hargadagang';

        function gettglakhir($iddagang)
        {
            $this->db->where('ID_Dagang', $iddagang);
            $this->db->where('Tgl_Akhir is NULL', null, false);
            $data = $this->db->get($this->TABLE_NAME)->row_array();
            $res = $this->db->affected_rows().','.$data['Tgl_Awal'];
            return $res;
        }

        function isitglakhir($iddagang, $tglakhir){
            $this->db->where('ID_Dagang', $iddagang);
            $this->db->where('Tgl_Akhir is NULL', null, false);
            $this->db->update($this->TABLE_NAME,array('Tgl_Akhir'=>$tglakhir));
        }

        function saveMaster($data)
        {
            $spliter = explode(',', $this->gettglakhir($data['ID_Dagang']));
            if ($spliter[0] == 1)
            {
                //aktif
                $dateawal  = new DateTime($spliter[1]);
                $dateakhir = new DateTime($data['Tgl_Awal']);
                $dateakhir->modify('-1 day');
                if($dateawal>$dateakhir)
                {
                    $result = 'Tanggal awal lebih besar dari tanggal akhir '.$dateawal->format('Y-m-d').' vs '.$dateakhir->format('Y-m-d');
                    
                }else{
                    $tglakhir = $dateakhir->format('Y-m-d');
                    $this->isitglakhir($data['ID_Dagang'], $tglakhir);
                    $this->db->insert($this->TABLE_NAME, $data);
                    $result = 'Data sebelumnya aktif sehingga dinonaktifkan otomatis';
                }
            }else
            {
                $this->db->insert($this->TABLE_NAME, $data);
                $result = 'Berhasil input data baru';
                //ga ada
            }

            return $result;
            
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
            $whereTgl = ' (k_hargadagang.Tgl_Akhir is null) ';
            if ($where != '') {
                $sql .= " WHERE (" . $where." )";
                $sql .= ' AND '.$whereTgl;
            }else {
                $sql .= " WHERE " . $whereTgl;
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
            $move = 0;
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
                    $row->Harga_Hpp,
                    $row->Harga_Jual,
                    $row->Tgl_Awal,
                    '<button class="btn btn-sm btn-danger" onclick="nonaktif(\''. $row->no .'\',\''.$move.'\')"><i class="glyphicon glyphicon-remove"></i></button>'                           
                );
                
                $move++;
            }
            // eksekusi json
            echo json_encode($option);
        }

        
    }