<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        cek_login();
    }

    public function create()
    {
        $data['judul'] = 'Transaksi';
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
            $this->load->view('Transaksi/tambah');
            $this->load->view('templates/admin_footer');
        } else {
            $nama = htmlspecialchars($this->input->post('nama', true));
            $email = htmlspecialchars($this->input->post('email', true));
            $status = htmlspecialchars($this->input->post('status', true));
            $tanggal = htmlspecialchars($this->input->post('tanggal', true));
            $selesai = htmlspecialchars($this->input->post('selesai', true));
            $jam_main = htmlspecialchars($this->input->post('jam_main', true));
            $lapangan = htmlspecialchars($this->input->post('lapangan', true));
            $lama_main = $selesai - $jam_main;
            $harga_sewa = $lama_main*30000;
            $kode_sewa = time();
            
            $data_transaksi=[
                'nama_pemesan' => $nama,
                'lapangan' => $lapangan,
                'email' => $email,
                'tanggal' => $tanggal,
                'jam_main' => $jam_main,
                'selesai' => $selesai,
                'lama_main' => $lama_main,
                'harga_sewa' => $harga_sewa,
                'status' => $status,
                'kode_sewa' => $kode_sewa
            ];

            $data = [
                'kode_sewa' => $kode_sewa,
                'nama_pemesan' => $nama,
                'email' => $email,
                'tanggal' => $tanggal,
                'jam_main' => $jam_main,
                'selesai' => $selesai,
                'lama_main' => $lama_main,
                'status' => $status
            ];

            $whereTanggal = ['tanggal' => $tanggal];
            $whereJamMain = ['jam_main' => $jam_main];
            $whereJamSelasai = ['selesai' => $selesai];
            $validasiTanggal = $this->ModelAdmin->validasiTanggal($whereTanggal,'transaksi')->num_rows();

            if ($data['lama_main'] > 0) {
                if ($validasiTanggal > 0) {
                  if ($lapangan == "Matras") {
                    $validasiJamMain = $this->ModelAdmin->validasiJamMain($whereJamMain,'lapangan_matras')->num_rows();
                    $validasiJamSelesai = $this->ModelAdmin->validasiJamSelesai($whereJamSelasai,'lapangan_matras')->num_rows();
                    if ($validasiJamMain || $validasiJamSelesai > 0) {
                      $this->session->set_flashdata('pesan','Silahkan lihat jadwal terlebih dahulu sebelum memesan!');
                      redirect('Transaksi/create');
                    } else {
                        $this->session->set_flashdata('flash','Ditambahkan');
                        $this->ModelAdmin->insert_transaksi($data_transaksi,'transaksi');
                        $this->ModelAdmin->insert_data($data,'lapangan_matras');
                        redirect('Transaksi/read');
                    }
                  } elseif ($lapangan == "Sintetis") {
                    $validasiJamMain = $this->ModelAdmin->validasiJamMain($whereJamMain,'lapangan_sintetis')->num_rows();
                    $validasiJamSelesai = $this->ModelAdmin->validasiJamSelesai($whereJamSelasai,'lapangan_sintetis')->num_rows();
                    if ($validasiJamMain || $validasiJamSelesai > 0) {
                      $this->session->set_flashdata('pesan','Silahkan lihat jadwal terlebih dahulu sebelum memesan!');
                      redirect('Transaksi/create');
                    } else {
                        $this->session->set_flashdata('flash','Ditambahkan');
                        $this->ModelAdmin->insert_transaksi($data_transaksi,'transaksi');
                        $this->ModelAdmin->insert_data($data,'lapangan_sintetis');
                        redirect('Transaksi/read');
                    }
                  }
                } else {
                  if ($lapangan == "Matras") {
                    $this->session->set_flashdata('flash','Ditambahkan');
                    $this->ModelAdmin->insert_transaksi($data_transaksi,'transaksi');
                    $this->ModelAdmin->insert_data($data,'lapangan_matras');
                    redirect('Transaksi/read');
                  } elseif ($lapangan == "Sintetis") {
                    $this->session->set_flashdata('flash','Ditambahkan');
                    $this->ModelAdmin->insert_transaksi($data_transaksi,'transaksi');
                    $this->ModelAdmin->insert_data($data,'lapangan_sintetis');
                    redirect('Transaksi/read');
                  }
                }
            } else {
                $this->session->set_flashdata('jam','Waktu yang anda masukan salah!');
                redirect('Transaksi/create');
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
        $this->db->like('id_sewa',$data['keyword']);
        $this->db->or_like('nama_pemesan',$data['keyword']);
        $this->db->or_like('kode_sewa',$data['keyword']);
        $this->db->or_like('email',$data['keyword']);
        $this->db->or_like('tanggal',$data['keyword']);
        $this->db->or_like('lapangan',$data['keyword']);
        $this->db->or_like('jam_main',$data['keyword']);
        $this->db->or_like('status',$data['keyword']);
        $this->db->from('transaksi');
        $config['base_url'] = 'http://localhost/admin-selafut/Transaksi/read';
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 5;

        // initialize
        $this->pagination->initialize($config);

        $data['judul'] = 'Transaksi';
        $data['start'] = $this->uri->segment(3);
        $data['transaksi'] = $this->ModelAdmin->get_data_transaksi('transaksi',$config['per_page'],$data['start'],$data['keyword'])->result_array();
        $data['usersesion'] = $this->ModelAdmin->cekData(['email' => $this->session->userdata('email')])->row_array();

    		$this->load->view('templates/admin_header',$data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar');
        $this->load->view('Transaksi/data');
        $this->load->view('templates/admin_footer');
	  }

    public function update($kode)
    {
        $where = ['kode_sewa' => $kode];
        $data['judul'] = 'Transaksi';
        $data['transaksi'] = $this->ModelAdmin->get_data_where($where,'transaksi')->row_array();
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
            $this->load->view('Transaksi/ubah');
            $this->load->view('templates/admin_footer');
        } else {
            $nama = htmlspecialchars($this->input->post('nama', true));
            $email = htmlspecialchars($this->input->post('email', true));
            $status = htmlspecialchars($this->input->post('status', true));
            $tanggal = htmlspecialchars($this->input->post('tanggal', true));
            $selesai = htmlspecialchars($this->input->post('selesai', true));
            $jam_main = htmlspecialchars($this->input->post('jam_main', true));
            $lapangan = htmlspecialchars($this->input->post('lapangan', true));
            $lama_main = $selesai - $jam_main;
            $harga_sewa = $lama_main*30000;
            $kode_sewa = time();
            
            $data_transaksi=[
              'nama_pemesan' => $nama,
              'lapangan' => $lapangan,
              'email' => $email,
              'tanggal' => $tanggal,
              'jam_main' => $jam_main,
              'selesai' => $selesai,
              'lama_main' => $lama_main,
              'harga_sewa' => $harga_sewa,
              'status' => $status,
              'kode_sewa' => $kode_sewa
            ];

            $data = [
              'kode_sewa' => $kode_sewa,
              'nama_pemesan' => $nama,
              'email' => $email,
              'tanggal' => $tanggal,
              'jam_main' => $jam_main,
              'selesai' => $selesai,
              'lama_main' => $lama_main,
              'status' => $status
            ];

            $whereTanggal = ['tanggal' => $tanggal];
            $whereJamMain = ['jam_main' => $jam_main];
            $whereJamSelasai = ['selesai' => $selesai];
            $dataTransaksi['transaksi'] = $this->ModelAdmin->get_data_where($where,'transaksi')->row_array();
            $validasiTanggal = $this->ModelAdmin->validasiTanggal($whereTanggal,'lapangan_matras')->num_rows();

            if($tanggal == $dataTransaksi['transaksi']['tanggal'] && $jam_main == $dataTransaksi['transaksi']['jam_main'] && $selesai == $dataTransaksi['transaksi']['selesai'] && $lapangan == $dataTransaksi['transaksi']['lapangan']) {
                $this->ModelAdmin->update_data($where,$data_transaksi,'transaksi');
                if ($lapangan == 'Matras') {
                  $this->ModelAdmin->update_data($where,$data,'lapangan_matras');
                } elseif($lapangan == 'Sintetis') {
                  $this->ModelAdmin->update_data($where,$data,'lapangan_sintetis');
                }
                $this->session->set_flashdata('flash','Diubah');
                redirect('Transaksi/read');
            } else {
              if ($data['lama_main'] > 0) {
                if ($validasiTanggal > 0) {
                  if ($lapangan == "Sintetis") {
                    $validasiJamMain = $this->ModelAdmin->validasiJamMain($whereJamMain,'lapangan_sintetis')->num_rows();
                    $validasiJamSelesai = $this->ModelAdmin->validasiJamSelesai($whereJamSelasai,'lapangan_sintetis')->num_rows();
                    if ($validasiJamMain || $validasiJamSelesai > 0) {
                        $this->session->set_flashdata('pesan','Silahkan lihat jadwal terlebih dahulu sebelum memesan!');
                        redirect('Transaksi/update/'.$kode);
                    } else {
                        $this->ModelAdmin->update_data($where,$data_transaksi,'transaksi');
                        $this->ModelAdmin->update_data($where,$data,'lapangan_sintetis');
                        $this->ModelAdmin->insert_data($data,'lapangan_sintetis');
                        $this->ModelAdmin->delete_data($where,'lapangan_matras');
                        $this->session->set_flashdata('flash','Diubah');
                        redirect('Transaksi/read');
                    }
                  } else {
                    $validasiJamMain = $this->ModelAdmin->validasiJamMain($whereJamMain,'lapangan_matras')->num_rows();
                    $validasiJamSelesai = $this->ModelAdmin->validasiJamSelesai($whereJamSelasai,'lapangan_matras')->num_rows();
                    if ($validasiJamMain || $validasiJamSelesai > 0) {
                        $this->session->set_flashdata('pesan','Silahkan lihat jadwal terlebih dahulu sebelum memesan!');
                        redirect('Transaksi/update/'.$kode);
                    } else {
                        $this->ModelAdmin->update_data($where,$data_transaksi,'transaksi');
                        $this->ModelAdmin->update_data($where,$data,'lapangan_matras');
                        $this->ModelAdmin->insert_data($data,'lapangan_matras');
                        $this->ModelAdmin->delete_data($where,'lapangan_sintetis');
                        $this->session->set_flashdata('flash','Diubah');
                        redirect('Transaksi/read');
                    }
                  }
                } else {
                  if ($lapangan == "Matras") {
                    $this->ModelAdmin->update_data($where,$data_transaksi,'transaksi');
                    $this->ModelAdmin->update_data($where,$data,'lapangan_matras');
                    $this->ModelAdmin->delete_data($where,'lapangan_sintetis');
                    $this->ModelAdmin->insert_data($data,'lapangan_matras');
                    $this->session->set_flashdata('flash','Diubah');
                    redirect('Transaksi/read');
                  } elseif ($lapangan == "Sintetis") {
                    $this->ModelAdmin->update_data($where,$data_transaksi,'transaksi');
                    $this->ModelAdmin->update_data($where,$data,'lapangan_sintetis');
                    $this->ModelAdmin->delete_data($where,'lapangan_matras');
                    $this->ModelAdmin->insert_data($data,'lapangan_sintetis');
                    $this->session->set_flashdata('flash','Diubah');
                    redirect('Transaksi/read');
                  }
                }
              } else {
                  $this->session->set_flashdata('jam','Waktu yang anda masukan salah!');
                  redirect('Transaksi/update/'.$kode);
              }
            }
        }
    }

    public function delete($kode)
    {
      $where = ['kode_sewa' => $kode];
      $data['transaksi'] = $this->ModelAdmin->get_data_where($where,'transaksi')->row_array();
      $lapangan = $data['transaksi']['lapangan']; 
      if ($lapangan == "Matras") {
        $this->ModelAdmin->delete_data($where,'lapangan_matras');
      } elseif ($lapangan == "Sintetis") {
        $this->ModelAdmin->delete_data($where,'lapangan_sintetis');
      }
      $this->ModelAdmin->delete_data($where,'transaksi');
      $this->session->set_flashdata('flash','Dihapus');
      redirect('Transaksi/read');
    }
}