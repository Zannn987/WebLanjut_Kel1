<?php
include 'koneksi.php';

try {
    $proses = isset($_GET['proses']) ? $_GET['proses'] : '';

    if ($proses == 'insert') {
        // Validasi input
        if (
            empty($_POST['email']) || empty($_POST['password']) ||
            empty($_POST['level_id']) || empty($_POST['nama_lengkap']) ||
            empty($_POST['notelp']) || empty($_POST['alamat'])
        ) {
            throw new Exception("Semua field harus diisi!");
        }

        // Hash password
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $photo = '';

        // Handle file upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $file_ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

            if (!in_array($file_ext, $allowed)) {
                throw new Exception("Format file tidak diizinkan!");
            }

            $photo = uniqid() . '.' . $file_ext;
            $upload_path = "upload/" . $photo;

            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
                throw new Exception("Gagal mengupload file!");
            }
        }

        // Insert data
        $stmt = $db->prepare("INSERT INTO user (email, password, level_id, nama_lengkap, notelp, alamat, photo) 
                             VALUES (:email, :password, :level_id, :nama_lengkap, :notelp, :alamat, :photo)");

        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':level_id', $_POST['level_id']);
        $stmt->bindParam(':nama_lengkap', $_POST['nama_lengkap']);
        $stmt->bindParam(':notelp', $_POST['notelp']);
        $stmt->bindParam(':alamat', $_POST['alamat']);
        $stmt->bindParam(':photo', $photo);

        $stmt->execute();

        header("Location: index.php?p=user");
        exit();
    } elseif ($proses == 'edit') {
        // Validasi input
        if (
            empty($_POST['id']) || empty($_POST['email']) ||
            empty($_POST['level_id']) || empty($_POST['nama_lengkap']) ||
            empty($_POST['notelp']) || empty($_POST['alamat'])
        ) {
            throw new Exception("Semua field harus diisi!");
        }

        // Ambil data user lama
        $stmt = $db->prepare("SELECT photo FROM user WHERE id = :id");
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->execute();
        $old_data = $stmt->fetch(PDO::FETCH_ASSOC);

        $photo = $old_data['photo'];

        // Handle file upload jika ada
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $file_ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

            if (!in_array($file_ext, $allowed)) {
                throw new Exception("Format file tidak diizinkan!");
            }

            // Hapus foto lama jika ada
            if ($old_data['photo'] && file_exists("upload/" . $old_data['photo'])) {
                unlink("upload/" . $old_data['photo']);
            }

            $photo = uniqid() . '.' . $file_ext;
            $upload_path = "upload/" . $photo;

            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
                throw new Exception("Gagal mengupload file!");
            }
        }

        // Update data
        $sql = "UPDATE user SET 
                email = :email,
                level_id = :level_id,
                nama_lengkap = :nama_lengkap,
                notelp = :notelp,
                alamat = :alamat,
                photo = :photo";

        // Tambahkan password ke query jika diisi
        if (!empty($_POST['password'])) {
            $sql .= ", password = :password";
        }

        $sql .= " WHERE id = :id";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':level_id', $_POST['level_id']);
        $stmt->bindParam(':nama_lengkap', $_POST['nama_lengkap']);
        $stmt->bindParam(':notelp', $_POST['notelp']);
        $stmt->bindParam(':alamat', $_POST['alamat']);
        $stmt->bindParam(':photo', $photo);

        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $password);
        }

        $stmt->execute();

        header("Location: index.php?p=user");
        exit();
    } elseif ($proses == 'delete') {
        // Validasi input
        if (empty($_GET['id'])) {
            throw new Exception("ID tidak valid!");
        }

        // Ambil info foto sebelum menghapus
        $stmt = $db->prepare("SELECT photo FROM user WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Hapus foto jika ada
        if ($data['photo'] && file_exists("upload/" . $data['photo'])) {
            unlink("upload/" . $data['photo']);
        }

        // Delete data
        $stmt = $db->prepare("DELETE FROM user WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        header("Location: index.php?p=user");
        exit();
    } else {
        throw new Exception("Proses tidak valid!");
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($e->getMessage()) . "</div>";
    error_log($e->getMessage());
}
