<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "kesehatan_ibu_anak";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Jika form login disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Query untuk memeriksa username dan password
    $query = "SELECT * FROM pengguna WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    // Jika user ditemukan dan password sesuai
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['peran'] = $user['peran'];
        $_SESSION['id_pengguna'] = $user['id_pengguna'];

        // Redirect ke halaman sesuai peran
        if ($user['peran'] === 'admin') {
            header("Location: dashboard.php"); // Dashboard Admin
        } else {
            header("Location: dashboard_user.php");  // Dashboard User
        }
        exit();
    } else {
        $error = "Login gagal. Username atau password salah.";
    }
}

// Jika form registrasi disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $peran = mysqli_real_escape_string($conn, $_POST['peran']);

    // Validasi password
    if ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok.";
    } else {
        // Cek apakah username sudah ada
        $check_query = "SELECT * FROM pengguna WHERE username='$username'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Username sudah digunakan. Silakan pilih username lain.";
        } else {
            // Hash password sebelum disimpan
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Simpan data registrasi
            $query = "INSERT INTO pengguna (username, password, peran) VALUES ('$username', '$hashed_password', '$peran')";
            if (mysqli_query($conn, $query)) {
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Gagal registrasi. Coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem KIA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body */
        body {
            background-image: url('foto/sehat.jpg'); /* Ganti dengan lokasi gambar yang Anda inginkan */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Container utama */
        .container {
            width: 100%;
            max-width: 600px;
            margin-top: 50px;
        }

        /* Card Form */
        .card {
            background-color: rgba(255, 255, 255, 0.8); /* Memberikan latar belakang putih transparan pada form login */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Judul Card */
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        /* Form Field */
        .form-control {
            border-radius: 5px;
            margin-bottom: 15px;
        }

        /* Button */
        button {
            border-radius: 5px;
        }

        /* Alert */
        .alert {
            margin-top: 15px;
        }

        /* Tautan untuk berpindah antar form */
        .text-center a {
            color: #007bff;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        /* Collapse Register Form */
        .collapse {
            margin-top: 20px;
        }

        /* Responsif: Ukuran Layar Kecil */
        @media (max-width: 768px) {
            .card {
                padding: 20px;
            }
            .container {
                padding: 20px;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card col-md-6 offset-md-3">
        <div class="card-body">
            <h4 class="card-title text-center">Sistem KESEHATAN IBU DAN ANAK</h4>

            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

            <form method="POST">
                <!-- Login Form -->
                <div id="login">
                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <button class="btn btn-primary w-100" name="login">Login</button>
                </div>
            </form>

            <hr>

            <div class="text-center">
                <p>Belum punya akun? <a href="#register" data-bs-toggle="collapse">Daftar di sini</a></p>
            </div>

            <div id="register" class="collapse">
                <!-- Register Form -->
                <form method="POST">
                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="peran">Peran</label>
                        <select name="peran" class="form-control" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <button class="btn btn-success w-100" name="register">Daftar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
