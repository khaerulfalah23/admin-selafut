<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Autentifikasi extends CI_Controller
{

    public function index()
    {
        $this->form_validation->set_rules('email', 'Alamat Email', 'required|trim|valid_email', [
            'required' => 'Email Harus diisi!!',
            'valid_email' => 'Email Tidak Benar!!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Password Harus diisi'
        ]);
        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('autentifikasi/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = htmlspecialchars($this->input->post('email', true));
        $password = $this->input->post('password', true);

        $admin = $this->ModelAdmin->cekData(['email' => $email])->row_array();
        
        //jika usernya ada
        if ($admin) {
            //cek password
            if ($password == $admin['password']) {
                $data = ['email' => $admin['email']];
                $this->session->set_userdata($data);
                redirect('admin/dashboard');
            } else {
                $this->session->set_flashdata('pesan','Password salah!!');
                redirect('autentifikasi');
            }
        } else {
            $this->session->set_flashdata('pesan','Email tidak terdaftar!!');
            redirect('autentifikasi');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        // $this->session->set_flashdata('logout', '<div class="alert alert-success alert-message" role="alert">Anda berhasil logout!</div>');
        $this->session->set_flashdata('logout', 'Silahkan login kembali');
        redirect('autentifikasi');
    }
}
