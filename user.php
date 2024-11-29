<?php
// Include file koneksi ke database
include 'admin/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dosen</title>
    <!-- Tambahkan referensi CSS untuk tampilan tabel -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    <h2>Data Dosen</h2>
    <table id="example" class="display">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama Dosen</th>
                <th>Email</th>
                <th>No Telp</th>
                <th>Alamat</th>
                <th>Prodi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                // Query untuk mengambil data dosen beserta nama prodi
                $stmt = $db->prepare("SELECT dosen.*, prodi.nama_prodi FROM dosen JOIN prodi ON dosen.prodi_id = prodi.id");
                $stmt->execute(); // Eksekusi query

                $no = 1;

                // Loop untuk menampilkan data dalam tabel
                while ($data_dosen = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$no}</td>
                        <td>" . htmlspecialchars($data_dosen['nip']) . "</td>
                        <td>" . htmlspecialchars($data_dosen['nama_dosen']) . "</td>
                        <td>" . htmlspecialchars($data_dosen['email']) . "</td>
                        <td>" . htmlspecialchars($data_dosen['notelp']) . "</td>
                        <td>" . htmlspecialchars($data_dosen['alamat']) . "</td>
                        <td>" . htmlspecialchars($data_dosen['nama_prodi']) . "</td>
                    </tr>";
                    $no++;
                }
            } catch (PDOException $e) {
                // Penanganan kesalahan
                echo "<tr><td colspan='7'>Terjadi kesalahan: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Tambahkan referensi JavaScript untuk DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        // Inisialisasi DataTables
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>
</html>
