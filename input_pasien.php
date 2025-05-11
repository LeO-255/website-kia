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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama          = mysqli_real_escape_string($conn, $_POST['nama']);
    $tgl_lahir     = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin']; // hanya 'P'
    $alamat        = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_telp       = $_POST['no_telepon'];

    if (!preg_match("/^[0-9]+$/", $no_telp)) {
        $error = "Nomor telepon hanya boleh terdiri dari angka.";
    } else {
        $sql = "INSERT INTO pasien (nama, tanggal_lahir, jenis_kelamin, alamat, no_telepon)
                VALUES ('$nama', '$tgl_lahir', '$jenis_kelamin', '$alamat', '$no_telp')";
        if (mysqli_query($conn, $sql)) {
            $success = "Data pasien berhasil disimpan.";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'input_ibu.php';
                    }, 1000);
                  </script>";
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Input Data Pasien</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: Arial, sans-serif;
    }
    .background-image {
      background: url('foto/input.jpg') no-repeat center center fixed;
      background-size: cover;
      position: fixed; width:100%; height:100%; z-index:-2;
    }
    .overlay {
      background-color: rgba(0,0,0,0.4);
      position: fixed; width:100%; height:100%; z-index:-1;
    }
    .container {
      max-width: 600px;
      margin: auto;
      position: absolute;
      top:50%; left:50%;
      transform: translate(-50%, -50%);
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    h3 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    label {
      font-weight: 600;
      color: #333;
    }
    input, select, textarea {
      background-color: #f9f9f9;
      border: 1px solid #ccc;
    }
    input:focus, select:focus, textarea:focus {
      background-color: #fff;
      border-color: #4e73df;
      outline: none;
    }
    .btn-primary {
      width: 100%;
      padding: 10px;
      font-size: 16px;
    }
    .alert { margin-top: 15px; }
    @media print {
      .background-image, .overlay, .btn-primary {
        display: none !important;
      }
      .container { box-shadow: none; border: none; }
    }
  </style>
</head>
<body>
  <div class="background-image"></div>
  <div class="overlay"></div>
  <div class="container">
    <h3>Input Data Pasien</h3>
    <?php if (!empty($success)): ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-select" required>
          <option value="P">Perempuan</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <label>No. Telepon</label>
        <input type="text" name="no_telepon" class="form-control"
               placeholder="08123456789"
               oninput="this.value=this.value.replace(/[^0-9]/g,'')"
               maxlength="15" required>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</body>
</html>
