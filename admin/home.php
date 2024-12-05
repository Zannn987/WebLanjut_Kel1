<?php
include 'koneksi.php'; // Pastikan koneksi PDO tersedia

try {
    // Mengambil statistik dari database
    $stmt_dosen = $db->query("SELECT COUNT(*) as total_dosen FROM dosen");
    $stmt_mhs = $db->query("SELECT COUNT(*) as total_mhs FROM mahasiswa");
    $stmt_prodi = $db->query("SELECT COUNT(*) as total_prodi FROM prodi");
    $stmt_berita = $db->query("SELECT COUNT(*) as total_berita FROM berita");

    $total_dosen = $stmt_dosen->fetch(PDO::FETCH_ASSOC)['total_dosen'];
    $total_mhs = $stmt_mhs->fetch(PDO::FETCH_ASSOC)['total_mhs'];
    $total_prodi = $stmt_prodi->fetch(PDO::FETCH_ASSOC)['total_prodi'];
    $total_berita = $stmt_berita->fetch(PDO::FETCH_ASSOC)['total_berita'];
?>

    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
        </div>

        <div class="row">
            <!-- Dosen Card -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $total_dosen ?></h3>
                        <p>Total Dosen</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="index.php?p=dosen" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Mahasiswa Card -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $total_mhs ?></h3>
                        <p>Total Mahasiswa</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <a href="index.php?p=mhs" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Prodi Card -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $total_prodi ?></h3>
                        <p>Program Studi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <a href="index.php?p=prodi" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Berita Card -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $total_berita ?></h3>
                        <p>Total Berita</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <a href="index.php?p=berita" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Welcome to TI Department</h3>
                    </div>
                    <div class="card-body">
                        <p class="lead">
                            Selamat datang di Sistem Informasi Jurusan Teknologi Informasi.
                            Sistem ini menyediakan informasi tentang dosen, mahasiswa, program studi,
                            dan berita terkini seputar jurusan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>