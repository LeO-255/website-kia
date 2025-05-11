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

// Fungsi menghitung tanggal dari HPHT + X minggu
function tambahMinggu($hpht, $minggu) {
    return date('d-m-Y', strtotime("+$minggu weeks", strtotime($hpht)));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Pemeriksaan Kehamilan - Sistem KIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('foto/laporan.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            background-color: rgba(255,255,255,0.95);
            padding: 30px;
            margin-top: 50px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        @media print {
            .no-print { display: none; }
            body { background: white !important; }
            .container { box-shadow: none; background: white !important; }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Jadwal Pemeriksaan Kehamilan</h2>

    <div class="text-end mb-3 no-print">
        <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        <button onclick="window.print()" class="btn btn-success">Cetak Jadwal</button>
    </div>

    <?php
    $query = mysqli_query($conn, "SELECT ibu.*, pasien.nama FROM ibu JOIN pasien ON ibu.id_pasien = pasien.id_pasien");
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<div class='mb-4'>";
            echo "<h5><strong>Nama Ibu:</strong> " . htmlspecialchars($row['nama']) . "</h5>";
            echo "<p><strong>HPHT:</strong> " . date('d-m-Y', strtotime($row['hpht'])) . "</p>";
            echo "<table class='table table-bordered'>
                    <thead class='table-primary'>
                        <tr>
                            <th>Pemeriksaan Ke</th>
                            <th>Minggu Ke</th>
                            <th>Tanggal Pemeriksaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>1</td><td>12</td><td>" . tambahMinggu($row['hpht'], 12) . "</td></tr>
                        <tr><td>2</td><td>20</td><td>" . tambahMinggu($row['hpht'], 20) . "</td></tr>
                        <tr><td>3</td><td>28</td><td>" . tambahMinggu($row['hpht'], 28) . "</td></tr>
                        <tr><td>4</td><td>36</td><td>" . tambahMinggu($row['hpht'], 36) . "</td></tr>
                    </tbody>
                  </table>";
            echo "</div><hr>";
        }
    } else {
        echo "<p class='text-danger'>Belum ada data ibu yang tersedia.</p>";
    }
    ?>
</div>
</body>
</html>
