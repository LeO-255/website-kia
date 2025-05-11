<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['peran'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "kesehatan_ibu_anak";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_bayi = $_POST['id_bayi'];
    $jenis_imunisasi = $_POST['jenis_imunisasi'];
    $tanggal_pemberian = $_POST['tanggal_pemberian'];
    $status = $_POST['status'];

    if (!empty($id_bayi) && !empty($jenis_imunisasi) && !empty($tanggal_pemberian) && !empty($status)) {
        $ins = "INSERT INTO imunisasi (id_bayi, jenis_imunisasi, tanggal_imunisasi, status_imunisasi)
                VALUES ('$id_bayi', '$jenis_imunisasi', '$tanggal_pemberian', '$status')";
        
        if (mysqli_query($conn, $ins)) {
            header("Location: laporan_imunisasi.php");
            exit();
        } else {
            $error = "Gagal simpan: " . mysqli_error($conn);
        }
    } else {
        $error = "Semua kolom wajib diisi.";
    }
}

$result_bayi = mysqli_query($conn, "SELECT id_bayi, nama FROM bayi");

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Input Data Imunisasi - Sistem KIA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <style>
        body {
            background-image: url('foto/input.jpg');
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
            max-width: 700px;
            width: 100%;
        }
        h3 {
            color: #333;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        label {
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="text-center mb-4">Input Data Imunisasi (Buku KIA)</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="id_bayi" class="form-label">Nama Bayi</label>
            <select name="id_bayi" id="id_bayi" class="form-select" required>
                <option value="">Pilih Bayi</option>
                <?php while ($row = mysqli_fetch_assoc($result_bayi)): ?>
                    <option value="<?= $row['id_bayi'] ?>"><?= htmlspecialchars($row['nama']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="jenis_imunisasi" class="form-label">Jenis Imunisasi</label>
            <select name="jenis_imunisasi" id="jenis_imunisasi" class="form-select" required>
                <option value="">Pilih Jenis Imunisasi</option>
                <option value="BCG">BCG</option>
                <option value="Hepatitis B">Hepatitis B</option>
                <option value="Polio">Polio</option>
                <option value="DPT">DPT</option>
                <option value="Campak">Campak</option>
                <option value="DPT-HB-Hib">DPT-HB-Hib</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal_pemberian" class="form-label">Tanggal Pemberian</label>
            <input type="date" name="tanggal_pemberian" id="tanggal_pemberian" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="Diberikan">Diberikan</option>
                <option value="Belum Diberikan">Belum Diberikan</option>
                <option value="Ditunda">Ditunda</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan Data</button>
    </form>
</div>
</body>
</html>
