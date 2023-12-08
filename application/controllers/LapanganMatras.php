<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LapanganMatras extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        cek_login();
    }

    public function create()
    {
        $data['judul'] = 'Lapangan Matras';
        $data['usersesion'] = $this->ModelAdmin->cekData(['email' => $this->session->userdata('email')])->row_array();
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', [
            'required' => 'Nama Harus diisi!!',
        ]);
        $this->form_validation->set_rules('email', 'Alamat Email', 'required|trim|valid_email', [
            'required' => 'Email Harus diisi!!',
            'valid_email' => 'Email Tidak Benar!!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin_header',$data);
            $this->load->view('templates/admin_sidebar');
            $this->load->view('templates/admin_topbar');
            $this->load->view('LapanganMatras/tambah');
            $this->load->view('templates/admin_footer');
        } else {
            $nama = htmlspecialchars($this->input->post('nama', true));
            $email = htmlspecialchars($this->input->post('email', true));
            $tanggal = htmlspecialchars($this->input->post('tanggal', true));
            $jam_main = htmlspecialchars($this->input->post('jam_main', true));
            $selesai = htmlspecialchars($this->input->post('selesai', true));
            $lama_main = $selesai - $jam_main;
            $harga_sewa = $lama_main*30000;
            $kode_sewa = time();
            
            $data = [
                'kode_sewa' => $kode_sewa,
                'nama_pemesan' => $nama,
                'email' => $email,
                'tanggal' => $tanggal,
                'jam_main' => $jam_main,
                'selesai' => $selesai,
                'lama_main' => $lama_main,
                'status' => 'Proses'
            ];

            $data_transaksi=[
				'nama_pemesan' => $nama,
				'lapangan' => 'Matras',
				'email' => $email,
				'tanggal' => $tanggal,
				'jam_main' => $jam_main,
				'selesai' => $selesai,
				'lama_main' => $lama_main,
				'harga_sewa' => $harga_sewa,
				'status' => 'Proses',
				'kode_sewa' => $kode_sewa
			];

            $whereTanggal = ['tanggal' => $tanggal];
            $whereJamMain = ['jam_main' => $jam_main];
            $whereJamSelasai = ['selesai' => $selesai];

            $validasiTanggal = $this->ModelAdmin->validasiTanggal($whereTanggal,'lapangan_matras')->num_rows();
            $validasiJamMain = $this->ModelAdmin->validasiJamMain($whereJamMain,'lapangan_matras')->num_rows();
            $validasiJamSelesai = $this->ModelAdmin->validasiJamSelesai($whereJamSelasai,'lapangan_matras')->num_rows();

            if ($data['lama_main'] > 0) {
                if ($validasiTanggal > 0) {
                    if ($validasiJamMain || $validasiJamSelesai > 0) {
                        $this->session->set_flashdata('pesan','Silahkan lihat jadwal terlebih dahulu sebelum memesan!');
                        redirect('LapanganMatras/create');
                    } else {
                        $this->session->set_flashdata('flash','Ditambahkan');
                        $this->ModelAdmin->insert_transaksi($data_transaksi,'transaksi');
                        $this->ModelAdmin->insert_data($data,'lapangan_matras');
                        redirect('LapanganMatras/read');
                    }
                } else {
                    $this->session->set_flashdata('flash','Ditambahkan');
                    $this->ModelAdmin->insert_transaksi($data_transaksi,'transaksi');
                    $this->ModelAdmin->insert_data($data,'lapangan_matras');
                    redirect('LapanganMatras/read');
                }
            } else {
                $this->session->set_flashdata('jam','Waktu yang anda masukan salah!');
                redirect('LapanganMatras/create');
            }
        }
    }

    public function read()
    {
        // Ambil data keyword
        if($this->input->post('keyword')) {
            $data['keyword'] = $this->input->post('keyword');
        }else{
            $data['keyword'] = null;
        }

        // config
        $this->db->like('nama_pemesan',$data['keyword']);
        $this->db->or_like('kode_sewa',$data['keyword']);
        $this->db->or_like('email',$data['keyword']);
        $this->db->or_like('tanggal',$data['keyword']);
        $this->db->or_like('jam_main',$data['keyword']);
        $this->db->from('lapangan_matras');
        $config['base_url'] = 'http://localhost/admin-selafut/LapanganMatras/read';
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 5;

        // initialize
        $this->pagination->initialize($config);

        $data['judul'] = 'Lapangan Matras';
        $data['start'] = $this->uri->segment(3);
        $data['lapangan'] = $this->ModelAdmin->get_data('lapangan_matras',$config['per_page'],$data['start'],$data['keyword'])->result_array();
        $data['usersesion'] = $this->ModelAdmin->cekData(['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/admin_header',$data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar');
        $this->load->view('LapanganMatras/data');
        $this->load->view('templates/admin_footer');
	}

    public function update($kode)
    {
        $where = ['kode_sewa' => $kode];
        $data['judul'] = 'Lapangan Matras';
        $data['lapangan'] = $this->ModelAdmin->get_data_where($where,'lapangan_matras')->row_array();
        $data['usersesion'] = $this->ModelAdmin->cekData(['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', [
            'required' => 'Nama Harus diisi!!',
        ]);
        $this->form_validation->set_rules('email', 'Alamat Email', 'required|trim|valid_email', [
            'required' => 'Email Harus diisi!!',
            'valid_email' => 'Email Tidak Benar!!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin_header',$data);
            $this->load->view('templates/admin_sidebar');
            $this->load->view('templates/admin_topbar');
            $this->load->view('LapanganMatras/ubah');
            $this->load->view('templates/admin_footer');
        } else {
            $nama = htmlspecialchars($this->input->post('nama', true));
            $email = htmlspecialchars($this->input->post('email', true));
            $tanggal = htmlspecialchars($this->input->post('tanggal', true));
            $jam_main = htmlspecialchars($this->input->post('jam_main', true));
            $selesai = htmlspecialchars($this->input->post('selesai', true));
            $lama_main = $selesai - $jam_main;
            $harga_sewa = $lama_main*30000;
            
            $data = [
                'nama_pemesan' => $nama,
                'email' => $email,
                'tanggal' => $tanggal,
                'jam_main' => $jam_main,
                'selesai' => $selesai,
                'lama_main' => $lama_main,
                'status' => 'Proses'
            ];

            $data_transaksi=[
				'nama_pemesan' => $nama,
				'lapangan' => 'Matras',
				'email' => $email,
				'tanggal' => $tanggal,
				'jam_main' => $jam_main,
				'selesai' => $selesai,
				'lama_main' => $lama_main,
				'harga_sewa' => $harga_sewa,
				'status' => 'Proses'
			];

            $whereTanggal = ['tanggal' => $tanggal];
            $whereJamMain = ['jam_main' => $jam_main];
            $whereJamSelasai = ['selesai' => $selesai];
            $validasiTanggal = $this->ModelAdmin->validasiTanggal($whereTanggal,'lapangan_matras')->num_rows();
            $validasiJamMain = $this->ModelAdmin->validasiJamMain($whereJamMain,'lapangan_matras')->num_rows();
            $validasiJamSelesai = $this->ModelAdmin->validasiJamSelesai($whereJamSelasai,'lapangan_matras')->num_rows();
            $dataLapangan['lapangan'] = $this->ModelAdmin->get_data_where($where,'lapangan_matras')->row_array();

            if($tanggal == $dataLapangan['lapangan']['tanggal'] && $jam_main == $dataLapangan['lapangan']['jam_main'] && $selesai == $dataLapangan['lapangan']['selesai']) {
                $this->ModelAdmin->update_data($where,$data,'lapangan_matras');
                $this->ModelAdmin->update_data($where,$data_transaksi,'transaksi');
                $this->session->set_flashdata('flash','Diubah');
                redirect('LapanganMatras/read');
            }

            if ($data['lama_main'] > 0) {
                if ($validasiTanggal > 0) {
                    if ($validasiJamMain || $validasiJamSelesai > 0) {
                        $this->session->set_flashdata('pesan','Silahkan lihat jadwal terlebih dahulu sebelum melakukan update data!');
                        redirect('LapanganMatras/update/'.$kode);
                    } else {
                        $this->ModelAdmin->update_data($where,$data,'lapangan_matras');
                        $this->ModelAdmin->update_data($where,$data_transaksi,'transaksi');
                        $this->session->set_flashdata('flash','Diubah');
                        redirect('LapanganMatras/read');
                    }
                } else {
                    $this->ModelAdmin->update_data($where,$data,'lapangan_matras');
                    $this->ModelAdmin->update_data($where,$data_transaksi,'transaksi');
                    $this->session->set_flashdata('flash','Diubah');
                    redirect('LapanganMatras/read');
                }
            } else {
                $this->session->set_flashdata('jam','Waktu yang anda masukan salah!');
                redirect('LapanganMatras/update/'.$kode);
            }
        }
    }

    public function delete($kode)
    {
		$where = ['kode_sewa' => $kode];
		$this->ModelAdmin->delete_data($where,'lapangan_matras');
		$this->ModelAdmin->delete_data($where,'transaksi');
        $this->session->set_flashdata('flash','Dihapus');
		redirect('LapanganMatras/read');
	}
}