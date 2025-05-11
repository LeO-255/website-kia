<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db   = "kesehatan_ibu_anak";
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemeriksaan Kehamilan - Sistem KIA</title>
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
            .no-print {
                display: none;
            }
            body {
                background: white !important;
            }
            .container {
                box-shadow: none;
                background: white !important;
            }
            th {
                background-color: #ddd !important;
                color: black !important;
            }
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Laporan Pemeriksaan Kehamilan (ANC)</h2>

    <!-- Navigasi -->
    <div class="text-end no-print mb-3">
        <!-- Kembali ke laporan ibu -->
        <a href="laporan_ibu.php" class="btn btn-warning">Sebelumnya</a>
        <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        <!-- Tombol Next -->
        <a href="laporan_bayi.php" class="btn btn-primary">Next</a>
        <!-- Tombol Cetak -->
        <button class="btn btn-success no-print" onclick="window.print()">Cetak Laporan</button>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Ibu</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Tekanan Darah</th>
                <th>Berat Badan</th>
                <th>Detak Jantung Janin</th>
                <th>Kondisi Janin</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = "
            SELECT * 
            FROM pemeriksaan_anc
            ORDER BY tanggal_pemeriksaan DESC
        ";
        $result = mysqli_query($conn, $query);
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['id_ibu']}</td>
                    <td>{$row['tanggal_pemeriksaan']}</td>
                    <td>{$row['tekanan_darah']}</td>
                    <td>{$row['berat_badan']} kg</td>
                    <td>{$row['detak_jantung_janin']} bpm</td>
                    <td>{$row['kondisi_janin']}</td>
                  </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
</div>

<script>
    // Fungsi cetak halaman
    function printReport() {
        window.print();
    }
</script>

</body>
</html>
