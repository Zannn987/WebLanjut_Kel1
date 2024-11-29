<h2>Data Mahasiswa</h2>
<table id="example" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Email</th>
            <th>No Telp</th>
            <th>Alamat</th>
            <th>Prodi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include 'admin/koneksi.php';

        try {
            // Query untuk mengambil data mahasiswa dan prodi
            $stmt = $db->prepare("SELECT mahasiswa.*, prodi.nama_prodi 
                                  FROM mahasiswa 
                                  JOIN prodi ON mahasiswa.prodi_id = prodi.id");
            $stmt->execute();
            $no = 1;

            // Fetch semua data hasil query
            while ($data_mhs = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= htmlspecialchars($data_mhs['nim']) ?></td>
                    <td><?= htmlspecialchars($data_mhs['nama_mhs']) ?></td>
                    <td><?= htmlspecialchars($data_mhs['email']) ?></td>
                    <td><?= htmlspecialchars($data_mhs['notelp']) ?></td>
                    <td><?= htmlspecialchars($data_mhs['alamat']) ?></td>
                    <td><?= htmlspecialchars($data_mhs['nama_prodi']) ?></td>
                </tr>
        <?php
                $no++;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </tbody>
</table>