<?php
// Konfigurasi koneksi PDO
include 'koneksi.php';

// Menentukan halaman yang ingin dimuat
$page = isset($_GET['p']) ? $_GET['p'] : 'home';

// HEADER (AdminLTE Header)
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>APP Jurusan TI</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets-adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../assets-adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../assets-adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../assets-adminlte/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets-adminlte/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../assets-adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../assets-adminlte/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../assets-adminlte/plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../assets-adminlte/dist/img/Letter M.jpg" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="index.php?p=home" class="brand-link">
        <img src="../assets-adminlte/dist/img/logoti.jpg" alt="Admin APP TI Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin APP TI</span>
      </a>
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="../assets-adminlte/dist/img/logoti.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Kelompok 1</a>
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">Menu</li>
            <li class="nav-item">
              <a href="index.php" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>Home</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?p=mhs" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Mahasiswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?p=prodi" class="nav-link">
                <i class="nav-icon fas fa-list"></i>
                <p>Prodi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?p=dosen" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>Dosen</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?p=kategori" class="nav-link">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>Kategori</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?p=berita" class="nav-link">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>Berita</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?p=matakuliah" class="nav-link">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>Mata Kuliah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?p=user" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>User</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../logout.php" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Sign Out</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <!-- CONTENT WRAPPER -->
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <?php
            // Tampilkan Halaman Berdasarkan Parameter 'p'
            if ($page == 'home') include 'home.php';
            if ($page == 'mhs') include 'mahasiswa.php';
            if ($page == 'prodi') include 'prodi.php';
            if ($page == 'dosen') include 'dosen.php';
            if ($page == 'kategori') include 'kategori.php';
            if ($page == 'berita') include 'berita.php';
            if ($page == 'matakuliah') include 'matakuliah.php';
            if ($page == 'user') include 'user.php';
            ?>
          </main>
        </div>
      </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
      <strong>Footer &copy; 2024</strong>
    </footer>
  </div>

  <!-- jQuery -->
  <script src="../assets-adminlte/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../assets-adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../assets-adminlte/dist/js/adminlte.min.js"></script>
</body>

</html>