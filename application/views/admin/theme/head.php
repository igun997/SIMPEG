<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>{title}</title>

  {css}
  <link href="{url}" rel="stylesheet">
  {/css}

</head>

<body id="page-top">
  <style media="screen">
    .bg-image {
      background-image: url(<?= base_url("assets/img/sidebar.jfif") ?>) ;
    }
  </style>

  <!-- Page Wrapper -->
  <div id="wrapper" ><!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-secondary bg-image sidebar sidebar-dark accordion" id="accordionSidebar" >

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laptop-code"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Simpeg CV.LOVA </div>
      </a>

      <!-- Divider -->
      <div class="sidebar-heading">
        Naivigasi
      </div>
      <?php $base = function($url="") {
        return base_url("admin/".$url);
      };?>
      <li class="nav-item">
      <a class="nav-link pb-0" href="<?= $base("") ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Data Master</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?= $base("divisi") ?>">Data Divisi Kerja</a>
            <a class="collapse-item" href="<?= $base("pegawai") ?>">Data Pegawai</a>
            <a class="collapse-item" href="<?= $base("overtime") ?>">Tunjangan</a>
            <a class="collapse-item" href="<?= $base("admin") ?>">Data Administrator</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link pb-0" href="<?= $base("absensi") ?>">
          <i class="fas fa-calendar-alt"></i>
          <span>Absensi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link pb-0" href="<?= $base("penggajian") ?>">
          <i class="fas fa-calculator"></i>
          <span>Penggajian</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link pb-0" href="<?= $base("pinjaman") ?>">
        <i class="far fa-credit-card"></i>
          <span>Peminjaman</span>
        </a>
      </li>
      <hr class="sidebar-divider">
      <li class="nav-item">
      <a class="nav-link pb-0" href="<?= $base("pengaturan") ?>">
        <i class="fa fa-cog"></i>
        <span>Pengaturan Aplikasi</span>
      </a>
      </li>
      <li class="nav-item">
      <a class="nav-link pb-0" href="<?= $base("akun") ?>">
        <i class="fa fa-user"></i>
        <span>Pengaturan Akun</span>
      </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url("public/home/logout") ?>">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span></a>
      </li>


      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar --><!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <style media="screen">
        .bg-main-image {
          background-image: url(<?= base_url("assets/img/bg.png") ?>) ;
        }
      </style>
      <div id="content" class="bg-primary bg-main-image">

        <!-- Topbar -->
        <style media="screen">
          .bg-topbar-image {
            background-image: url(<?= base_url("assets/img/topbar.png") ?>) ;
          }
        </style>
        <nav class="navbar navbar-expand navbar-light bg-primary bg-topbar-image topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>


          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>


            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?= $this->session->nama ?> </span>
                <img class="img-profile rounded-circle" src="<?= base_url("upload/").$this->session->foto ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url("public/home/logout") ?>" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
