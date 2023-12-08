<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        cek_login();
    }

    public function dashboard()
    {
        // config
        $config['base_url'] = 'http://localhost/admin-selafut/admin/dashboard';
        $config['total_rows'] = $this->ModelAdmin->getData('transaksi')->num_rows();
        $config['per_page'] = 5;
        
        // initialize
        $this->pagination->initialize($config);
        
        $data['judul'] = 'Dashboard';
        $data['start'] = $this->uri->segment(3);
        $data['transaksi'] = $this->ModelAdmin->get_data('transaksi',$config['per_page'],$data['start'],null,'nama_pemesan')->result_array();
        $data['usersesion'] = $this->ModelAdmin->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['jumlahPenyewa'] = $this->ModelUser->getUserWhere(['role_id' => 2])->num_rows(); 
        $data['totalLapanganSintetis'] = $this->ModelAdmin->getData('lapangan_sintetis')->num_rows();
        $data['totalLapanganMatras'] = $this->ModelAdmin->getData('lapangan_matras')->num_rows();
        $data['totalTransaksi'] = $this->ModelAdmin->getData('transaksi')->num_rows();
        
		$this->load->view('templates/admin_header',$data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar');
        $this->load->view('admin/dashboard');
        $this->load->view('templates/admin_footer');
	}

    public function profile()
    {
        $data['judul'] = 'Profile';
        $data['usersesion'] = $this->ModelAdmin->cekData(['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/admin_header',$data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar');
        $this->load->view('admin/profile');
        $this->load->view('templates/admin_footer');
    }

    public function ubahProfil()
    {
        $data['judul'] = 'Ubah Profile';
        $data['usersesion'] = $this->ModelAdmin->cekData(['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim', [
            'required' => 'Nama tidak Boleh Kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin_header',$data);
            $this->load->view('templates/admin_sidebar');
            $this->load->view('templates/admin_topbar');
            $this->load->view('admin/ubah_profile');
            $this->load->view('templates/admin_footer');
        } else {
            $nama = $this->input->post('nama', true);
            $email = $this->input->post('email', true);

            //jika ada gambar yang akan diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['upload_path'] = './assets/admin/img/profile/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '3000';
                $config['max_width'] = '1024';
                $config['max_height'] = '1000';
                $config['file_name'] = 'img' . time();

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $gambar_lama = $data['usersesion']['image'];
                    if ($gambar_lama != 'default.jpg') {
                        unlink(FCPATH . 'assets/admin/img/profile/' . $gambar_lama);
                    }
                    $gambar_baru = $this->upload->data('file_name');
                    $this->db->set('image', $gambar_baru);
                } else { }
            }

            $this->db->set('nama', $nama);
            $this->db->where('email', $email);
            $this->db->update('admin');

            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Profil Berhasil diubah </div>');
            redirect('admin/profile');
        }
    }
}