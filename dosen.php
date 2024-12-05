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
        include 'admin/koneksi.php';

        try {
            // Query untuk mengambil data dosen dan prodi
            $stmt = $db->prepare("SELECT dosen.*, prodi.nama_prodi 
                                  FROM dosen 
                                  JOIN prodi ON dosen.prodi_id = prodi.id");
            $stmt->execute();
            $no = 1;

            // Fetch semua data hasil query
            while ($data_dosen = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= htmlspecialchars($data_dosen['nip']) ?></td>
                    <td><?= htmlspecialchars($data_dosen['nama_dosen']) ?></td>
                    <td><?= htmlspecialchars($data_dosen['email']) ?></td>
                    <td><?= htmlspecialchars($data_dosen['notelp']) ?></td>
                    <td><?= htmlspecialchars($data_dosen['alamat']) ?></td>
                    <td><?= htmlspecialchars($data_dosen['nama_prodi']) ?></td>
                </tr>
        <?php
                $no++;
            }
        } catch (PDOException $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
        ?>
    </tbody>
</table>