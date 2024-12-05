<?php
include 'koneksi.php'; // Pastikan koneksi menggunakan PDO
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
        <div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
            <section class="content-header">
                <h1>Data Mata Kuliah</h1>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-2">
                            <a href="index.php?p=matakuliah&aksi=input" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Mata Kuliah
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered table-striped" id="example1">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode MK</th>
                                                <th>Nama Mata Kuliah</th>
                                                <th>SKS</th>
                                                <th>Semester</th>
                                                <th>Jenis Mata Kuliah</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            try {
                                                $stmt = $db->prepare("SELECT * FROM matakuliah");
                                                $stmt->execute();
                                                $no = 1;
                                                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                    <tr>
                                                        <td><?= $no ?></td>
                                                        <td><?= htmlspecialchars($data['kode_matakuliah']) ?></td>
                                                        <td><?= htmlspecialchars($data['nama_matakuliah']) ?></td>
                                                        <td><?= htmlspecialchars($data['sks']) ?></td>
                                                        <td><?= htmlspecialchars($data['semester']) ?></td>
                                                        <td><?= htmlspecialchars($data['jenis_matakuliah']) ?></td>
                                                        <td><?= htmlspecialchars($data['keterangan']) ?></td>
                                                        <td>
                                                            <a href="index.php?p=matakuliah&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success btn-sm">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <a href="proses_matakuliah.php?proses=delete&id=<?= $data['id'] ?>"
                                                                class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data?')">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </a>
                                                        </td>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <?php
        break;

    case 'input':
    ?>
        <div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
            <section class="content-header">
                <h1>Input Mata Kuliah</h1>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Form Input Mata Kuliah</h3>
                        </div>
                        <form action="proses_matakuliah.php?proses=insert" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="kode_matakuliah">Kode MK</label>
                                    <input type="text" class="form-control" name="kode_matakuliah" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_matakuliah">Nama Mata Kuliah</label>
                                    <input type="text" class="form-control" name="nama_matakuliah" required>
                                </div>
                                <div class="form-group">
                                    <label for="sks">SKS</label>
                                    <input type="text" class="form-control" name="sks" required>
                                </div>
                                <div class="form-group">
                                    <label for="semester">Semester</label>
                                    <input type="text" class="form-control" name="semester">
                                </div>
                                <div class="form-group">
                                    <label for="jenis_mata_kuliah">Jenis Mata Kuliah</label>
                                    <select name="jenis_mata_kuliah" class="form-control" required>
                                        <option value="">Pilih Jenis Mata Kuliah</option>
                                        <option value="Teori">Teori</option>
                                        <option value="Praktikum">Praktikum</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" class="form-control" name="keterangan" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <?php
        break;

    case 'edit':
        try {
            $stmt = $db->prepare("SELECT * FROM matakuliah WHERE id = :id");
            $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
            <div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
                <section class="content-header">
                    <h1>Edit Mata Kuliah</h1>
                </section>
                <section class="content">
                    <div class="container-fluid">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Form Edit Mata Kuliah</h3>
                            </div>
                            <form action="proses_matakuliah.php?proses=edit" method="post">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="kode_matakuliah">Kode MK</label>
                                        <input type="text" class="form-control" name="kode_matakuliah" value="<?= htmlspecialchars($data['kode_matakuliah']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_matakuliah">Nama Mata Kuliah</label>
                                        <input type="text" class="form-control" name="nama_matakuliah" value="<?= htmlspecialchars($data['nama_matakuliah']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="sks">SKS</label>
                                        <input type="number" class="form-control" name="sks" value="<?= htmlspecialchars($data['sks']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="semester">Semester</label>
                                        <input type="text" class="form-control" name="semester" value="<?= htmlspecialchars($data['semester']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis_matakuliah">Jenis Mata Kuliah</label>
                                        <input type="text" class="form-control" name="jenis_matakuliah" value="<?= htmlspecialchars($data['jenis_matakuliah']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text" class="form-control" name="keterangan" value="<?= htmlspecialchars($data['keterangan']) ?>" required>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
<?php
        } catch (PDOException $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
        break;
}
?>