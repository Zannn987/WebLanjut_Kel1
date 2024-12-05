<?php
include 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
        <div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
            <section class="content-header">
                <h1>Data User</h1>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-2">
                            <a href="index.php?p=user&aksi=input" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah User
                            </a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Nama Lengkap</th>
                                        <th>Level</th>
                                        <th>No Telp</th>
                                        <th>Alamat</th>
                                        <th>Photo</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try {
                                        $stmt = $db->prepare("SELECT user.*, level.nama_level 
                                                     FROM user 
                                                     JOIN level ON user.level_id = level.id");
                                        $stmt->execute();
                                        $no = 1;
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($row['email']) ?></td>
                                                <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                                                <td><?= htmlspecialchars($row['nama_level']) ?></td>
                                                <td><?= htmlspecialchars($row['notelp']) ?></td>
                                                <td><?= htmlspecialchars($row['alamat']) ?></td>
                                                <td>
                                                    <?php if ($row['photo']): ?>
                                                        <img src="upload/<?= htmlspecialchars($row['photo']) ?>"
                                                            alt="User Photo" width="50">
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="index.php?p=user&aksi=edit&id=<?= $row['id'] ?>"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <a href="proses_user.php?proses=delete&id=<?= $row['id'] ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin akan menghapus data?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php
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
            </section>
        </div>
        <?php
        break;

    case 'input':
        try {
            $stmt_level = $db->query("SELECT * FROM level ORDER BY nama_level");
        ?>
            <div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
                <section class="content-header">
                    <h1>Input User</h1>
                </section>
                <section class="content">
                    <div class="container-fluid">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Form Input User</h3>
                            </div>
                            <form action="proses_user.php?proses=insert" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="level_id">Level</label>
                                        <select name="level_id" class="form-control" required>
                                            <option value="">Pilih Level</option>
                                            <?php while ($level = $stmt_level->fetch(PDO::FETCH_ASSOC)): ?>
                                                <option value="<?= $level['id'] ?>">
                                                    <?= htmlspecialchars($level['nama_level']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama_lengkap" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="notelp">No Telp</label>
                                        <input type="text" class="form-control" name="notelp" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" name="alamat" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <input type="file" class="form-control" name="photo">
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
        } catch (PDOException $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
        break;

    case 'edit':
        try {
            $stmt = $db->prepare("SELECT * FROM user WHERE id = :id");
            $stmt->bindParam(':id', $_GET['id']);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt_level = $db->query("SELECT * FROM level ORDER BY nama_level");
        ?>
            <div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
                <section class="content-header">
                    <h1>Edit User</h1>
                </section>
                <section class="content">
                    <div class="container-fluid">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Form Edit User</h3>
                            </div>
                            <form action="proses_user.php?proses=edit" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="<?= htmlspecialchars($data['email']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password (Kosongkan jika tidak diubah)</label>
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="level_id">Level</label>
                                        <select name="level_id" class="form-control" required>
                                            <?php while ($level = $stmt_level->fetch(PDO::FETCH_ASSOC)): ?>
                                                <option value="<?= $level['id'] ?>"
                                                    <?= $level['id'] == $data['level_id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($level['nama_level']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama_lengkap"
                                            value="<?= htmlspecialchars($data['nama_lengkap']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="notelp">No Telp</label>
                                        <input type="text" class="form-control" name="notelp"
                                            value="<?= htmlspecialchars($data['notelp']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" name="alamat" required><?= htmlspecialchars($data['alamat']) ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <?php if ($data['photo']): ?>
                                            <div class="mb-2">
                                                <img src="upload/<?= htmlspecialchars($data['photo']) ?>"
                                                    alt="Current Photo" width="100">
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control" name="photo">
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