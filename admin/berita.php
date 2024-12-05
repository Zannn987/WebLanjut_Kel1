<?php
// Include koneksi database
include 'koneksi.php';

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
        <div class="row">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Berita</h1>
            </div>
            <div class="col-2 mb-3">
                <a href="index.php?p=berita&aksi=input" class="btn btn-primary">Tambah Berita</a>
            </div>
            <div class="table-responsive small">
                <table class="table table-bordered table-striped table-sm" id="example">
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
                        $query = "SELECT berita.*, kategori.nama_kategori, user.email 
                                  FROM berita 
                                  JOIN kategori ON kategori.id = berita.kategori_id 
                                  JOIN user ON user.id = berita.user_id";
                        $stmt = $db->prepare($query);
                        $stmt->execute();

                        $no = 1;
                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($data['judul']) ?></td>
                                <td><?= htmlspecialchars($data['nama_kategori']) ?></td>
                                <td><?= htmlspecialchars($data['email']) ?></td>
                                <td><?= htmlspecialchars($data['created_at']) ?></td>
                                <td>
                                    <a href="index.php?p=berita&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success">Edit</a>
                                    <a href="proses_berita.php?proses=delete&id=<?= $data['id'] ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('Yakin mau dihapus?')">Delete</a>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Berita</h3>
                    </div>
                    <div class="card-body">
                        <form action="proses_berita.php?proses=insert" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control" name="judul" id="judul" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori_id">Kategori</label>
                                <select name="kategori_id" id="kategori_id" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php
                                    $stmt = $db->query("SELECT * FROM kategori");
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['nama_kategori']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fileToUpload">File Upload</label>
                                <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" required accept="image/*" onchange="previewImage(event)">
                                <img id="imagePreview" src="#" alt="Preview" class="img-fluid mt-2" style="display: none;">
                            </div>
                            <div class="form-group">
                                <label for="isi_berita">Isi Berita</label>
                                <textarea class="form-control" name="isi_berita" id="isi_berita" rows="5" required></textarea>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
        break;

    case 'edit':
        $id = $_GET['id'];
        $stmt = $db->prepare("SELECT * FROM berita WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data_berita = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
        <div class="row">
            <div class="col-6 mx-auto">
                <h2>Edit Berita</h2>
                <form action="proses_berita.php?proses=edit" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $data_berita['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" value="<?= htmlspecialchars($data_berita['judul']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-select">
                            <?php
                            $stmt = $db->query("SELECT * FROM kategori");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $selected = $row['id'] == $data_berita['kategori_id'] ? 'selected' : '';
                                echo "<option value='" . $row['id'] . "' $selected>" . htmlspecialchars($row['nama_kategori']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File Upload</label>
                        <input type="file" class="form-control" name="fileToUpload">
                        <img src="upload/<?= htmlspecialchars($data_berita['file_upload']) ?>" alt="Preview" width="300">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi Berita</label>
                        <textarea class="form-control" name="isi_berita" rows="5"><?= htmlspecialchars($data_berita['isi_berita']) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
<?php
        break;
}
?>

<script>
    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function() {
            imagePreview.src = reader.result;
            imagePreview.style.display = 'block';
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '#';
            imagePreview.style.display = 'none';
        }
    }
</script>