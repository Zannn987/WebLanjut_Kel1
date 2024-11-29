<?php
include 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
<div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
    <section class="content-header">
        <h1>Kategori</h1>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-2">
                    <a href="index.php?p=kategori&aksi=input" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Kategori
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
                                        <th>Nama Kategori</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $dbh->query("SELECT * FROM kategori");
                                    $no = 1;
                                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= htmlspecialchars($data['nama_kategori']) ?></td>
                                        <td><?= htmlspecialchars($data['keterangan']) ?></td>
                                        <td>
                                            <a href="index.php?p=kategori&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="proses_kategori.php?proses=delete&id=<?= $data['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $no++; } ?>
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
        <h1>Input Kategori</h1>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Input Kategori</h3>
                </div>
                <form action="proses_kategori.php?proses=insert" method="post">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
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
        $stmt = $dbh->prepare("SELECT * FROM kategori WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
    <section class="content-header">
        <h1>Edit Kategori</h1>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Kategori</h3>
                </div>
                <form action="proses_kategori.php?proses=edit" method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= htmlspecialchars($data['nama_kategori']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required><?= htmlspecialchars($data['keterangan']) ?></textarea>
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
        break;
}
?>
