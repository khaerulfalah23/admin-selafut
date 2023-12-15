<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

public function read()
    {
        // Ambil data keyword
        if($this->input->post('keyword')) {
            $data['keyword'] = $this->input->post('keyword');
        }else{
            $data['keyword'] = null;
        }

        // config
        $this->db->like('id',$data['keyword']);
        $this->db->or_like('nama',$data['keyword']);
        $this->db->or_like('email',$data['keyword']);
        $this->db->from('user');
        $config['base_url'] = 'http://localhost/admin-selafut/user/read';
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 5;

        // initialize
        $this->pagination->initialize($config);

        $data['judul'] = 'User';
        $data['start'] = $this->uri->segment(3);
        $data['user'] = $this->ModelUser->get_data('user',$config['per_page'],$data['start'],$data['keyword'])->result_array();
        $data['usersesion'] = $this->ModelAdmin->cekData(['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/admin_header',$data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar');
        $this->load->view('user/data');
        $this->load->view('templates/admin_footer');
    }

    public function create()
    {
        $data['judul'] = 'User';
        $data['usersesion'] = $this->ModelAdmin->cekData(['email' => $this->session->userdata('email')])->row_array();
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required', [
            'required' => 'Nama Belum diis!!'
        ]);
        $this->form_validation->set_rules('email', 'Alamat Email', 'required|trim|valid_email|is_unique[user.email]', [
            'valid_email' => 'Email Tidak Benar!!',
            'required' => 'Email Belum diisi!!',
            'is_unique' => 'Email Sudah Terdaftar!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'required' => 'Password Belum diisi!!',
            'min_length' => 'Password Terlalu Pendek'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin_header',$data);
            $this->load->view('templates/admin_sidebar');
            $this->load->view('templates/admin_topbar');
            $this->load->view('user/tambah');
            $this->load->view('templates/admin_footer');
        } else {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'date_created' => time()
            ];

            $this->ModelUser->simpanData($data);
            $this->session->set_flashdata('flash','Ditambahkan');
            redirect('user/read');
        }
    }

    public function update($kode)
    {
        $where = ['id' => $kode];
        $data['judul'] = 'User';
        $data['user']=$this->ModelAdmin->get_data_where($where,'user')->row_array();
        $data['usersesion'] = $this->ModelAdmin->cekData(['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required', [
            'required' => 'Nama Belum diis!!'
        ]);
        $this->form_validation->set_rules('email', 'Alamat Email', 'required|trim|valid_email', [
            'valid_email' => 'Email Tidak Benar!!',
            'required' => 'Email Belum diisi!!',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'required' => 'Password Belum diisi!!',
            'min_length' => 'Password Terlalu Pendek'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin_header',$data);
            $this->load->view('templates/admin_sidebar');
            $this->load->view('templates/admin_topbar');
            $this->load->view('user/ubah');
            $this->load->view('templates/admin_footer');
        } else {   
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'date_created' => time()
            ];

    		$this->ModelAdmin->update_data($where,$data,'user');
            $this->session->set_flashdata('flash','Diubah');
            redirect('user/read');
        }
    }

    public function delete($kode)
    {
		$where = ['id' => $kode];
		$this->ModelAdmin->delete_data($where,'user');
        $this->session->set_flashdata('flash','Dihapus');
		redirect('user/read');
	}
}