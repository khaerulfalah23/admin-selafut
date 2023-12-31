<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin/dashboard'); ?>">
    <div class="sidebar-brand-icon">
        <i class="fas fa-user-tie"></i>
    </div>
    <div class="sidebar-brand-text ml-2">Admin Selafut</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Tables -->
<li class="<?= ($this->uri->segment(2) === 'dashboard') ? 'nav-item active' : 'nav-item' ?>">
    <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Nav Item - Tables -->
<li class="<?= ($this->uri->segment(1) === 'user') ? 'nav-item active' : 'nav-item' ?>">
    <a class="nav-link" href="<?= base_url('user/read'); ?>">
        <i class="fas fa-users fa-table"></i>
        <span>Data User</span></a>
<!-- Nav Item - Tables -->

<li class="<?= ($this->uri->segment(1) === 'LapanganMatras') ? 'nav-item active' : 'nav-item' ?>">
    <a class="nav-link" href="<?= base_url('LapanganMatras/read'); ?>">
        <i class="fas fa-fw fa-futbol"></i>
        <span>Data Lapangan Matras</span></a>
</li>

<!-- Nav Item - Tables -->
<li class="<?= ($this->uri->segment(1) === 'LapanganSintetis') ? 'nav-item active' : 'nav-item' ?>">
    <a class="nav-link" href="<?= base_url('LapanganSintetis/read'); ?>">
        <i class="fas fa-fw fa-futbol"></i>
        <span>Data Lapangan Sintetis</span></a>
</li>

<!-- Nav Item - Tables -->
<li class="<?= ($this->uri->segment(1) === 'Transaksi') ? 'nav-item active' : 'nav-item' ?>">
    <a class="nav-link" href="<?= base_url('Transaksi/read'); ?>">
        <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Transaksi</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>


</ul>
<!-- End of Sidebar -->