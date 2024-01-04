<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelAdmin extends CI_Model
{
    public function get_data_transaksi($table,$limit,$start,$keyword = null){
        if ($keyword) {
            $this->db->like('id_sewa',$keyword);
            $this->db->or_like('nama_pemesan',$keyword);
            $this->db->or_like('kode_sewa',$keyword);
            $this->db->or_like('email',$keyword);
            $this->db->or_like('tanggal',$keyword);
            $this->db->or_like('lapangan',$keyword);
            $this->db->or_like('jam_main',$keyword);
            $this->db->or_like('status',$keyword);
        }
		return $this->db->get($table,$limit,$start);
	}

    public function get_data_lapangan($table,$limit,$start,$keyword = null){
        if ($keyword) {
            $this->db->like('nama_pemesan',$keyword);
            $this->db->or_like('kode_sewa',$keyword);
            $this->db->or_like('email',$keyword);
            $this->db->or_like('tanggal',$keyword);
            $this->db->or_like('jam_main',$keyword);
            $this->db->or_like('status',$keyword);
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
		$this->db->where($where);
		$this->db->update($table,$data);
	}

    public function delete_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}

    public function validasiTanggal($where,$table){
        $this->db->select('tanggal');
        $this->db->from($table);
        $this->db->where($where);
        return $this->db->get();
    }

    public function validasiJamMain($where,$table){
		$this->db->select('jam_main');
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get();
	}

    public function validasiJamSelesai($where,$table){
		$this->db->select('selesai');
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get();
	}

    public function insert_transaksi($data_transaksi,$table){
		$this->db->insert($table,$data_transaksi);
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