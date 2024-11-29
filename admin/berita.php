<?php
include 'koneksi.php'; // Pastikan koneksi database sudah benar
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
        <div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
            <section class="content-header">
                <h1>Berita</h1>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-2">
                            <a href="index.php?p=berita&aksi=input" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Tambah Berita
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
                                                <th>Judul</th>
                                                <th>Kategori</th>
                                                <th>User</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT berita.id, berita.judul, kategori.nama_kategori, user.email, berita.created_at, berita.file_upload 
                                                    FROM berita 
                                                    JOIN user ON user.id = berita.user_id 
                                                    JOIN kategori ON kategori.id = berita.kategori_id";
                                            $stmt = $db->query($sql);
                                            
                                            $no = 1;
                                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><?= htmlspecialchars($data['judul']) ?></td>
                                                    <td><?= htmlspecialchars($data['nama_kategori']) ?></td>
                                                    <td><?= htmlspecialchars($data['email']) ?></td>
                                                    <td><?= htmlspecialchars($data['created_at']) ?></td>
                                                    <td>
                                                        <a href="index.php?p=berita&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success btn-sm">
                                                            <i class="fa fa-pencil"></i> Edit
                                                        </a>
                                                        <a href="proses_berita.php?proses=delete&id=<?= $data['id'] ?>&file=<?= $data['file_upload'] ?>" 
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
                <h1>Input Berita</h1>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Form Input Berita</h3>
                        </div>
                        <form action="proses_berita.php?proses=insert" method="post" enctype="multipart/form-data" class="mt-4">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="judul" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kategori</label>
                                    <div class="col-sm-10">
                                        <select name="kategori_id" class="form-control" required>
                                            <option value="">-Pilih kategori-</option>
                                            <?php
                                            $sql = "SELECT * FROM kategori";
                                            $stmt = $db->query($sql);
                                            while ($data_kategori = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<option value='" . $data_kategori['id'] . "'>" . htmlspecialchars($data_kategori['nama_kategori']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">File Upload</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="fileToUpload" class="form-control" id="file-upload" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <img src="#" alt="Preview Uploaded Image" id="file-preview" width="300">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Berita</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="isi_berita" name="isi_berita" rows="3" required></textarea>
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
        $stmt = $db->prepare("SELECT * FROM berita WHERE id=:id");
        $stmt->execute(['id' => $_GET['id']]);
        $data_berita = $stmt->fetch(PDO::FETCH_ASSOC);
?>
        <div class="content-wrapper" style="padding-left: 0; margin-left: 0;">
            <section class="content-header">
                <h1>Edit Berita</h1>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Form Edit Berita</h3>
                        </div>
                        <form action="proses_berita.php?proses=edit" method="post" enctype="multipart/form-data" class="mt-4">
                            <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($data_berita['id']) ?>">

                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="judul" value="<?= htmlspecialchars($data_berita['judul']) ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kategori</label>
                                    <div class="col-sm-10">
                                        <select name="kategori_id" class="form-control" required>
                                            <?php
                                            $stmt_kategori = $db->query("SELECT * FROM kategori");
                                            while ($data_kategori = $stmt_kategori->fetch(PDO::FETCH_ASSOC)) {
                                                $selected = ($data_kategori['id'] == $data_berita['kategori_id']) ? 'selected' : '';
                                                echo "<option value='" . $data_kategori['id'] . "' $selected>" . htmlspecialchars($data_kategori['nama_kategori']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">File Upload</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="fileToUpload" class="form-control" id="file-upload">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <?php
                                        if ($data_berita['file_upload'] != '') {
                                        ?>
                                            <img src="upload/<?= htmlspecialchars($data_berita['file_upload']) ?>" alt="Preview Uploaded Image" id="file-preview" width="300">
                                        <?php
                                        } else {
                                            echo '<img src="#" alt="Preview Uploaded Image" id="file-preview" width="300">';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Berita</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="isi_berita" name="isi_berita" rows="3" required><?= htmlspecialchars($data_berita['isi_berita']) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success" name="submit">Update</button>
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