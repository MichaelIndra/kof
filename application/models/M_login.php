<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model
{
    var $TABLE_NAME = 'anggota';
    //fungsi cek session
    function logged_id()
    {
        return $this->session->userdata('id_anggota');
    }

    //fungsi check login
    function check_login($field1, $field2)
    {
        $this->db->select('*');
        $this->db->from($this->TABLE_NAME);
        $this->db->where($field1);
        $this->db->where($field2);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }
}