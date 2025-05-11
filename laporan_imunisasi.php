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

// Query diperbaiki agar nama bayi muncul
$query = "
    SELECT bayi.nama_bayi AS nama, 
           imunisasi.jenis_imunisasi, 
           imunisasi.tanggal_pemberian AS tanggal_imunisasi, 
           imunisasi.status AS status_imunisasi
    FROM imunisasi
    LEFT JOIN bayi ON imunisasi.id_bayi = bayi.id_bayi
";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Imunisasi Bayi - Sistem KIA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('foto/laporan.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            max-width: 1000px;
            width: 100%;
            z-index: 2;
        }
        h2.text-center {
            margin-bottom: 30px;
            color: #333;
        }
        .table {
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
        }
        th {
            background-color: #007bff !important;
            color: white !important;
        }
        .btn {
            margin-left: 5px;
        }
        @media print {
            .no-print { display: none; }
            body { background: white !important; }
            .container { box-shadow: none; background: white !important; }
            th { background-color: #ddd !important; color: black !important; }
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Laporan Imunisasi Bayi</h2>

    <!-- Navigasi -->
    <div class="text-end no-print mb-3">
        <a href="laporan_bayi.php" class="btn btn-warning">Sebelumnya</a>
        <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        <button class="btn btn-success no-print" onclick="window.print()">Cetak Laporan</button>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bayi</th>
                <th>Jenis Imunisasi</th>
                <th>Tanggal Imunisasi</th>
                <th>Status Imunisasi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $nama_bayi = !empty($row['nama']) ? htmlspecialchars($row['nama']) : 'Nama tidak tersedia';
            $tanggal_imunisasi = !empty($row['tanggal_imunisasi']) ? date("d-m-Y", strtotime($row['tanggal_imunisasi'])) : 'Tanggal tidak tersedia';
            $status_imunisasi = htmlspecialchars($row['status_imunisasi']);

            echo "<tr>
                    <td>{$no}</td>
                    <td>{$nama_bayi}</td>
                    <td>" . htmlspecialchars($row['jenis_imunisasi']) . "</td>
                    <td>{$tanggal_imunisasi}</td>
                    <td>{$status_imunisasi}</td>
                  </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
