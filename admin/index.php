<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'web_lanjut_kel_1';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
    exit();
}

// Query untuk mengambil data berita
$query = "SELECT berita.id, berita.judul, kategori.nama AS kategori, berita.isi_berita, berita.file_upload, berita.created_at 
          FROM berita
          JOIN kategori ON berita.kategori_id = kategori.id";
$stmt = $db->prepare($query);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Web Tugas</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php?p=mhs" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='mhs')? 'active' : '' ?>">Mahasiswa</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php?p=prodi" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='prodi')? 'active' : '' ?>">Prodi</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php?p=dosen" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='dosen')? 'active' : '' ?>">Dosen</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php?p=kategori" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='kategori')? 'active' : '' ?>">Kategori</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php?p=berita" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='berita')? 'active' : '' ?>">Berita</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php?p=matakuliah" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='matakuliah')? 'active' : '' ?>">Matakuliah</a>
      </li>
    </ul>
    <!-- Right navbar links -->
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
    </ul>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php?p=home" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">APP-TI</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user4-128x128.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">KEL 1</a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="index.php?p=home" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='home')? 'active' : '' ?>">
              <i class="nav-icon fas fa-home"></i>
              <p>Home</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?p=mhs" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='mhs')? 'active' : '' ?>">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>Mahasiswa</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?p=prodi" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='prodi')? 'active' : '' ?>">
              <i class="nav-icon fas fa-university"></i>
              <p>Prodi</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?p=dosen" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='dosen')? 'active' : '' ?>">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>Dosen</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?p=kategori" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='kategori')? 'active' : '' ?>">
              <i class="nav-icon fas fa-tags"></i>
              <p>Kategori</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?p=berita" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='berita')? 'active' : '' ?>">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>Berita</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Main content -->
  <main class="content-wrapper">
    <div class="container-fluid">
      <h3>Daftar Berita</h3>
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Isi Berita</th>
            <th>File Upload</th>
            <th>Tanggal Dibuat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo "<tr>";
              echo "<td>" . $row['id'] . "</td>";
              echo "<td>" . $row['judul'] . "</td>";
              echo "<td>" . $row['kategori'] . "</td>";
              echo "<td>" . substr($row['isi_berita'], 0, 50) . "...</td>"; // Menampilkan potongan isi berita
              echo "<td>";
              if ($row['file_upload']) {
                  echo "<a href='upload/" . $row['file_upload'] . "'>Download</a>";
              } else {
                  echo "-";
              }
              echo "</td>";
              echo "<td>" . $row['created_at'] . "</td>";
              echo "<td>
                        <a href='edit_berita.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='delete_berita.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                      </td>";
              echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <!-- Footer -->
  <footer class="main-footer">
    <strong>Footer Content</strong>
  </footer>
</div>

<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
    });
  });
</script>
</body>
</html>