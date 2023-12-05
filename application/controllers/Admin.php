<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function dashboard()
    {
        // config
        $config['base_url'] = 'http://localhost/admin-selafut/admin/dashboard';
        $config['total_rows'] = $this->ModelAdmin->getData('transaksi')->num_rows();
        $config['per_page'] = 5;

        // initialize
        $this->pagination->initialize($config);
        
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
        $this->load->view('dashboard');
        $this->load->view('templates/admin_footer');
	}
}