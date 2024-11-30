<?php
include 'koneksi.php'; // Pastikan koneksi database sudah benar

$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

if ($proses === 'insert') {
    // Ambil data dari form
    $judul = $_POST['judul'];
    $kategori_id = $_POST['kategori_id'];
    $isi_berita = $_POST['isi_berita'];
    $file_upload = '';

    // Proses upload file jika ada
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
        $target_dir = "upload/";
        $file_upload = basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . $file_upload;
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }

    // Simpan data ke database
    $query = "INSERT INTO berita (judul, kategori_id, isi_berita, file_upload, user_id, created_at) VALUES (:judul, :kategori_id, :isi_berita, :file_upload, :user_id, NOW())";
    $stmt = $db->prepare($query);

    try {
        $stmt->execute([
            ':judul' => $judul,
            ':kategori_id' => $kategori_id,
            ':isi_berita' => $isi_berita,
            ':file_upload' => $file_upload,
            ':user_id' => 1 // Ganti 1 dengan ID user yang sesuai
        ]);
        header("Location: index.php?p=berita&aksi=list");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

} elseif ($proses === 'edit') {
    // Ambil data dari form
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $kategori_id = $_POST['kategori_id'];
    $isi_berita = $_POST['isi_berita'];
    $file_upload = '';

    // Proses upload file jika ada
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
        $target_dir = "upload/";
        $file_upload = basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . $file_upload;
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }

    // Update data ke database
    if ($file_upload) {
        $query = "UPDATE berita SET judul = :judul, kategori_id = :kategori_id, isi_berita = :isi_berita, file_upload = :file_upload WHERE id = :id";
    } else {
        $query = "UPDATE berita SET judul = :judul, kategori_id = :kategori_id, isi_berita = :isi_berita WHERE id = :id";
    }

    $stmt = $db->prepare($query);

    try {
        $stmt->execute([
            ':judul' => $judul,
            ':kategori_id' => $kategori_id,
            ':isi_berita' => $isi_berita,
            ':file_upload' => $file_upload,
            ':id' => $id
        ]);
        header("Location: index.php?p=berita&aksi=list");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

} elseif ($proses === 'delete') {
    $id = $_GET['id'];
    $file = $_GET['file'];

    // Hapus file jika ada
    if ($file) {
        unlink("upload/" . $file);
    }

    // Hapus data dari database
    $query = "DELETE FROM berita WHERE id = :id";
    $stmt = $db->prepare($query);

    try {
        $stmt->execute([':id' => $id]);
        header("Location: index.php?p=berita&aksi=list");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>