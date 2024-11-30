<h1>Berita</h1>

<div class="row">
    <?php
    include 'admin/koneksi.php';
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    
    switch ($status) {
        default:
            try {
              
                $stmt = $dbh->prepare("SELECT * FROM berita ORDER BY id DESC LIMIT 6");
                $stmt->execute();
                $beritaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($beritaList as $berita) {
    ?>
                <div class="col-4 mb-3">
                    <div class="card">
                        <img src="admin/upload/<?= htmlspecialchars($berita['file_upload']) ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($berita['judul']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars(substr($berita['isi_berita'], 0, 100)) ?></p>
                            <a href="?p=home&status=detail&id=<?= $berita['id'] ?>" class="btn btn-primary">Readmore</a>
                        </div>
                    </div>
                </div>
    <?php
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            break;

        case "detail":
            try {
              
                $stmt = $dbh->prepare("SELECT * FROM berita WHERE id = :id");
                $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
                $stmt->execute();
                $berita = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($berita) {
    ?>
                <div class="col-4 mb-3">
                    <div class="card">
                        <img src="admin/upload/<?= htmlspecialchars($berita['file_upload']) ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($berita['judul']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($berita['isi_berita']) ?></p>
                            <a href="#" onclick="history.go(-1)" class="btn btn-primary">Back</a>
                        </div>
                    </div>
                </div>
    <?php
                } else {
                    echo "<p>Berita tidak ditemukan.</p>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            break;
    }
    ?>
</div>
