<?php
    class m_absensi extends CI_Model{
        var $TABLE_NAME = 'absensi';
        
        function saveAbsensi($data)
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