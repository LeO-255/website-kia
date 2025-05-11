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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Ibu - Sistem KIA</title>
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
    <h2 class="text-center">Laporan Data Ibu</h2>

    <!-- Navigasi -->
    <div class="text-end no-print mb-3">
        <a href="laporan_pasien.php" class="btn btn-warning">Sebelumnya</a>
        <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        <a href="laporan_anc.php" class="btn btn-primary">Next</a>
        <button class="btn btn-success no-print" onclick="window.print()">Cetak Laporan</button> <!-- Tombol Cetak -->
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Status Kehamilan</th>
                <th>Usia Kehamilan</th>
                <th>Riwayat Kehamilan</th>
                <th>HPHT</th>
                <th>HPL</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query  = "
          SELECT ibu.*, pasien.nama
          FROM ibu
          JOIN pasien ON ibu.id_pasien = pasien.id_pasien
        ";
        $result = mysqli_query($conn, $query);
        $no     = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            // Mengambil HPHT dan menghitung HPL
            $hpht = $row['hpht'];
            $hpl = date('Y-m-d', strtotime($hpht . ' + 280 days'));

            // Tampilkan usia kehamilan dengan satuan "minggu"
            $usiaLabel = htmlspecialchars($row['usia_kehamilan']) . " minggu";

            // Tampilkan HPHT dan HPL dalam format yang sesuai
            $formatted_hpht = date('d-m-Y', strtotime($hpht));
            $formatted_hpl = date('d-m-Y', strtotime($hpl));

            echo "<tr>
                    <td>{$no}</td>
                    <td>".htmlspecialchars($row['nama'])."</td>
                    <td>".htmlspecialchars($row['status_kehamilan'])."</td>
                    <td>{$usiaLabel}</td>
                    <td>".htmlspecialchars($row['riwayat_kehamilan'])."</td>
                    <td>{$formatted_hpht}</td>
                    <td>{$formatted_hpl}</td>
                  </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
