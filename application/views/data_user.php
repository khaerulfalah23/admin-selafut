<div class="container" style="overflow: auto;">
    <div class="flash-data" title="User" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-info mb-4">
      <a class="navbar-brand">Data User</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item">
            <a href="<?= base_url('user/create'); ?>" class="btn btn-warning my-2 my-sm-0 ml-0 ml-md-5" type="submit">Tambah Data Baru</a>
          </li>
        </ul>
        <form action="<?= base_url('user/read'); ?>" method="post" class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" name="keyword" autocomplete="off" type="search" placeholder="Search">
          <button class="btn btn-warning my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
    <div class="table-responsive mb-3">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Id User</th>
          <th scope="col">Nama</th>
          <th scope="col">Email</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
          <?php foreach ($user as $u): ?>
        <tr>
            <th scope="row"><?= ++$start; ?></th>
            <td><?= $u['id']; ?></td>
            <td><?= $u['nama']; ?></td>
            <td><?= $u['email']; ?></td>
            <td>
            <a href="<?= base_url('user/update/').$u['id'] ?>"><i class="text-warning mr-2 fas fa-fw fa-pen"></i></a>
            <a class="hapus" href="<?= base_url('user/delete/').$u['id'] ?>"><i class="text-info fas fa-fw fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <?= $this->pagination->create_links(); ?>
</div>