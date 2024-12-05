<?php
include 'koneksi.php';

try {
    $proses = isset($_GET['proses']) ? $_GET['proses'] : '';

    if ($proses == 'insert') {
        // Validasi input
        if (
            empty($_POST['nip']) || empty($_POST['nama_dosen']) ||
            empty($_POST['email']) || empty($_POST['prodi_id']) ||
            empty($_POST['notelp']) || empty($_POST['alamat'])
        ) {
            throw new Exception("Semua field harus diisi!");
        }

        // Insert data menggunakan prepared statement
        $stmt = $db->prepare("INSERT INTO dosen (nip, nama_dosen, email, prodi_id, notelp, alamat) 
                             VALUES (:nip, :nama_dosen, :email, :prodi_id, :notelp, :alamat)");

        $stmt->bindParam(':nip', $_POST['nip']);
        $stmt->bindParam(':nama_dosen', $_POST['nama_dosen']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':prodi_id', $_POST['prodi_id']);
        $stmt->bindParam(':notelp', $_POST['notelp']);
        $stmt->bindParam(':alamat', $_POST['alamat']);

        $stmt->execute();

        header("Location: index.php?p=dosen");
        exit();
    } elseif ($proses == 'edit') {
        // Validasi input
        if (
            empty($_POST['id']) || empty($_POST['nip']) ||
            empty($_POST['nama_dosen']) || empty($_POST['email']) ||
            empty($_POST['prodi_id']) || empty($_POST['notelp']) ||
            empty($_POST['alamat'])
        ) {
            throw new Exception("Semua field harus diisi!");
        }

        // Update data menggunakan prepared statement
        $stmt = $db->prepare("UPDATE dosen SET 
                             nip = :nip,
                             nama_dosen = :nama_dosen,
                             email = :email,
                             prodi_id = :prodi_id,
                             notelp = :notelp,
                             alamat = :alamat
                             WHERE id = :id");

        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':nip', $_POST['nip']);
        $stmt->bindParam(':nama_dosen', $_POST['nama_dosen']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':prodi_id', $_POST['prodi_id']);
        $stmt->bindParam(':notelp', $_POST['notelp']);
        $stmt->bindParam(':alamat', $_POST['alamat']);

        $stmt->execute();

        header("Location: index.php?p=dosen");
        exit();
    } elseif ($proses == 'delete') {
        // Validasi input
        if (empty($_GET['id'])) {
            throw new Exception("ID tidak valid!");
        }

        // Delete data menggunakan prepared statement
        $stmt = $db->prepare("DELETE FROM dosen WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        header("Location: index.php?p=dosen");
        exit();
    } else {
        throw new Exception("Proses tidak valid!");
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($e->getMessage()) . "</div>";
    // Log error jika diperlukan
    error_log($e->getMessage());
}
