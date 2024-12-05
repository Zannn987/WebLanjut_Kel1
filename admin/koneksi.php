<?php
$host = 'localhost';
$dbname = 'web_lanjut_kel_1'; // Sesuai dengan nama database di gambar
$username = 'root';
$password = '';

try {
    // Membuat koneksi PDO
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mengaktifkan mode error exception
} catch (PDOException $e) {
    // Menampilkan pesan error jika koneksi gagal
    die("Koneksi gagal: " . $e->getMessage());
}
