<?php
include 'koneksi.php'; // Pastikan koneksi database sudah benar

$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

if ($proses === 'insert') {
    // Ambil data dari form
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $level_id = $_POST['level_id'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $photo = '';

    // Proses upload photo jika ada
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "upload/";
        $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $photo = uniqid() . '.' . $file_extension; // Generate unique filename
        $target_file = $target_dir . $photo;
        
        // Validasi file adalah gambar
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array(strtolower($file_extension), $allowed_types)) {
            move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        } else {
            die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
        }
    }

    // Simpan data ke database
    $stmt = $db->prepare("INSERT INTO user (email, password, level_id, nama_lengkap, notelp, photo, alamat) 
                          VALUES (:email, :password, :level_id, :nama_lengkap, :notelp, :photo, :alamat)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':level_id', $level_id);
    $stmt->bindParam(':nama_lengkap', $nama_lengkap);
    $stmt->bindParam(':notelp', $notelp);
    $stmt->bindParam(':photo', $photo);
    $stmt->bindParam(':alamat', $alamat);

    if ($stmt->execute()) {
        header("Location: index.php?p=user&aksi=list");
    } else {
        echo "Error: Data gagal disimpan.";
    }

} elseif ($proses === 'edit') {
    // Ambil data dari form
    $id = $_POST['id'];
    $email = $_POST['email'];
    $level_id = $_POST['level_id'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // Set query awal
    $query = "UPDATE user SET 
              email = :email,
              level_id = :level_id,
              nama_lengkap = :nama_lengkap,
              notelp = :notelp,
              alamat = :alamat";

    // Tambahkan password jika diisi
    if ($password) {
        $query .= ", password = :password";
    }

    // Proses upload photo jika ada
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "upload/";
        $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $photo = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $photo;
        
        // Validasi file adalah gambar
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array(strtolower($file_extension), $allowed_types)) {
            // Hapus foto lama jika ada
            $stmt_old_photo = $db->prepare("SELECT photo FROM user WHERE id = :id");
            $stmt_old_photo->bindParam(':id', $id);
            $stmt_old_photo->execute();
            $old_photo = $stmt_old_photo->fetch(PDO::FETCH_ASSOC)['photo'];
            if ($old_photo && file_exists("upload/" . $old_photo)) {
                unlink("upload/" . $old_photo);
            }
            
            move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
            $query .= ", photo = :photo";
        } else {
            die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
        }
    }

    $query .= " WHERE id = :id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':level_id', $level_id);
    $stmt->bindParam(':nama_lengkap', $nama_lengkap);
    $stmt->bindParam(':notelp', $notelp);
    $stmt->bindParam(':alamat', $alamat);
    $stmt->bindParam(':id', $id);

    if ($password) {
        $stmt->bindParam(':password', $password);
    }
    if (isset($photo)) {
        $stmt->bindParam(':photo', $photo);
    }

    if ($stmt->execute()) {
        header("Location: index.php?p=user&aksi=list");
    } else {
        echo "Error: Data gagal diubah.";
    }

} elseif ($proses === 'delete') {
    $id = $_GET['id'];

    // Hapus photo jika ada
    $stmt = $db->prepare("SELECT photo FROM user WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $photo = $stmt->fetch(PDO::FETCH_ASSOC)['photo'];
    
    if ($photo && file_exists("upload/" . $photo)) {
        unlink("upload/" . $photo);
    }

    // Hapus data dari database
    $stmt = $db->prepare("DELETE FROM user WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: index.php?p=user&aksi=list");
    } else {
        echo "Error: Data gagal dihapus.";
    }
}
?>