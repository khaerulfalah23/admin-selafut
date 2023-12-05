<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelAdmin extends CI_Model
{
    public function get_data($table,$limit,$start,$keyword = null,$match){
        if ($keyword) {
            $this->db->like($match[0],$keyword);
            $this->db->or_like($match[1],$keyword);
            $this->db->or_like($match[2],$keyword);
        }
		return $this->db->get($table,$limit,$start);
	}

    public function get_data_where($where,$table)
    {
        return $this->db->get_where($table,$where);
    }

    public function insert_data($data,$table){
		$this->db->insert($table,$data);
	}

    public function update_data($where,$data,$table){
		$this->db->WHERE($where);
		$this->db->UPDATE($table,$data);
	}

    public function delete_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}

    public function cekData($where = null)
    {
        return $this->db->get_where('admin', $where);
    }

    public function getData($table)
    {
        return $this->db->get($table);
    }
}