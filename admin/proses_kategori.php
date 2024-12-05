<?php
include 'koneksi.php';

try {
    $proses = isset($_GET['proses']) ? $_GET['proses'] : '';

    if ($proses == 'insert') {
        // Validasi input
        if (empty($_POST['nama_kategori']) || empty($_POST['keterangan'])) {
            throw new Exception("Nama kategori dan keterangan harus diisi!");
        }

        // Insert data menggunakan prepared statement
        $stmt = $db->prepare("INSERT INTO kategori (nama_kategori, keterangan) 
                             VALUES (:nama_kategori, :keterangan)");

        $stmt->bindParam(':nama_kategori', $_POST['nama_kategori']);
        $stmt->bindParam(':keterangan', $_POST['keterangan']);

        $stmt->execute();

        header("Location: index.php?p=kategori");
        exit();
    } elseif ($proses == 'edit') {
        // Validasi input
        if (empty($_POST['id']) || empty($_POST['nama_kategori']) || empty($_POST['keterangan'])) {
            throw new Exception("Semua field harus diisi!");
        }

        // Update data menggunakan prepared statement
        $stmt = $db->prepare("UPDATE kategori SET 
                             nama_kategori = :nama_kategori,
                             keterangan = :keterangan
                             WHERE id = :id");

        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':nama_kategori', $_POST['nama_kategori']);
        $stmt->bindParam(':keterangan', $_POST['keterangan']);

        $stmt->execute();

        header("Location: index.php?p=kategori");
        exit();
    } elseif ($proses == 'delete') {
        // Validasi input
        if (empty($_GET['id'])) {
            throw new Exception("ID tidak valid!");
        }

        // Delete data menggunakan prepared statement
        $stmt = $db->prepare("DELETE FROM kategori WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        header("Location: index.php?p=kategori");
        exit();
    } else {
        throw new Exception("Proses tidak valid!");
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($e->getMessage()) . "</div>";
    // Log error jika diperlukan
    error_log($e->getMessage());
}
