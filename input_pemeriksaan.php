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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Proses input data ibu
    if (isset($_POST['id_pasien'])) {
        $id_pasien = $_POST['id_pasien'];
        $status_kehamilan = mysqli_real_escape_string($conn, $_POST['status_kehamilan']);
        $usia_kehamilan = mysqli_real_escape_string($conn, $_POST['usia_kehamilan']);
        $riwayat_kehamilan = mysqli_real_escape_string($conn, $_POST['riwayat_kehamilan']);
        $hpht = $_POST['hpht'];
        $hpl = $_POST['hpl'];

        $sql = "INSERT INTO ibu (id_pasien, status_kehamilan, usia_kehamilan, riwayat_kehamilan, hpht, hpl)
                VALUES ('$id_pasien', '$status_kehamilan', '$usia_kehamilan', '$riwayat_kehamilan', '$hpht', '$hpl')";

        if (mysqli_query($conn, $sql)) {
            $success_ibu = "Data ibu berhasil disimpan.";
        } else {
            $error_ibu = "Gagal menyimpan data ibu: " . mysqli_error($conn);
        }
    }

    // Proses input data pemeriksaan
    if (isset($_POST['id_ibu'])) {
        $id_ibu = $_POST['id_ibu'];
        $tanggal_pemeriksaan = $_POST['tanggal_pemeriksaan'];
        $tekanan_darah = $_POST['tekanan_darah'];
        $berat_badan = $_POST['berat_badan'];
        $detak_heart_janin = $_POST['detak_heart_janin'];
        $kondisi_janin = $_POST['kondisi_janin'];

        $query = "INSERT INTO pemeriksaan (id_ibu, tanggal_pemeriksaan, tekanan_darah, berat_badan, detak_heart_janin, kondisi_janin)
                  VALUES ('$id_ibu', '$tanggal_pemeriksaan', '$tekanan_darah', '$berat_badan', '$detak_heart_janin', '$kondisi_janin')";

        if (mysqli_query($conn, $query)) {
            $success_pemeriksaan = "Data pemeriksaan berhasil disimpan.";
        } else {
            $error_pemeriksaan = "Gagal menyimpan data pemeriksaan: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Ibu & Pemeriksaan Kehamilan (ANC)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Umum */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Latar belakang */
        .background-image {
            background: url('foto/input.jpg') no-repeat center center fixed;
            background-size: cover;
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -2;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.4);
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* Container untuk form */
        .container {
            max-width: 600px;
            margin: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Heading */
        h2, h3 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        /* Label */
        label {
            font-weight: 600;
            color: #333;
        }

        /* Input fields */
        input, select, textarea {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        /* Fokus pada input fields */
        input:focus, select:focus, textarea:focus {
            background-color: #fff;
            border-color: #4e73df;
            outline: none;
        }

        /* Button */
        .btn-primary {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        /* Alert (Success dan Error) */
        .alert {
            margin-top: 15px;
        }

        /* Print styles */
        @media print {
            .background-image, .overlay, .btn-primary {
                display: none !important;
            }

            .container {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="background-image"></div>
    <div class="overlay"></div>

    <div class="container">
        <h2>Input Data Ibu</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_pasien">ID Pasien:</label>
                <select name="id_pasien" class="form-control" required>
                    <option value="">Pilih ID Pasien</option>
                    <!-- Tambahkan query untuk mengambil data pasien -->
                    <?php
                    $result = mysqli_query($conn, "SELECT id_pasien, nama_pasien FROM pasien");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id_pasien'] . "'>" . $row['nama_pasien'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="status_kehamilan">Status Kehamilan:</label>
                <input type="text" name="status_kehamilan" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="usia_kehamilan">Usia Kehamilan (minggu):</label>
                <input type="number" name="usia_kehamilan" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="riwayat_kehamilan">Riwayat Kehamilan:</label>
                <textarea name="riwayat_kehamilan" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="hpht">HPHT:</label>
                <input type="date" name="hpht" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="hpl">HPL:</label>
                <input type="date" name="hpl" class="form-control" readonly>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Data Ibu</button>

            <?php if (isset($success_ibu)) { ?>
                <div class="alert alert-success mt-3"><?php echo $success_ibu; ?></div>
            <?php } elseif (isset($error_ibu)) { ?>
                <div class="alert alert-danger mt-3"><?php echo $error_ibu; ?></div>
            <?php } ?>
        </form>

        <h3 class="mt-5">Input Data Pemeriksaan Kehamilan (ANC)</h3>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_ibu">ID Ibu:</label>
                <select name="id_ibu" class="form-control" required>
                    <option value="">Pilih ID Ibu</option>
                    <!-- Tambahkan query untuk mengambil data ibu -->
                    <?php
                    $result_ibu = mysqli_query($conn, "SELECT id_ibu, status_kehamilan FROM ibu");
                    while ($row_ibu = mysqli_fetch_assoc($result_ibu)) {
                        echo "<option value='" . $row_ibu['id_ibu'] . "'>" . $row_ibu['status_kehamilan'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal_pemeriksaan">Tanggal Pemeriksaan:</label>
                <input type="date" name="tanggal_pemeriksaan" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="tekanan_darah">Tekanan Darah:</label>
                <input type="text" name="tekanan_darah" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="berat_badan">Berat Badan:</label>
                <input type="number" name="berat_badan" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="detak_heart_janin">Detak Jantung Janin:</label>
                <input type="number" name="detak_heart_janin" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="kondisi_janin">Kondisi Janin:</label>
                <input type="text" name="kondisi_janin" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Data Pemeriksaan</button>

            <?php if (isset($success_pemeriksaan)) { ?>
                <div class="alert alert-success mt-3"><?php echo $success_pemeriksaan; ?></div>
            <?php } elseif (isset($error_pemeriksaan)) { ?>
                <div class="alert alert-danger mt-3"><?php echo $error_pemeriksaan; ?></div>
            <?php } ?>
        </form>
    </div>
</body>
</html>
