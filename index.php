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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App-TI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
    <style>
        .form-group .col-sm-8 {
            padding-top: 10px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">APP-TI</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link <?= isset($_GET['p']) && ($_GET['p']=='home') ? 'active' : '' ?>" href="index.php?p=home">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= isset($_GET['p']) && ($_GET['p']=='mhs') ? 'active' : '' ?>" href="index.php?p=mhs">Mahasiswa</a></li>
                <li class="nav-item"><a class="nav-link <?= isset($_GET['p']) && ($_GET['p']=='prodi') ? 'active' : '' ?>" href="index.php?p=prodi">Prodi</a></li>
                <li class="nav-item"><a class="nav-link <?= isset($_GET['p']) && ($_GET['p']=='dosen') ? 'active' : '' ?>" href="index.php?p=dosen">Dosen</a></li>
                <li class="nav-item"><a class="nav-link <?= isset($_GET['p']) && ($_GET['p']=='matakuliah') ? 'active' : '' ?>" href="index.php?p=matakuliah">Matakuliah</a></li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php
        $page = isset($_GET['p']) ? $_GET['p'] : 'home';
        
        // Halaman yang menggunakan PDO untuk menampilkan data
        if ($page == 'home') {
            include 'home.php';
        } elseif ($page == 'mhs') {
            // Halaman Mahasiswa
            $query = "SELECT * FROM mahasiswa";
            $stmt = $db->prepare($query);
            $stmt->execute();
            echo '<h3>Daftar Mahasiswa</h3>';
            echo '<table id="example" class="table table-bordered">';
            echo '<thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Prodi</th><th>Aksi</th></tr></thead>';
            echo '<tbody>';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>" . $row['id'] . "</td><td>" . $row['nama'] . "</td><td>" . $row['email'] . "</td><td>" . $row['prodi_id'] . "</td><td><a href='edit_mhs.php?id=" . $row['id'] . "' class='btn btn-warning'>Edit</a> <a href='delete_mhs.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td></tr>";
            }
            echo '</tbody></table>';
        } elseif ($page == 'prodi') {
            // Halaman Prodi
            $query = "SELECT * FROM prodi";
            $stmt = $db->prepare($query);
            $stmt->execute();
            echo '<h3>Daftar Program Studi</h3>';
            echo '<table id="example" class="table table-bordered">';
            echo '<thead><tr><th>ID</th><th>Nama Prodi</th><th>Aksi</th></tr></thead>';
            echo '<tbody>';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>" . $row['id'] . "</td><td>" . $row['nama_prodi'] . "</td><td><a href='edit_prodi.php?id=" . $row['id'] . "' class='btn btn-warning'>Edit</a> <a href='delete_prodi.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td></tr>";
            }
            echo '</tbody></table>';
        } elseif ($page == 'dosen') {
            // Halaman Dosen
            $query = "SELECT * FROM dosen";
            $stmt = $db->prepare($query);
            $stmt->execute();
            echo '<h3>Daftar Dosen</h3>';
            echo '<table id="example" class="table table-bordered">';
            echo '<thead><tr><th>ID</th><th>Nama Dosen</th><th>Email</th><th>Aksi</th></tr></thead>';
            echo '<tbody>';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>" . $row['id'] . "</td><td>" . $row['nama_dosen'] . "</td><td>" . $row['email'] . "</td><td><a href='edit_dosen.php?id=" . $row['id'] . "' class='btn btn-warning'>Edit</a> <a href='delete_dosen.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td></tr>";
            }
            echo '</tbody></table>';
        } elseif ($page == 'matakuliah') {
            // Halaman Matakuliah
            $query = "SELECT * FROM matakuliah";
            $stmt = $db->prepare($query);
            $stmt->execute();
            echo '<h3>Daftar Matakuliah</h3>';
            echo '<table id="example" class="table table-bordered">';
            echo '<thead><tr><th>ID</th><th>Nama Matakuliah</th><th>Aksi</th></tr></thead>';
            echo '<tbody>';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>" . $row['id'] . "</td><td>" . $row['nama_matakuliah'] . "</td><td><a href='edit_matakuliah.php?id=" . $row['id'] . "' class='btn btn-warning'>Edit</a> <a href='delete_matakuliah.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td></tr>";
            }
            echo '</tbody></table>';
        }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  new DataTable('#example');
</script>
</body>
</html>