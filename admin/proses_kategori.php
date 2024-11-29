<?php
if ($_GET['proses'] == 'insert') {
    include 'koneksi.php';
    
    try {
       
        $stmt = $dbh->prepare("INSERT INTO kategori (nama_kategori, keterangan) VALUES (:nama_kategori, :keterangan)");
        $stmt->bindParam(':nama_kategori', $_POST['nama_kategori']);
        $stmt->bindParam(':keterangan', $_POST['keterangan']);
        $stmt->execute();

       
        echo "<script>window.location='index.php?p=kategori'</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_GET['proses'] == 'edit') {
    include 'koneksi.php';

    try {
       
        $stmt = $dbh->prepare("UPDATE kategori SET nama_kategori = :nama_kategori, keterangan = :keterangan WHERE id = :id");
        $stmt->bindParam(':nama_kategori', $_POST['nama_kategori']);
        $stmt->bindParam(':keterangan', $_POST['keterangan']);
        $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();

      
        echo "<script>window.location='index.php?p=kategori'</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_GET['proses'] == 'delete') {
    include 'koneksi.php';

    try {
        
        $stmt = $dbh->prepare("DELETE FROM kategori WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

       
        header('Location: index.php?p=kategori');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
