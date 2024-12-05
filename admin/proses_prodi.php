<?php
include 'koneksi.php';

try {
    $proses = isset($_GET['proses']) ? $_GET['proses'] : '';

    if ($proses == 'insert') {
        // Validasi input
        if (empty($_POST['nama_prodi']) || empty($_POST['jenjang_studi'])) {
            throw new Exception("Nama prodi dan jenjang studi harus diisi!");
        }

        // Insert data
        $stmt = $db->prepare("INSERT INTO prodi (nama_prodi, jenjang_studi) 
                             VALUES (:nama_prodi, :jenjang_studi)");

        $stmt->bindParam(':nama_prodi', $_POST['nama_prodi']);
        $stmt->bindParam(':jenjang_studi', $_POST['jenjang_studi']);

        $stmt->execute();

        header("Location: index.php?p=prodi");
        exit();
    } elseif ($proses == 'edit') {
        // Validasi input
        if (empty($_POST['id']) || empty($_POST['nama_prodi']) || empty($_POST['jenjang_studi'])) {
            throw new Exception("Semua field harus diisi!");
        }

        // Update data
        $stmt = $db->prepare("UPDATE prodi SET 
                             nama_prodi = :nama_prodi,
                             jenjang_studi = :jenjang_studi
                             WHERE id = :id");

        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':nama_prodi', $_POST['nama_prodi']);
        $stmt->bindParam(':jenjang_studi', $_POST['jenjang_studi']);

        $stmt->execute();

        header("Location: index.php?p=prodi");
        exit();
    } elseif ($proses == 'delete') {
        // Validasi input
        if (empty($_GET['id'])) {
            throw new Exception("ID tidak valid!");
        }

        // Periksa apakah prodi masih digunakan di tabel lain
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM dosen WHERE prodi_id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            throw new Exception("Prodi tidak dapat dihapus karena masih digunakan oleh data dosen!");
        }

        // Periksa di tabel mahasiswa juga
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM mahasiswa WHERE prodi_id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            throw new Exception("Prodi tidak dapat dihapus karena masih digunakan oleh data mahasiswa!");
        }

        // Delete data jika aman
        $stmt = $db->prepare("DELETE FROM prodi WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        header("Location: index.php?p=prodi");
        exit();
    } else {
        throw new Exception("Proses tidak valid!");
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($e->getMessage()) . "</div>";
    error_log($e->getMessage());
}
