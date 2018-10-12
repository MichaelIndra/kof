<?php
     if (!defined('BASEPATH'))
     exit('No direct script access allowed');
     
     class m_komsel extends CI_Model{
        var $TABLE_NAME = 'komsel';
        
        function getKomsel(){
            $this->db->order_by($this->TABLE_NAME, 'asc');
            $result = $this->db->get($this->TABLE_NAME);
            if($result->result() > 0){
                foreach ($result->result() as $row){
                    $dd[$row->no] = $row->Komsel;
                }
            }
            return $dd;
        }

    }