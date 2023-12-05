<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelUser extends CI_Model
{
    public function get_data($table,$limit,$start,$keyword = null){
        if ($keyword) {
            $this->db->like('id',$keyword);
            $this->db->or_like('nama',$keyword);
            $this->db->or_like('email',$keyword);
        }
		return $this->db->get($table,$limit,$start);
	}

    public function simpanData($data = null)
    {
        $this->db->insert('user', $data);
    }

    public function getUserWhere($where) 
    {
        return $this->db->get_where('user',$where);
    }

    public function cekData($where = null)
    {
        return $this->db->get_where('user', $where);
    }
}
