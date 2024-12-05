<?php
include 'koneksi.php'; // Pastikan koneksi menggunakan PDO
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
        <div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
            <section class="content-header">
                <h1>Data Level</h1>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-2">
                            <a href="index.php?p=level&aksi=input" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah Level</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Level</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            try {
                                                $stmt = $db->query("SELECT * FROM level");
                                                $no = 1;
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= htmlspecialchars($row['nama_level']) ?></td>
                                                        <td><?= htmlspecialchars($row['keterangan']) ?></td>
                                                        <td>
                                                            <a href="index.php?p=level&aksi=edit&id=<?= $row['id'] ?>" class="btn btn-success"><i class="fas fa-edit"></i> Edit</a>
                                                            <a href="proses_level.php?proses=delete&id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i> Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php
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
        <div class="container">
            <h1>Tambah Level</h1>
            <form action="proses_level.php?proses=insert" method="POST">
                <div class="mb-3">
                    <label for="nama_level" class="form-label">Nama Level</label>
                    <input type="text" class="form-control" id="nama_level" name="nama_level" required>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="index.php?p=level" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
        <?php
        break;

    case 'edit':
        try {
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $stmt = $db->prepare("SELECT * FROM level WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) {
                echo "Data tidak ditemukan.";
                exit;
            }
        ?>
            <div class="container">
                <h1>Edit Level</h1>
                <form action="proses_level.php?proses=edit" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                    <div class="mb-3">
                        <label for="nama_level" class="form-label">Nama Level</label>
                        <input type="text" class="form-control" id="nama_level" name="nama_level" value="<?= htmlspecialchars($data['nama_level']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= htmlspecialchars($data['keterangan']) ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="index.php?p=level" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
<?php
        } catch (PDOException $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
        break;
}
?>