<h2>Data Mata Kuliah</h2>
<table id="example">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Matakuliah</th>
            <th>Nama Matakuliah</th>
            <th>Semester</th>
            <th>Jenis Matakuliah</th>
            <th>Sks</th>
            <th>Jam</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include 'admin/koneksi.php'; // Pastikan file koneksi menggunakan PDO

        // Menyiapkan query untuk mengambil data dari matakuliah
        $sql = $db->query("SELECT * FROM matakuliah");

        // Inisialisasi variabel untuk nomor urut
        $no = 1;

        // Menampilkan data dengan PDO
        while ($data_matakuliah = $sql->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $data_matakuliah['kode_matakuliah'] ?></td>
                <td><?= $data_matakuliah['nama_matakuliah'] ?></td>
                <td><?= $data_matakuliah['semester'] ?></td>
                <td><?= $data_matakuliah['jenis_matakuliah'] ?></td>
                <td><?= $data_matakuliah['sks'] ?></td>
                <td><?= $data_matakuliah['jam'] ?></td>
                <td><?= $data_matakuliah['keterangan'] ?></td>
            </tr>
        <?php
            $no++;
        }
        ?>
    </tbody>
</table>