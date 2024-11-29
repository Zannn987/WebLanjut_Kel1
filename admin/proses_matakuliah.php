<?php
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    // Proses insert data mata kuliah
    $sql = $db->prepare("INSERT INTO matakuliah (kode_matakuliah, nama_matakuliah, semester, jenis_matakuliah, sks, jam, keterangan) 
                         VALUES (:kode_matakuliah, :nama_matakuliah, :semester, :jenis_matakuliah, :sks, :jam, :keterangan)");
    $sql->bindParam(':kode_matakuliah', $_POST['kode_matakuliah']);
    $sql->bindParam(':nama_matakuliah', $_POST['nama_matakuliah']);
    $sql->bindParam(':semester', $_POST['semester']);
    $sql->bindParam(':jenis_matakuliah', $_POST['jenis_matakuliah']);
    $sql->bindParam(':sks', $_POST['sks']);
    $sql->bindParam(':jam', $_POST['jam']);
    $sql->bindParam(':keterangan', $_POST['keterangan']);

    if ($sql->execute()) {
        echo "<script>window.location='index.php?p=matakuliah'</script>";
    } else {
        echo "Error: " . $sql->errorInfo()[2];
    }
}

if ($_GET['proses'] == 'edit') {
    // Proses update data mata kuliah
    $sql = $db->prepare("UPDATE matakuliah SET 
                            nama_matakuliah = :nama_matakuliah,
                            semester = :semester,
                            jenis_matakuliah = :jenis_matakuliah,
                            sks = :sks,
                            jam = :jam,
                            keterangan = :keterangan
                         WHERE kode_matakuliah = :kode_matakuliah");
    $sql->bindParam(':kode_matakuliah', $_POST['kode_matakuliah']);
    $sql->bindParam(':nama_matakuliah', $_POST['nama_matakuliah']);
    $sql->bindParam(':semester', $_POST['semester']);
    $sql->bindParam(':jenis_matakuliah', $_POST['jenis_matakuliah']);
    $sql->bindParam(':sks', $_POST['sks']);
    $sql->bindParam(':jam', $_POST['jam']);
    $sql->bindParam(':keterangan', $_POST['keterangan']);

    if ($sql->execute()) {
        echo "<script>window.location='index.php?p=matakuliah'</script>";
    } else {
        echo "Error: " . $sql->errorInfo()[2];
    }
}

if ($_GET['proses'] == 'delete') {
    // Proses delete data mata kuliah
    $sql = $db->prepare("DELETE FROM matakuliah WHERE kode_matakuliah = :kode_matakuliah");
    $sql->bindParam(':kode_matakuliah', $_GET['kode_matakuliah']);

    if ($sql->execute()) {
        header('location:index.php?p=matakuliah');
    } else {
        echo "Error: " . $sql->errorInfo()[2];
    }
}
