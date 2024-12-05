<?php
include 'admin/koneksi.php';

// Ambil ID berita dari parameter URL
$id_berita = $_GET['id'];

try {
    // Query untuk mengambil data berita berdasarkan ID
    $stmt = $db->prepare("SELECT * FROM berita WHERE id = :id");
    $stmt->bindParam(':id', $id_berita, PDO::PARAM_INT);
    $stmt->execute();
    $berita = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika berita tidak ditemukan, redirect ke halaman utama
    if (!$berita) {
        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($berita['judul']) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1><?= htmlspecialchars($berita['judul']) ?></h1>
        <img src="admin/upload/<?= htmlspecialchars($berita['file_upload']) ?>" alt="<?= htmlspecialchars($berita['judul']) ?>" class="img-fluid mb-3">
        <p><?= nl2br(htmlspecialchars($berita['isi_berita'])) ?></p>
        <a href="index.php" class="btn btn-primary">Kembali ke Daftar Berita</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>