<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mahasiswa</h1>
</div>

<?php
include 'koneksi.php'; // Pastikan koneksi menggunakan PDO
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
        <div class="row">
            <div class="col-2 mb-3">
                <a href="index.php?p=mhs&aksi=input" class="btn btn-primary"><i class="bi bi-person-plus"></i>Tambah Mahasiswa</a>
            </div>

            <div class="table-responsive small">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Tanggal Lahir</th>
                            <th>Email</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Prodi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $db->prepare("SELECT mahasiswa.*, prodi.nama_prodi FROM mahasiswa JOIN prodi ON mahasiswa.prodi_id = prodi.id");
                        $stmt->execute();
                        $no = 1;
                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($data['nama_mhs']) ?></td>
                                <td><?= htmlspecialchars($data['tgl_lahir']) ?></td>
                                <td><?= htmlspecialchars($data['email']) ?></td>
                                <td><?= htmlspecialchars($data['notelp']) ?></td>
                                <td><?= htmlspecialchars($data['alamat']) ?></td>
                                <td><?= htmlspecialchars($data['nama_prodi']) ?></td>
                                <td>
                                    <a href="index.php?p=mhs&aksi=edit&nim=<?= htmlspecialchars($data['nim']) ?>" class="btn btn-success">Edit</a>
                                    <a href="proses_mahasiswa.php?proses=delete&nim=<?= htmlspecialchars($data['nim']) ?>" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')">Delete</a>
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
                <h2>Form Registrasi Mahasiswa</h2>
                <form action="proses_mahasiswa.php?proses=insert" method="post">
                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="number" class="form-control" name="nim" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <!-- Tanggal Lahir -->
                    <div class="row">
                        <div class="mb-3 col-3">
                            <label class="form-label">Tgl</label>
                            <select class="form-select" name="tgl" required>
                                <option selected>-Tgl-</option>
                                <?php for ($i = 1; $i <= 31; $i++) { ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3 col-3">
                            <label class="form-label">Bln</label>
                            <select class="form-select" name="bln" required>
                                <option selected>-Bln-</option>
                                <?php
                                $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                foreach ($bulan as $indexbulan => $namabulan) {
                                    echo "<option value='$indexbulan'>$namabulan</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 col-3">
                            <label class="form-label">Thn</label>
                            <select class="form-select" name="thn" required>
                                <option selected>-Thn-</option>
                                <?php for ($i = 2024; $i >= 1900; $i--) { ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <!-- Jenis Kelamin -->
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jekel" value="L" required>
                            <label class="form-check-label">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jekel" value="P" required>
                            <label class="form-check-label">Perempuan</label>
                        </div>
                    </div>
                    <!-- Hobi -->
                    <div class="mb-3">
                        <label class="form-label">Hobi</label><br>
                        <?php
                        $hobi_list = ['Membaca', 'Olahraga', 'Travelling'];
                        foreach ($hobi_list as $hobi) {
                            echo "<div class='form-check form-check-inline'>
                                    <input class='form-check-input' type='checkbox' name='hobi[]' value='$hobi'>
                                    <label class='form-check-label'>$hobi</label>
                                  </div>";
                        }
                        ?>
                    </div>
                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <!-- No Telp -->
                    <div class="mb-3">
                        <label class="form-label">No Telp</label>
                        <input type="number" class="form-control" name="notelp" required>
                    </div>
                    <!-- Alamat -->
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" rows="3" name="alamat" required></textarea>
                    </div>
                    <!-- Prodi -->
                    <div class="mb-3">
                        <label class="form-label">Prodi</label>
                        <select name="prodi_id" class="form-select" required>
                            <option value="">Pilih Prodi</option>
                            <?php
                            $stmt = $db->prepare("SELECT * FROM prodi");
                            $stmt->execute();
                            while ($data_prodi = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$data_prodi['id']}'>{$data_prodi['nama_prodi']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Submit -->
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                    </div>
                </form>
            </div>
        </div>
<?php
        break;

    case 'edit':
        // Kode edit mahasiswa
        break;
}
?>