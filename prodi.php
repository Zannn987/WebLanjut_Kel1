<h2>Data Prodi</h2>
<table id="example">
    <thead>
        <tr>
            <th>No</th>
            <th>Id Prodi</th>
            <th>Nama Prodi</th>
            <th>Jenjang Prodi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include 'admin/koneksi.php';
        $prodi = $db->query("SELECT * FROM prodi");
        $no = 1;
        while ($data_prodi = $prodi->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $data_prodi['id'] ?></td>
                <td><?= $data_prodi['nama_prodi'] ?></td>
                <td><?= $data_prodi['jenjang_studi'] ?></td>
            </tr>
        <?php
            $no++;
        }
        ?>
    </tbody>
</table>