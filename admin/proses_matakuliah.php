<?php
include 'koneksi.php';

try {
    $proses = isset($_GET['proses']) ? $_GET['proses'] : '';

    if ($proses == 'insert') {
        // Validasi input
        if (
            empty($_POST['kode_matakuliah']) || empty($_POST['nama_matakuliah']) ||
            empty($_POST['sks']) || empty($_POST['semester']) ||
            empty($_POST['jenis_mata_kuliah']) || empty($_POST['keterangan'])
        ) {
            var_dump($_POST); // Debugging
            throw new Exception("Semua field harus diisi!");
        }

        // Insert data
        $stmt = $db->prepare("INSERT INTO matakuliah (kode_matakuliah, nama_matakuliah, sks, semester, jenis_matakuliah, keterangan) 
                             VALUES (:kode_matakuliah, :nama_matakuliah, :sks, :semester, :jenis_mata_kuliah, :keterangan)");

        $stmt->bindParam(':kode_matakuliah', $_POST['kode_matakuliah']);
        $stmt->bindParam(':nama_matakuliah', $_POST['nama_matakuliah']);
        $stmt->bindParam(':sks', $_POST['sks']);
        $stmt->bindParam(':semester', $_POST['semester']);
        $stmt->bindParam(':jenis_mata_kuliah', $_POST['jenis_mata_kuliah']);
        $stmt->bindParam(':keterangan', $_POST['keterangan']);

        $stmt->execute();

        header("Location: index.php?p=matakuliah");
        exit();
    } elseif ($proses == 'edit') {
        // Validasi input
        if (
            empty($_POST['id']) || empty($_POST['kode_mk']) ||
            empty($_POST['nama_matakuliah']) || empty($_POST['sks']) ||
            empty($_POST['semester']) || empty($_POST['jenis_matakuliah']) || empty($_POST['keterangan'])
        ) {
            throw new Exception("Semua field harus diisi!");
        }

        // Update data
        $stmt = $db->prepare("UPDATE matakuliah SET 
                             kode_matakuliah = :kode_matakuliah,
                             nama_matakuliah = :nama_matakuliah,
                             sks = :sks,
                             semester = :semester,
                             jenis_matakuliah = :jenis_matakuliah,
                             keterangan = :keterangan
                             WHERE id = :id");

        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':kode_matakuliah', $_POST['kode_matakuliah']);
        $stmt->bindParam(':nama_matakuliah', $_POST['nama_matakuliah']);
        $stmt->bindParam(':sks', $_POST['sks']);
        $stmt->bindParam(':semester', $_POST['semester']);
        $stmt->bindParam(':jenis_matakuliah', $_POST['jenis_matakuliah']);
        $stmt->bindParam(':keterangan', $_POST['keterangan']);

        $stmt->execute();

        header("Location: index.php?p=matakuliah");
        exit();
    } elseif ($proses == 'delete') {
        // Validasi input
        if (empty($_GET['id'])) {
            throw new Exception("ID tidak valid!");
        }

        // Delete data
        $stmt = $db->prepare("DELETE FROM matakuliah WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        header("Location: index.php?p=matakuliah");
        exit();
    } else {
        throw new Exception("Proses tidak valid!");
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($e->getMessage()) . "</div>";
    error_log($e->getMessage());
}
