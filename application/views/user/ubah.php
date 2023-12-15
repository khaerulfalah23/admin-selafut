<div class="container">
    <div class="row mt-3 justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    Form Ubah Data User
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <input value="<?= $user['id']; ?>" type="hidden" class="form-control" id="kode_sewa" name="kode_sewa">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input value="<?= $user['nama']; ?>" type="text" class="form-control" id="nama" name="nama" autocomplete="off">
                            <small class="form-text text-danger"><?= form_error('nama'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input value="<?= $user['email']; ?>" type="text" class="form-control" id="email" name="email" autocomplete="off">
                            <small class="form-text text-danger"><?= form_error('email'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text text-danger"><?= form_error('password'); ?></small>
                        </div>
                        <button type="submit" class="btn btn-info float-right">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>