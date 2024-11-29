<h2>Data Dosen</h2>
<table id="example">
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
        include 'admin/koneksi.php'; // Pastikan file koneksi menggunakan PDO
        $sql = $db->query("SELECT dosen.*, prodi.nama_prodi FROM dosen JOIN prodi ON dosen.prodi_id = prodi.id");
        $no = 1;

        while ($data_dosen = $sql->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $data_dosen['nip'] ?></td>
                <td><?= $data_dosen['nama_dosen'] ?></td>
                <td><?= $data_dosen['email'] ?></td>
                <td><?= $data_dosen['notelp'] ?></td>
                <td><?= $data_dosen['alamat'] ?></td>
                <td><?= $data_dosen['nama_prodi'] ?></td>
            </tr>
        <?php
            $no++;
        }
        ?>
    </tbody>
</table>