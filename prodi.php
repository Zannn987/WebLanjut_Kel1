<h2>Data Prodi</h2>
<table id="example" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Prodi</th>
            <th>Jenjang Studi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include 'admin/koneksi.php';

        try {
           
            $stmt = $dbh->prepare("SELECT * FROM prodi");
            $stmt->execute();
            $prodi = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $no = 1;

            foreach ($prodi as $data) {
        ?>
        <tr>
            <td><?= $no ?></td>
            <td><?= htmlspecialchars($data['nama_prodi']) ?></td>
            <td><?= htmlspecialchars($data['jenjang_studi']) ?></td>
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
