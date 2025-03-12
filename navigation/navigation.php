<!-- Page Wrapper -->
<div id="wrapper">

<?php 
    $current_page = basename($_SERVER['PHP_SELF']); 
    $folder_name = basename(dirname($_SERVER['PHP_SELF']));

    // Cek apakah file saat ini ada di dalam folder admin
    $base_path = ($folder_name == 'admin') ? "" : "view/admin/";
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= ($folder_name == 'admin') ? '../../index.php' : 'index.php' ?>">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">DPMPTSP</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item <?= ($current_page == 'index.php') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?= ($folder_name == 'admin') ? '../../index.php' : 'index.php' ?>">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Daftar Menu
  </div>

  <!-- Nav Item - Data Karyawan -->
  <li class="nav-item <?= ($current_page == 'karyawan.php') ? 'active' : '' ?>">
    <a class="nav-link" href="<?= $base_path ?>karyawan.php">
      <i class="fas fa-fw fa-user-plus"></i>
      <span>Data Karyawan</span></a>
  </li>

  <!-- Nav Item - Data Jabatan -->
  <li class="nav-item <?= ($current_page == 'gaji.php') ? 'active' : '' ?>">
    <a class="nav-link" href="<?= $base_path ?>gaji.php">
    <i class="fas fa-money-bill"></i>
      <span>Data Gaji</span></a>
  </li>

    <!-- Nav Item - Data Jabatan -->
  <li class="nav-item <?= ($current_page == 'desa.php') ? 'active' : '' ?>">
    <a class="nav-link" href="<?= $base_path ?>desa.php">
    <i class="fas fa-map"></i>
      <span>Data Wilayah</span></a>
  </li>

  <li class="nav-item <?= ($current_page == 'industry.php') ? 'active' : '' ?>">
    <a class="nav-link" href="<?= $base_path ?>industry.php">
    <i class="fas fa-industry"></i>
      <span>Data Industri Pionir</span></a>
  </li>

  <li class="nav-item <?= ($current_page == 'bidang_usaha.php') ? 'active' : '' ?>">
    <a class="nav-link" href="<?= $base_path ?>bidang_usaha.php">
    <i class="fas fa-industry"></i>
    <i class="fas fa-plus" style="position: relative; left: -5px;"></i>
      <span>Tambah Data Bidang Usaha</span></a>
  </li>

  <li class="nav-item <?= ($current_page == 'jenis_produksi.php') ? 'active' : '' ?>">
  <a class="nav-link" href="<?= $base_path ?>jenis_produksi.php">
    <i class="fas fa-boxes"></i>
    <i class="fas fa-plus" style="position: relative; left: -5px;"></i>
    <span>Tambah Data Jenis Produksi</span>
  </a>
</li>



  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->

<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">



    </nav>