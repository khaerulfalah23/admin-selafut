<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LapanganSintetis extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        cek_login();
    }

    public function create()
    {
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
            $this->load->view('form_lapangan_sintetis');
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
				'lapangan' => 'Sintetis',
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

            $validasiTanggal = $this->ModelAdmin->validasiTanggal($whereTanggal,'lapangan_sintetis')->num_rows();
            $validasiJamMain = $this->ModelAdmin->validasiJamMain($whereJamMain,'lapangan_sintetis')->num_rows();
            $validasiJamSelesai = $this->ModelAdmin->validasiJamSelesai($whereJamSelasai,'lapangan_sintetis')->num_rows();

            if ($data['lama_main'] > 0) {
                if ($validasiTanggal > 0) {
                    if ($validasiJamMain || $validasiJamSelesai > 0) {
                        $this->session->set_flashdata('pesan','Silahkan lihat jadwal terlebih dahulu sebelum memesan!');
                        redirect('LapanganSintetis/create');
                    } else {
                        $this->session->set_flashdata('flash','Ditambahkan');
                        $this->ModelAdmin->insert_transaksi($data_transaksi,'transaksi');
                        $this->ModelAdmin->insert_data($data,'lapangan_sintetis');
                        redirect('LapanganSintetis/read');
                    }
                } else {
                    $this->session->set_flashdata('flash','Ditambahkan');
                    $this->ModelAdmin->insert_transaksi($data_transaksi,'transaksi');
                    $this->ModelAdmin->insert_data($data,'lapangan_sintetis');
                    redirect('LapanganSintetis/read');
                }
            } else {
                $this->session->set_flashdata('jam','Waktu yang anda masukan salah!');
                redirect('LapanganSintetis/create');
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
        $this->db->from('lapangan_sintetis');
        $config['base_url'] = 'http://localhost/admin-selafut/LapanganSintetis/read';
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 5;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['lapangan'] = $this->ModelAdmin->get_data('lapangan_sintetis',$config['per_page'],$data['start'],$data['keyword'])->result_array();
        $data['usersesion'] = $this->ModelAdmin->cekData(['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/admin_header',$data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar');
        $this->load->view('lapangan_sintetis');
        $this->load->view('templates/admin_footer');
	}

    public function update($kode)
    {
        $where = ['kode_sewa' => $kode];
        $data['lapangan'] = $this->ModelAdmin->get_data_where($where,'lapangan_sintetis')->row_array();
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
            $this->load->view('form_ubah_sintetis');
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
				'lapangan' => 'Sintetis',
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
            $validasiTanggal = $this->ModelAdmin->validasiTanggal($whereTanggal,'lapangan_sintetis')->num_rows();
            $validasiJamMain = $this->ModelAdmin->validasiJamMain($whereJamMain,'lapangan_sintetis')->num_rows();
            $validasiJamSelesai = $this->ModelAdmin->validasiJamSelesai($whereJamSelasai,'lapangan_sintetis')->num_rows();
            $dataLapangan['lapangan'] = $this->ModelAdmin->get_data_where($where,'lapangan_sintetis')->row_array();

            if($tanggal == $dataLapangan['lapangan']['tanggal'] && $jam_main == $dataLapangan['lapangan']['jam_main'] && $selesai == $dataLapangan['lapangan']['selesai']) {
                $this->ModelAdmin->update_data($where,$data,'lapangan_sintetis');
                $this->ModelAdmin->update_data($where,$data_transaksi,'transaksi');
                $this->session->set_flashdata('flash','Diubah');
                redirect('LapanganSintetis/read');
            }

            if ($data['lama_main'] > 0) {
                if ($validasiTanggal > 0) {
                    if ($validasiJamMain || $validasiJamSelesai > 0) {
                        $this->session->set_flashdata('pesan','Silahkan lihat jadwal terlebih dahulu sebelum melakukan update data!');
                        redirect('LapanganSintetis/update/'.$kode);
                    } else {
                        $this->ModelAdmin->update_data($where,$data,'lapangan_sintetis');
                        $this->ModelAdmin->update_data($where,$data_transaksi,'transaksi');
                        $this->session->set_flashdata('flash','Diubah');
                        redirect('LapanganSintetis/read');
                    }
                } else {
                    $this->ModelAdmin->update_data($where,$data,'lapangan_sintetis');
                    $this->ModelAdmin->update_data($where,$data_transaksi,'transaksi');
                    $this->session->set_flashdata('flash','Diubah');
                    redirect('LapanganSintetis/read');
                }
            } else {
                $this->session->set_flashdata('jam','Waktu yang anda masukan salah!');
                redirect('LapanganSintetis/update/'.$kode);
            }
        }
    }

    public function delete($kode)
    {
        $where = ['kode_sewa' => $kode];
        $this->ModelAdmin->delete_data($where,'lapangan_sintetis');
		$this->ModelAdmin->delete_data($where,'transaksi');
        $this->session->set_flashdata('flash','Dihapus');
        redirect('LapanganSintetis/read');
    }
}