<?php
include 'koneksi.php';

try {
    $proses = isset($_GET['proses']) ? $_GET['proses'] : '';

    if ($proses == 'insert') {
        // Validasi input
        if (empty($_POST['nama_level']) || empty($_POST['keterangan'])) {
            throw new Exception("Nama level dan keterangan harus diisi!");
        }

        // Insert data menggunakan prepared statement
        $stmt = $db->prepare("INSERT INTO level (nama_level, keterangan) 
                             VALUES (:nama_level, :keterangan)");

        $stmt->bindParam(':nama_level', $_POST['nama_level']);
        $stmt->bindParam(':keterangan', $_POST['keterangan']);

        $stmt->execute();

        header("Location: index.php?p=level");
        exit();
    } elseif ($proses == 'edit') {
        // Validasi input
        if (empty($_POST['id']) || empty($_POST['nama_level']) || empty($_POST['keterangan'])) {
            throw new Exception("Semua field harus diisi!");
        }

        // Update data menggunakan prepared statement
        $stmt = $db->prepare("UPDATE level SET 
                             nama_level = :nama_level,
                             keterangan = :keterangan
                             WHERE id = :id");

        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':nama_level', $_POST['nama_level']);
        $stmt->bindParam(':keterangan', $_POST['keterangan']);

        $stmt->execute();

        header("Location: index.php?p=level");
        exit();
    } elseif ($proses == 'delete') {
        // Validasi input
        if (empty($_GET['id'])) {
            throw new Exception("ID tidak valid!");
        }

        // Periksa apakah level sedang digunakan di tabel user
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM user WHERE level_id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            throw new Exception("Level tidak dapat dihapus karena sedang digunakan!");
        }

        // Delete data menggunakan prepared statement
        $stmt = $db->prepare("DELETE FROM level WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        header("Location: index.php?p=level");
        exit();
    } else {
        throw new Exception("Proses tidak valid!");
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($e->getMessage()) . "</div>";
    // Log error jika diperlukan
    error_log($e->getMessage());
}
