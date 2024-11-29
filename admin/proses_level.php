<?php
include 'koneksi.php'; // Pastikan koneksi PDO digunakan

try {
    if ($_GET['proses'] == 'insert') {
        // Validasi input
        if (empty($_POST['nama_level']) || empty($_POST['keterangan'])) {
            throw new Exception("Nama level dan keterangan tidak boleh kosong.");
        }

        // Query insert
        $query = $db->prepare("INSERT INTO level (nama_level, keterangan) VALUES (:nama_level, :keterangan)");
        $query->bindParam(':nama_level', $_POST['nama_level']);
        $query->bindParam(':keterangan', $_POST['keterangan']);
        $query->execute();

        // Redirect
        header("Location: index.php?p=level");
        exit();
    } elseif ($_GET['proses'] == 'edit') {
        // Validasi input
        if (empty($_POST['nama_level']) || empty($_POST['keterangan']) || empty($_POST['id'])) {
            throw new Exception("Semua data harus diisi.");
        }

        // Query update
        $query = $db->prepare("UPDATE level SET nama_level = :nama_level, keterangan = :keterangan WHERE id = :id");
        $query->bindParam(':nama_level', $_POST['nama_level']);
        $query->bindParam(':keterangan', $_POST['keterangan']);
        $query->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        $query->execute();

        // Redirect
        header("Location: index.php?p=level");
        exit();
    } elseif ($_GET['proses'] == 'delete') {
        // Validasi input ID
        if (empty($_GET['id'])) {
            throw new Exception("ID tidak valid.");
        }

        // Query delete
        $query = $db->prepare("DELETE FROM level WHERE id = :id");
        $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $query->execute();

        // Redirect
        header("Location: index.php?p=level");
        exit();
    } else {
        throw new Exception("Proses tidak valid.");
    }
} catch (Exception $e) {
    // Menampilkan pesan error (hindari menampilkan error sensitif ke user langsung)
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    // Log error (opsional, untuk debugging)
    // error_log($e->getMessage());
}
