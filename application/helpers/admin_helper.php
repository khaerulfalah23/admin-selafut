<?php

function cek_login()
{
    $ci = get_instance();
    
    if (!$ci->session->userdata('email') ) {
        $ci->session->set_flashdata('pesan','Akses ditolak. Anda belum login!!');
        redirect('autentifikasi');
    }
}