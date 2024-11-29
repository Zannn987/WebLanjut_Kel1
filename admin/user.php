<?php
include 'koneksi.php'; // Pastikan koneksi database sudah benar
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
        <div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
            <section class="content-header">
                <h1>Users</h1>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-2">
                            <a href="index.php?p=user&aksi=input" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Tambah User
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
                                                <th>Email</th>
                                                <th>Nama Lengkap</th>
                                                <th>Level</th>
                                                <th>No Telp</th>
                                                <th>Alamat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stmt = $db->prepare("SELECT user.*, level.nama_level 
                                                FROM user 
                                                JOIN level ON level.id = user.level_id");
                                            $stmt->execute();
                                            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            $no = 1;
                                            foreach ($users as $data) {
                                            ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><?= htmlspecialchars($data['email']) ?></td>
                                                    <td><?= htmlspecialchars($data['nama_lengkap']) ?></td>
                                                    <td><?= htmlspecialchars($data['nama_level']) ?></td>
                                                    <td><?= htmlspecialchars($data['notelp']) ?></td>
                                                    <td><?= htmlspecialchars($data['alamat']) ?></td>
                                                    <td>
                                                        <a href="index.php?p=user&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success btn-sm">
                                                            <i class="fa fa-pencil"></i> Edit
                                                        </a>
                                                        <a href="proses_user.php?proses=delete&id=<?= $data['id'] ?>&photo=<?= $data['photo'] ?>" 
                                                           class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data?')">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                                $no++;
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
                <h1>Input User</h1>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Form Input User</h3>
                        </div>
                        <form action="proses_user.php?proses=insert" method="post" enctype="multipart/form-data" class="mt-4">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Level</label>
                                    <div class="col-sm-10">
                                        <select name="level_id" class="form-control" required>
                                            <option value="">-Pilih Level-</option>
                                            <?php
                                            $stmt = $db->prepare("SELECT * FROM level");
                                            $stmt->execute();
                                            $levels = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($levels as $level) {
                                                echo "<option value='" . $level['id'] . "'>" . htmlspecialchars($level['nama_level']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_lengkap" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">No Telp</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="notelp" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Photo</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="photo" class="form-control" id="file-upload" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <img src="#" alt="Preview Photo" id="file-preview" width="300">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="alamat" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                                <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
<?php
        break;

    case 'edit':
        $stmt = $db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->execute(['id' => $_GET['id']]);
        $data_user = $stmt->fetch(PDO::FETCH_ASSOC);
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
                        <form action="proses_user.php?proses=edit" method="post" enctype="multipart/form-data" class="mt-4">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($data_user['id']) ?>">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($data_user['email']) ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Level</label>
                                    <div class="col-sm-10">
                                        <select name="level_id" class="form-control" required>
                                            <?php
                                            $stmt = $db->prepare("SELECT * FROM level");
                                            $stmt->execute();
                                            $levels = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($levels as $level) {
                                                $selected = ($level['id'] == $data_user['level_id']) ? 'selected' : '';
                                                echo "<option value='" . $level['id'] . "' $selected>" . htmlspecialchars($level['nama_level']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_lengkap" value="<?= htmlspecialchars($data_user['nama_lengkap']) ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">No Telp</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="notelp" value="<?= htmlspecialchars($data_user['notelp']) ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Photo</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="photo" class="form-control" id="file-upload">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <img src="assets/img/<?= htmlspecialchars($data_user['photo']) ?>" alt="Preview Photo" id="file-preview" width="300">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="alamat" rows="3" required><?= htmlspecialchars($data_user['alamat']) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success" name="submit">Update</button>
                                <button type="reset" class="btn btn-warning" name="reset">Reset</button>
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