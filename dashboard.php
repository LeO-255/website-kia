<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['peran'] != 'admin') {
    header("Location: index.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "kesehatan_ibu_anak";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Sistem Kesehatan Ibu dan Anak</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('foto/rs.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 950px;
            margin-top: 100px;
        }

        h3 {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .welcome-message {
            font-size: 1.2rem;
            color: #555;
        }

        .navbar {
            background-color: rgba(0, 123, 255, 0.95);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .navbar a {
            color: #fff;
            font-weight: 600;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 1.2rem;
            font-weight: 600;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .list-group-item-action {
            font-size: 1.05rem;
            color: #333;
            transition: all 0.3s ease;
            padding: 10px 15px;
        }

        .list-group-item-action:hover {
            background-color: #f0f0f0;
            color: #007bff;
            border-left: 4px solid #007bff;
            font-weight: 600;
        }

        footer {
            background-color: #007bff;
            color: #fff;
            font-size: 0.9rem;
            text-align: center;
            padding: 20px;
            margin-top: auto;
            width: 100%;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistem Kesehatan Ibu dan Anak</a>
            <div class="d-flex">
                <a href="logout.php" class="btn btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>

    <main>
        <div class="container">
            <h3>Selamat datang, <?= htmlspecialchars($_SESSION['username']); ?>!</h3>
            <p class="welcome-message">Anda login sebagai <strong><?= htmlspecialchars($_SESSION['peran']); ?></strong>.</p>

            <div class="row">
                <!-- Menu Akses Data -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">Akses Data</div>
                        <div class="card-body">
                            <ul class="list-group">
                                <a href="input_pasien.php" class="list-group-item list-group-item-action">Input Data Pasien</a>
                                <a href="input_ibu.php" class="list-group-item list-group-item-action">Input Data Ibu</a>
                                <a href="input_pemeriksaan_anc.php" class="list-group-item list-group-item-action">Input Pemeriksaan Kehamilan</a>
                                <a href="input_bayi.php" class="list-group-item list-group-item-action">Input Data Bayi</a>
                                <a href="input_imunisasi.php" class="list-group-item list-group-item-action">Input Data Imunisasi</a>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Menu Laporan Data -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">Laporan Data</div>
                        <div class="card-body">
                            <ul class="list-group">
                                <a href="laporan_pasien.php" class="list-group-item list-group-item-action">Laporan Data Pasien</a>
                                <a href="laporan_ibu.php" class="list-group-item list-group-item-action">Laporan Data Ibu</a>
                                <a href="laporan_anc.php" class="list-group-item list-group-item-action">Laporan Pemeriksaan Kehamilan</a>
                                <a href="laporan_bayi.php" class="list-group-item list-group-item-action">Laporan Data Bayi</a>
                                <a href="laporan_imunisasi.php" class="list-group-item list-group-item-action">Laporan Imunisasi Bayi</a>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Sistem KIA - Semua hak dilindungi.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
