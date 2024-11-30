<?php
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    try {
        $stmt = $dbh->prepare("INSERT INTO prodi (nama_prodi, jenjang_studi) VALUES (:nama_prodi, :jenjang_studi)");
        $stmt->bindParam(':nama_prodi', $_POST['nama_prodi']);
        $stmt->bindParam(':jenjang_studi', $_POST['jenjang_studi']);
        $stmt->execute();

        echo "<script>window.location='index.php?p=prodi'</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_GET['proses'] == 'edit') {
    try {
        $stmt = $dbh->prepare("UPDATE prodi SET 
            nama_prodi = :nama_prodi, 
            jenjang_studi = :jenjang_studi 
            WHERE id = :id");

        $stmt->bindParam(':nama_prodi', $_POST['nama_prodi']);
        $stmt->bindParam(':jenjang_studi', $_POST['jenjang_studi']);
        $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();

        echo "<script>window.location='index.php?p=prodi'</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $stmt = $dbh->prepare("DELETE FROM prodi WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        header('location:index.php?p=prodi'); // redirect
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
