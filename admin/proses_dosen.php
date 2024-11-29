<?php
include 'koneksi.php'; // Pastikan koneksi menggunakan PDO

try {
    // Tangkap parameter proses dari URL
    $proses = isset($_GET['proses']) ? $_GET['proses'] : '';

    if ($proses == 'insert') {
        // Validasi input
        if (
            empty($_POST['nik']) || empty($_POST['nama_dosen']) || empty($_POST['email']) ||
            empty($_POST['prodi_id']) || empty($_POST['notelp']) || empty($_POST['alamat'])
        ) {
            throw new Exception("Semua data harus diisi.");
        }

        // Query insert
        $query = $db->prepare("INSERT INTO dosen (nip, nama_dosen, email, prodi_id, notelp, alamat) 
                               VALUES (:nip, :nama_dosen, :email, :prodi_id, :notelp, :alamat)");
        $query->bindParam(':nip', $_POST['nik']);
        $query->bindParam(':nama_dosen', $_POST['nama_dosen']);
        $query->bindParam(':email', $_POST['email']);
        $query->bindParam(':prodi_id', $_POST['prodi_id']);
        $query->bindParam(':notelp', $_POST['notelp']);
        $query->bindParam(':alamat', $_POST['alamat']);
        $query->execute();

        // Redirect setelah sukses
        header('Location: index.php?p=dosen');
        exit();
    } elseif ($proses == 'edit') {
        // Validasi input
        if (
            empty($_POST['id']) || empty($_POST['nik']) || empty($_POST['nama_dosen']) ||
            empty($_POST['email']) || empty($_POST['prodi_id']) || empty($_POST['notelp']) || empty($_POST['alamat'])
        ) {
            throw new Exception("Semua data harus diisi.");
        }

        // Query update
        $query = $db->prepare("UPDATE dosen SET nip = :nip, nama_dosen = :nama_dosen, email = :email, 
                               prodi_id = :prodi_id, notelp = :notelp, alamat = :alamat WHERE id = :id");
        $query->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        $query->bindParam(':nip', $_POST['nik']);
        $query->bindParam(':nama_dosen', $_POST['nama_dosen']);
        $query->bindParam(':email', $_POST['email']);
        $query->bindParam(':prodi_id', $_POST['prodi_id']);
        $query->bindParam(':notelp', $_POST['notelp']);
        $query->bindParam(':alamat', $_POST['alamat']);
        $query->execute();

        // Redirect setelah sukses
        header('Location: index.php?p=dosen');
        exit();
    } elseif ($proses == 'delete') {
        // Validasi input
        if (empty($_GET['id'])) {
            throw new Exception("ID tidak valid.");
        }

        // Query delete
        $query = $db->prepare("DELETE FROM dosen WHERE id = :id");
        $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $query->execute();

        // Redirect setelah sukses
        header('Location: index.php?p=dosen');
        exit();
    } else {
        throw new Exception("Proses tidak valid.");
    }
} catch (Exception $e) {
    // Tampilkan pesan error yang aman untuk pengguna
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    // Log error untuk debugging (opsional)
    // error_log($e->getMessage());
}
