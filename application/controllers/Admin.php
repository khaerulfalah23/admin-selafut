<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function index()    
    {
        $data['usersesion'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar');
        $this->load->view('templates/admin_footer');       
    }

    public function get_lapangan_matras()
    {
        // Ambil data keyword
        if($this->input->post('keyword')) {
            $data['keyword'] = $this->input->post('keyword');
            $this->session->set_userdata('keyword',$data['keyword']);
        }else{
            $data['keyword'] = $this->input->post('keyword');
        }

        // config
        $this->db->like('nama_pemesan',$data['keyword']);
        $this->db->from('lapangan_matras');
        $config['base_url'] = 'http://localhost/admin-selafut/admin/get_lapangan_matras';
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 5;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['lapangan'] = $this->ModelAdmin->get_data('lapangan_matras',$config['per_page'],$data['start'],$data['keyword'],'nama_pemesan')->result_array();
        $data['usersesion'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/admin_header',$data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar');
        $this->load->view('lapangan_matras');
        $this->load->view('templates/admin_footer');
	}

    public function tambah_data_matras()
    {
        $data['usersesion'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
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
            $this->load->view('form_lapangan_matras');
            $this->load->view('templates/admin_footer');
        } else {
            $jam_main = htmlspecialchars($this->input->post('jam_main', true));
            $selesai = htmlspecialchars($this->input->post('selesai', true));
            $data = [
                'nama_pemesan' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'tanggal' => htmlspecialchars($this->input->post('tanggal', true)),
                'jam_main' => $jam_main,
                'selesai' => $selesai,
                'lama_main' => $selesai - $jam_main
            ];
            $this->ModelAdmin->insert_data($data,'lapangan_matras');
            $this->session->set_flashdata('flash','Ditambahkan');
		    redirect('admin/get_lapangan_matras');
        }
    }

    public function ubah_lapangan_matras($kode)
    {
        $where = ['kode_sewa' => $kode];
        $data['lapangan']=$this->ModelAdmin->get_data_where($where,'lapangan_matras')->row_array();
        $data['usersesion'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

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
            $this->load->view('form_ubah_matras');
            $this->load->view('templates/admin_footer');
        } else {
            $kode = $this->input->post('kode_sewa');
            $jam_main = htmlspecialchars($this->input->post('jam_main', true));
            $selesai = htmlspecialchars($this->input->post('selesai', true));
            $data = [
                'nama_pemesan' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'tanggal' => htmlspecialchars($this->input->post('tanggal', true)),
                'jam_main' => $jam_main,
                'selesai' => $selesai,
                'lama_main' => $selesai - $jam_main
            ];

            $where=['kode_sewa' => $kode];
    		$this->ModelAdmin->update_data($where,$data,'lapangan_matras');
            $this->session->set_flashdata('flash','Diubah');
    		redirect('admin/get_lapangan_matras');
        }
    }

    public function hapus_lapangan_matras($kode)
    {
		$where = ['kode_sewa' => $kode];
		$this->ModelAdmin->delete_data($where,'lapangan_matras');
        $this->session->set_flashdata('flash','Dihapus');
		redirect('admin/get_lapangan_matras');
	}

    public function get_lapangan_sintetis()
    {
        // Ambil data keyword
        if($this->input->post('keyword')) {
            $data['keyword'] = $this->input->post('keyword');
            $this->session->set_userdata('keyword',$data['keyword']);
        }else{
            $data['keyword'] = $this->input->post('keyword');
        }

        // config
        $this->db->like('nama_pemesan',$data['keyword']);
        $this->db->from('lapangan_sintetis');
        $config['base_url'] = 'http://localhost/admin-selafut/admin/get_lapangan_sintetis';
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 5;

        // initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['lapangan'] = $this->ModelAdmin->get_data('lapangan_sintetis',$config['per_page'],$data['start'],$data['keyword'],'lapangan_sintetis')->result_array();
        $data['usersesion'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/admin_header',$data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar');
        $this->load->view('lapangan_sintetis');
        $this->load->view('templates/admin_footer');
	}

    public function tambah_data_sintetis()
    {
        $data['usersesion'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
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
            $this->load->view('form_lapangan_matras');
            $this->load->view('templates/admin_footer');
        } else {
            $jam_main = htmlspecialchars($this->input->post('jam_main', true));
            $selesai = htmlspecialchars($this->input->post('selesai', true));
            $data = [
                'nama_pemesan' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'tanggal' => htmlspecialchars($this->input->post('tanggal', true)),
                'jam_main' => $jam_main,
                'selesai' => $selesai,
                'lama_main' => $selesai - $jam_main
            ];
            $this->ModelAdmin->insert_data($data,'lapangan_sintetis');
            $this->session->set_flashdata('flash','Ditambahkan');
		    redirect('admin/get_lapangan_sintetis');
        }
    }

    public function ubah_lapangan_sintetis($kode)
    {
        $where = ['kode_sewa' => $kode];
        $data['lapangan']=$this->ModelAdmin->get_data_where($where,'lapangan_sintetis')->row_array();
        $data['usersesion'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

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
            $this->load->view('form_ubah_matras');
            $this->load->view('templates/admin_footer');
        } else {
            $kode = $this->input->post('kode_sewa');
            $jam_main = htmlspecialchars($this->input->post('jam_main', true));
            $selesai = htmlspecialchars($this->input->post('selesai', true));
            $data = [
                'nama_pemesan' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'tanggal' => htmlspecialchars($this->input->post('tanggal', true)),
                'jam_main' => $jam_main,
                'selesai' => $selesai,
                'lama_main' => $selesai - $jam_main
            ];

            $where=['kode_sewa' => $kode];
    		$this->ModelAdmin->update_data($where,$data,'lapangan_sintetis');
            $this->session->set_flashdata('flash','Diubah');
    		redirect('admin/get_lapangan_sintetis');
        }
    }

    public function hapus_lapangan_sintetis($kode)
    {
        $where = ['kode_sewa' => $kode];
        $this->ModelAdmin->delete_data($where,'lapangan_sintetis');
        $this->session->set_flashdata('flash','Dihapus');
        redirect('admin/get_lapangan_sintetis');
    }
}