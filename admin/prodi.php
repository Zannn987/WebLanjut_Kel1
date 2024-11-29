<?php
include 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
<div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
    <section class="content-header">
        <h1>Program Studi</h1>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-2">
                    <a href="index.php?p=prodi&aksi=input" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Prodi</a>
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
                                        <th>Nama Prodi</th>
                                        <th>Jenjang Studi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $dbh->prepare("SELECT * FROM prodi");
                                    $stmt->execute();
                                    $no = 1;
                                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= htmlspecialchars($data['nama_prodi']) ?></td>
                                        <td><?= htmlspecialchars($data['jenjang_studi']) ?></td>
                                        <td>
                                            <a href="index.php?p=prodi&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="proses_prodi.php?proses=delete&id=<?= $data['id'] ?>" 
                                            class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data?')">
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
        <h1>Input Prodi</h1>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Input Program Studi</h3>
                </div>
                <form action="proses_prodi.php?proses=insert" method="post">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_prodi">Nama Prodi</label>
                            <input type="text" class="form-control" name="nama_prodi" required>
                        </div>

                        <div class="form-group">
                            <label for="jenjang_studi">Jenjang Studi</label>
                            <select id="jenjang_studi" name="jenjang_studi" class="form-control" required>
                                <option value="">-Pilih Jenjang-</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                            </select>
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
        $stmt = $dbh->prepare("SELECT * FROM prodi WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
    <section class="content-header">
        <h1>Edit Prodi</h1>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Program Studi</h3>
                </div>
                <form action="proses_prodi.php?proses=edit" method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_prodi">Nama Prodi</label>
                            <input type="text" class="form-control" name="nama_prodi" value="<?= htmlspecialchars($data['nama_prodi']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="jenjang_studi">Jenjang Studi</label>
                            <select id="jenjang_studi" name="jenjang_studi" class="form-control" required>
                                <option value="D3" <?= $data['jenjang_studi'] == 'D3' ? 'selected' : '' ?>>D3</option>
                                <option value="D4" <?= $data['jenjang_studi'] == 'D4' ? 'selected' : '' ?>>D4</option>
                            </select>
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
