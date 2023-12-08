<div class="container" style="overflow: auto;">
    <div class="flash-data" title="Lapangan Sintetis" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-info mb-4">
      <a class="navbar-brand">Jadwal Lapangan Sintetis</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item">
            <a href="<?= base_url('LapanganSintetis/create'); ?>" class="btn btn-warning my-2 my-sm-0 ml-0 ml-md-5" type="submit">Tambah Data Baru</a>
          </li>
        </ul>
        <form action="<?= base_url('LapanganSintetis/read'); ?>" method="post" class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" name="keyword" autocomplete="off" autofocus type="search" placeholder="Search keyword...">
          <button class="btn btn-warning my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
    <div class="table-responsive mb-3">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Kode Sewa</th>
          <th scope="col">Nama</th>
          <th scope="col">Email</th>
          <th scope="col">Tanggal</th>
          <th scope="col">Jam Main</th>
          <th scope="col">Selesai</th>
          <th scope="col">Lama Main</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if(empty($lapangan)): ?>
          <tr>
            <td colspan="9">
              <div class="alert alert-danger" role="alert">
                Data tidak ditemukan!
              </div>
            </td>
          </tr>
        <?php endif; ?>  
        <?php foreach ($lapangan as $l): ?>
        <tr>
            <th scope="row"><?= ++$start; ?></th>
            <td><?= $l['kode_sewa']; ?></td>
            <td><?= $l['nama_pemesan']; ?></td>
            <td><?= $l['email']; ?></td>
            <td><?= $l['tanggal']; ?></td>
            <td><?= $l['jam_main']; ?></td>
            <td><?= $l['selesai']; ?></td>
            <td><?= $l['lama_main']; ?> Jam</td>
            <td>
            <a href="<?= base_url('LapanganSintetis/update/').$l['kode_sewa'] ?>"><i class="text-warning mr-2 fas fa-fw fa-pen"></i></a>
            <a class="hapus" href="<?= base_url('LapanganSintetis/delete/').$l['kode_sewa'] ?>"><i class="text-info fas fa-fw fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <?= $this->pagination->create_links(); ?>
</div>