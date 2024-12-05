<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi menggunakan PDO

$target_dir = "upload/";
$nama_file = rand() . '_' . basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $nama_file; // Perbaikan pada nama file
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['submit'])) {
        echo "Proses insert dimulai<br>"; // Debugging
        // Cek apakah file yang diupload adalah gambar
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.<br>";
            $uploadOk = 0;
        }

        // Cek apakah file sudah ada
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.<br>";
            $uploadOk = 0;
        }

        // Cek ukuran file
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.<br>";
            $uploadOk = 0;
        }

        // Hanya izinkan format file tertentu
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            $uploadOk = 0;
        }

        // Jika tidak ada error, proses upload file
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "File berhasil diupload<br>"; // Debugging
                // Query insert berita
                $stmt = $db->prepare("INSERT INTO berita (user_id, kategori_id, judul, file_upload, isi_berita) VALUES (:user_id, :kategori_id, :judul, :file_upload, :isi_berita)");
                $stmt->bindParam(':user_id', $_SESSION['user_id']);
                $stmt->bindParam(':kategori_id', $_POST['kategori_id']);
                $stmt->bindParam(':judul', $_POST['judul']);
                $stmt->bindParam(':file_upload', $nama_file);
                $stmt->bindParam(':isi_berita', $_POST['isi_berita']);

                if ($stmt->execute()) {
                    echo "Data berhasil disimpan<br>"; // Debugging
                    header("Location: index.php?p=berita");
                    exit();
                } else {
                    echo "Error: " . $stmt->errorInfo()[2] . "<br>"; // Debugging
                }
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        }
    } else {
        echo "Tombol submit tidak terdeteksi.<br>"; // Debugging
    }
}

if ($_GET['proses'] == 'edit') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $kategori_id = $_POST['kategori_id'];
    $isi_berita = $_POST['isi_berita'];

    if ($_FILES['fileToUpload']['name'] != "") {
        $target_dir = "upload/";
        $nama_file = rand() . '_' . basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . $nama_file;
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        $file_upload = $nama_file;
    } else {
        $file_upload = $_POST['old_file'];
    }

    $stmt = $db->prepare("UPDATE berita SET judul = :judul, kategori_id = :kategori_id, isi_berita = :isi_berita, file_upload = :file_upload WHERE id = :id");
    $stmt->bindParam(':judul', $judul);
    $stmt->bindParam(':kategori_id', $kategori_id);
    $stmt->bindParam(':isi_berita', $isi_berita);
    $stmt->bindParam(':file_upload', $file_upload);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: index.php?p=berita");
        exit();
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

if ($_GET['proses'] == 'delete') {
    // Hapus file fisik di folder
    unlink('upload/' . $_GET['file']); // Menghapus image pada upload

    // Hapus data dari database
    $stmt = $db->prepare("DELETE FROM berita WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id']);

    if ($stmt->execute()) {
        header('Location: index.php?p=berita');
        exit();
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
