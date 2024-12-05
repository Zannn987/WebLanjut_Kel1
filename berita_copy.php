<?php
include 'admin/koneksi.php'; // Pastikan koneksi menggunakan PDO

$id = $_GET['id']; // Asumsi ID berita dikirim melalui URL

try {
    // Query untuk mengambil data berita berdasarkan ID
    $stmt = $db->prepare("SELECT * FROM berita WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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

<h1><?= htmlspecialchars($berita['judul']) ?></h1>
<img src="<?= htmlspecialchars($berita['file_upload']) ?>" alt="<?= htmlspecialchars($berita['judul']) ?>">
<p><?= nl2br(htmlspecialchars($berita['isi_berita'])) ?></p>