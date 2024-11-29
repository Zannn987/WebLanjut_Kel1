<?php
include 'koneksi.php'; // Pastikan koneksi menggunakan PDO
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Data Level</title>

            <!-- Google Font -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
            <!-- DataTables -->
            <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
            <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
            <link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
        </head>

        <body class="hold-transition sidebar-mini">
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>Data Level</h1>
                </section>

                <section class="content">
                    <div class="card">
                        <div class="card-header">
                            <a href="index.php?p=level&aksi=input" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah Level</a>
                        </div>
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
                                    $stmt = $db->prepare("SELECT * FROM level");
                                    $stmt->execute();
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Scripts -->
            <script src="assets/plugins/jquery/jquery.min.js"></script>
            <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
            <script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
            <script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
            <script src="assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
            <script src="assets/dist/js/adminlte.min.js"></script>
            <script>
                $(function() {
                    $("#example1").DataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                });
            </script>
        </body>

        </html>
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
            <form action="proses_level.php?proses=update" method="POST">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
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
        break;
}
?>