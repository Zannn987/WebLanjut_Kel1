<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets-adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="assets-adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets-adminlte/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="../index.html" class="h1"><b>Login</b>APP TI</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Sign In</button>
                    </div>
            </div>
            </form>

        </div>
    </div>
    </div>

    <!-- jQuery -->
    <script src="assets-adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets-adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets-adminlte/dist/js/adminlte.min.js"></script>

    <?php
    if (isset($_POST['submit'])) {
        include 'admin/koneksi.php'; // pastikan file koneksi.php menggunakan PDO

        $user_email = $_POST['email'];
        $user_pass = md5($_POST['password']); // Jangan gunakan md5 untuk password di aplikasi nyata, gunakan password_hash()

        try {
            // Persiapkan query untuk pengecekan login
            $stmt = $db->prepare("SELECT * FROM user WHERE email = :email AND password = :password");
            $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $user_pass, PDO::PARAM_STR);
            $stmt->execute();

            // Cek jika ada hasil yang ditemukan
            if ($stmt->rowCount() > 0) {
                // Mengambil data user dari hasil query
                $data_user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Mulai sesi dan set variabel sesi
                session_start();
                $_SESSION['user'] = $data_user['email'];
                $_SESSION['level'] = $data_user['level'];
                $_SESSION['user_id'] = $data_user['id'];

                // Redirect ke halaman admin setelah login sukses
                header('location:admin/index.php');
                exit;
            } else {
                echo "<script>alert('Email and password invalid')</script>";
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    ?>
</body>

</html>