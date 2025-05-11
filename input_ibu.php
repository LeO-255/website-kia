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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_ibu'])) {
    $id_pasien         = $_POST['id_pasien'];
    $status_kehamilan  = mysqli_real_escape_string($conn, $_POST['status_kehamilan']);
    $usia_kehamilan    = mysqli_real_escape_string($conn, $_POST['usia_kehamilan']);
    $riwayat_kehamilan = mysqli_real_escape_string($conn, $_POST['riwayat_kehamilan']);
    $hpht              = $_POST['hpht'];

    // Menghitung HPL (280 hari setelah HPHT)
    $hpl = date('Y-m-d', strtotime("$hpht + 280 days"));

    $sql = "INSERT INTO ibu (id_pasien, status_kehamilan, usia_kehamilan, riwayat_kehamilan, hpht, hpl)
            VALUES ('$id_pasien', '$status_kehamilan', '$usia_kehamilan', '$riwayat_kehamilan', '$hpht', '$hpl')";

    if (mysqli_query($conn, $sql)) {
        header("Location: input_pemeriksaan_anc.php?id_pasien=$id_pasien");
        exit();
    } else {
        $error = "Gagal menyimpan data ibu: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Data Ibu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('foto/input.jpg'); /* Ganti dengan path gambar Anda */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 700px;
            margin-top: 40px;
            background: rgba(255, 255, 255, 0.8); /* Membuat background transparan agar teks tetap terlihat */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h3 {
            text-align: center;
            margin-bottom: 25px;
        }
        .alert {
            margin-bottom: 20px;
        }
        .btn {
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h3>Input Data Ibu</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Pilih Pasien</label>
            <select name="id_pasien" class="form-select" required>
                <option value="" disabled selected>-- Pilih Pasien --</option>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM pasien");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['id_pasien']}'>{$row['nama']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Status Kehamilan</label>
            <input type="text" name="status_kehamilan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Usia Kehamilan</label>
            <input type="text" name="usia_kehamilan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Riwayat Kehamilan</label>
            <textarea name="riwayat_kehamilan" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label>HPHT</label>
            <input type="date" name="hpht" id="hpht" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>HPL (otomatis)</label>
            <input type="date" name="hpl" id="hpl" class="form-control" readonly required>
        </div>
        <button type="submit" name="submit_ibu" class="btn btn-primary w-100">Simpan & Lanjut Pemeriksaan</button>
    </form>
</div>

<script>
document.getElementById('hpht')?.addEventListener('change', function () {
    const hpht = new Date(this.value);
    if (!isNaN(hpht)) {
        const hpl = new Date(hpht);
        hpl.setDate(hpl.getDate() + 280); // 280 hari setelah HPHT
        document.getElementById('hpl').value = hpl.toISOString().split('T')[0]; // Menampilkan HPL
    }
});
</script>
</body>
</html>
