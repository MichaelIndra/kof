<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class M_counter extends CI_Model{
        var $TABLE_NAME = 'counter';
        

        function getCounter(){
            $counter = 0;
            $result = $this->db->get($this->TABLE_NAME);
            if($result->result() > 0){
                foreach ($result->result() as $row){
                    $counter = $row->no;
                }
            }
            return $counter;
        }

        function updateCounter(){
            $this->db->set('no','no+1', FALSE);
            $this->db->set('tanggal',date('Y-m-d'));
            $this->db->where('id','a');
            $this->db->update($this->TABLE_NAME);
        } 

    }