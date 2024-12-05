<h1>Berita</h1>

<div class="row">
    <?php
    include 'admin/koneksi.php';  // Pastikan file koneksi.php menggunakan PDO

    $status = isset($_GET['status']) ? $_GET['status'] : '';

    // Menggunakan PDO untuk koneksi dan query
    try {
        switch ($status) {
            case "detail":
                // Tampilkan berita lengkap sesuai dengan ID
                $stmt = $db->prepare("SELECT * FROM berita WHERE id = :id");
                $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
                $stmt->execute();
                $berita = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
                <div class="col-12 mb-3">
                    <div class="card">
                        <img src="admin/upload/<?= $berita['file_upload'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($berita['judul']) ?></h5>
                            <!-- Tampilkan seluruh isi berita -->
                            <p class="card-text"><?= htmlspecialchars($berita['isi_berita']) ?></p>
                            <a href="?p=home" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
                <?php
                break;

            default:
                // Tampilkan cuplikan berita dengan tombol "Read More"
                $stmt = $db->query("SELECT * FROM berita ORDER BY id DESC LIMIT 6");
                while ($berita = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <div class="col-4 mb-3">
                        <div class="card">
                            <img src="admin/upload/<?= $berita['file_upload'] ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($berita['judul']) ?></h5>
                                <!-- Tampilkan cuplikan isi berita -->
                                <p class="card-text"><?= substr(htmlspecialchars($berita['isi_berita']), 0, 200) ?>...</p>
                                <!-- Link ke berita lengkap -->
                                <a href="?p=home&status=detail&id=<?= $berita['id'] ?>" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
    <?php
                }
                break;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</div>