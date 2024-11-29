<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mata Kuliah</h1>
</div>

<?php
include 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
        <div class="row">
            <div class="col-2 mb-3">
                <a href="index.php?p=matakuliah&aksi=input" class="btn btn-primary"><i class="bi bi-person-plus"></i> Tambah Mata Kuliah</a>
            </div>

            <div class="table-responsive small">
                <table class="table table-bordered">
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $db->query("SELECT * FROM matakuliah");
                        $no = 1;
                        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data['kode_matakuliah'] ?></td>
                                <td><?= $data['nama_matakuliah'] ?></td>
                                <td><?= $data['semester'] ?></td>
                                <td><?= $data['jenis_matakuliah'] ?></td>
                                <td><?= $data['sks'] ?></td>
                                <td><?= $data['jam'] ?></td>
                                <td><?= $data['keterangan'] ?></td>
                                <td>
                                    <a href="index.php?p=matakuliah&aksi=edit&kode=<?= $data['kode_matakuliah'] ?>" class="btn btn-success">Edit</a>
                                    <a href="proses_matakuliah.php?proses=delete&kode_matakuliah=<?= $data['kode_matakuliah'] ?>" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')">Delete</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
        break;

    case 'input':
    ?>

        <div class="row">
            <div class="col-6 mx-auto">
                <br>
                <h2>Form Mata Kuliah</h2>
                <form action="proses_matakuliah.php?proses=insert" method="post">
                    <div class="mb-3">
                        <label class="form-label">Kode MataKuliah</label>
                        <input type="text" class="form-control" name="kode_matakuliah">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama MataKuliah</label>
                        <input type="text" class="form-control" name="nama_matakuliah">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="text" class="form-control" name="semester">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis MataKuliah</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="Teori" name="jenis_matakuliah">
                            <label class="form-check-label">Teori</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="Praktek" name="jenis_matakuliah">
                            <label class="form-check-label">Praktek</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sks</label>
                        <input type="number" class="form-control" name="sks">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam</label>
                        <input type="number" class="form-control" name="jam">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan"></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    <?php
        break;

    case 'edit':
        $query = $db->prepare("SELECT * FROM matakuliah WHERE kode_matakuliah = :kode");
        $query->bindParam(':kode', $_GET['kode']);
        $query->execute();
        $data_matakuliah = $query->fetch(PDO::FETCH_ASSOC);
    ?>

        <div class="row">
            <div class="col-6 mx-auto">
                <br>
                <h2>Edit Mata Kuliah</h2>
                <form action="proses_matakuliah.php?proses=edit" method="post">
                    <div class="mb-3">
                        <label class="form-label">Kode MataKuliah</label>
                        <input type="text" class="form-control" name="kode_matakuliah" value="<?= $data_matakuliah['kode_matakuliah'] ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama MataKuliah</label>
                        <input type="text" class="form-control" name="nama_matakuliah" value="<?= $data_matakuliah['nama_matakuliah'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="text" class="form-control" name="semester" value="<?= $data_matakuliah['semester'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis MataKuliah</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="Teori" name="jenis_matakuliah" <?= ($data_matakuliah['jenis_matakuliah'] == 'Teori') ? 'checked' : '' ?>>
                            <label class="form-check-label">Teori</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="Praktek" name="jenis_matakuliah" <?= ($data_matakuliah['jenis_matakuliah'] == 'Praktek') ? 'checked' : '' ?>>
                            <label class="form-check-label">Praktek</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sks</label>
                        <input type="number" class="form-control" name="sks" value="<?= $data_matakuliah['sks'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam</label>
                        <input type="number" class="form-control" name="jam" value="<?= $data_matakuliah['jam'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" name="keterangan"><?= htmlspecialchars($data_matakuliah['keterangan']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
<?php
        break;
}
?>