<div class="container mb-4">
<div class="jam" title="Kesalahan Input!" data-flashdata="<?= $this->session->flashdata('jam'); ?>"></div>
<div class="lapangan" title="Maaf Sudah ada yang Booking" data-flashdata="<?= $this->session->flashdata('pesan'); ?>"></div>
    <div class="row mt-3 justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    Form Ubah Data Lapangan Sintetis
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <input value="<?= $lapangan['kode_sewa']; ?>" type="hidden" class="form-control" id="kode_sewa" name="kode_sewa">
                        <div class="form-group">
                            <label for="nama">Nama Pemesan</label>
                            <input value="<?= $lapangan['nama_pemesan']; ?>" type="text" class="form-control" id="nama" name="nama">
                            <small class="form-text text-danger"><?= form_error('nama'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input value="<?= $lapangan['email']; ?>" type="text" class="form-control" id="email" name="email">
                            <small class="form-text text-danger"><?= form_error('email'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input value="<?= $lapangan['tanggal']; ?>" type="date" class="form-control" id="tanggal" name="tanggal">
                            <small class="form-text text-danger"><?= form_error('tanggal'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="jam_main">Jam Main</label>
                            <select class="form-control" id="jam_main" name="jam_main">
                                <option value="09.00" <?php if($lapangan['jam_main'] == "09.00"){ echo "selected"; } ?> >09.00</option>
                                <option value="10.00" <?php if($lapangan['jam_main'] == "10.00"){ echo "selected"; } ?>  >10.00</option>
                                <option value="11.00" <?php if($lapangan['jam_main'] == "11.00"){ echo "selected"; } ?> >11.00</option>
                                <option value="12.00" <?php if($lapangan['jam_main'] == "12.00"){ echo "selected"; } ?> >12.00</option>
                                <option value="13.00" <?php if($lapangan['jam_main'] == "13.00"){ echo "selected"; } ?> >13.00</option>
                                <option value="14.00" <?php if($lapangan['jam_main'] == "14.00"){ echo "selected"; } ?> >14.00</option>
                                <option value="15.00" <?php if($lapangan['jam_main'] == "15.00"){ echo "selected"; } ?> >15.00</option>
                                <option value="16.00" <?php if($lapangan['jam_main'] == "16.00"){ echo "selected"; } ?> >16.00</option>
                                <option value="17.00" <?php if($lapangan['jam_main'] == "17.00"){ echo "selected"; } ?> >17.00</option>
                                <option value="18.00" <?php if($lapangan['jam_main'] == "18.00"){ echo "selected"; } ?> >18.00</option>
                                <option value="19.00" <?php if($lapangan['jam_main'] == "19.00"){ echo "selected"; } ?> >19.00</option>
                                <option value="20.00" <?php if($lapangan['jam_main'] == "20.00"){ echo "selected"; } ?> >20.00</option>
                                <option value="21.00" <?php if($lapangan['jam_main'] == "21.00"){ echo "selected"; } ?> >21.00</option>
                                <option value="22.00" <?php if($lapangan['jam_main'] == "22.00"){ echo "selected"; } ?> >22.00</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="selesai">Selesai</label>
                            <select class="form-control" id="selesai" name="selesai">
                                <option value="10.00" <?php if($lapangan['selesai'] == "10.00"){ echo "selected"; } ?> >10.00</option>
                                <option value="11.00" <?php if($lapangan['selesai'] == "11.00"){ echo "selected"; } ?> >11.00</option>
                                <option value="12.00" <?php if($lapangan['selesai'] == "12.00"){ echo "selected"; } ?> >12.00</option>
                                <option value="13.00" <?php if($lapangan['selesai'] == "13.00"){ echo "selected"; } ?> >13.00</option>
                                <option value="14.00" <?php if($lapangan['selesai'] == "14.00"){ echo "selected"; } ?> >14.00</option>
                                <option value="15.00" <?php if($lapangan['selesai'] == "15.00"){ echo "selected"; } ?> >15.00</option>
                                <option value="16.00" <?php if($lapangan['selesai'] == "16.00"){ echo "selected"; } ?> >16.00</option>
                                <option value="17.00" <?php if($lapangan['selesai'] == "17.00"){ echo "selected"; } ?> >17.00</option>
                                <option value="18.00" <?php if($lapangan['selesai'] == "18.00"){ echo "selected"; } ?> >18.00</option>
                                <option value="19.00" <?php if($lapangan['selesai'] == "19.00"){ echo "selected"; } ?> >19.00</option>
                                <option value="20.00" <?php if($lapangan['selesai'] == "20.00"){ echo "selected"; } ?> >20.00</option>
                                <option value="21.00" <?php if($lapangan['selesai'] == "21.00"){ echo "selected"; } ?> >21.00</option>
                                <option value="22.00" <?php if($lapangan['selesai'] == "22.00"){ echo "selected"; } ?> >22.00</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info float-right">Tambah</button>
                        <a href="<?= base_url('LapanganSintetis/read'); ?>" class="btn btn-outline-warning float-right mr-2">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>