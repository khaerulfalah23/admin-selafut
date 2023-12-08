<div class="container" style="overflow: auto;">
    <div class="flash-data" title="Transaksi" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-info mb-4">
      <a class="navbar-brand">Data Transaksi</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item">
            <a href="<?= base_url('transaksi/create'); ?>" class="btn btn-warning my-2 my-sm-0 ml-0 ml-md-5" type="submit">Tambah Data Baru</a>
          </li>
        </ul>
        <form action="<?= base_url('Transaksi/read'); ?>" method="post" class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" name="keyword" autocomplete="off" autofocus type="search" placeholder="Search keyword...">
          <button class="btn btn-warning my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
    <div class="table-responsive mb-3">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
            <th>No</th>
            <th>Id Sewa</th>
            <th>Nama Pemesan</th>
            <th>Lapangan </th>
            <th>Email</th>
            <th style="width: 130px;">Tanggal</th>
            <th>Jam main</th>
            <th>selesai</th>
            <th style="width: 70px;">lama main</th>
            <th style="width: 110px;">harga</th>
            <th>status</th>
            <th>aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if(empty($transaksi)): ?>
          <tr>
            <td colspan="12">
              <div class="alert alert-danger" role="alert">
                Data tidak ditemukan!
              </div>
            </td>
          </tr>
        <?php endif; ?>  
        <?php foreach ($transaksi as $t): ?>
        <tr>
            <th scope="row"><?= ++$start; ?></th>
            <td><?= $t['id_sewa']; ?></td>
            <td><?= $t['nama_pemesan']; ?></td>
            <td><?= $t['lapangan']; ?></td>
            <td><?= $t['email']; ?></td>
            <td><?= $t['tanggal']; ?></td>
            <td><?= $t['jam_main']; ?></td>
            <td><?= $t['selesai']; ?></td>
            <td><?= $t['lama_main']; ?> Jam</td>
            <td>Rp. <?= $t['harga_sewa']; ?></td>
            <td><?= $t['status']; ?></td>
            <td>
            <a href="<?= base_url('transaksi/update/').$t['kode_sewa'] ?>"><i class="text-warning fas fa-fw fa-pen"></i></a>
            <a class="hapus" href="<?= base_url('transaksi/delete/').$t['kode_sewa'] ?>"><i class="text-info fas fa-fw fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <?= $this->pagination->create_links(); ?>
</div>