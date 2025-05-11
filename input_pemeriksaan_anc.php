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

$pasien_data = null;
$error = "";
$success = "";

// Proses ketika form disubmit untuk data ibu dan pemeriksaan ANC
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Input data ibu
    $nama_ibu = $_POST['nama_ibu'];
    $alamat_ibu = $_POST['alamat_ibu'];
    $usia_ibu = $_POST['usia_ibu'];

    // Menyimpan data ibu ke dalam database
    $sql_ibu = "INSERT INTO ibu (nama_ibu, alamat_ibu, usia_ibu) VALUES ('$nama_ibu', '$alamat_ibu', '$usia_ibu')";
    if (mysqli_query($conn, $sql_ibu)) {
        $id_ibu = mysqli_insert_id($conn);  // Mendapatkan ID ibu yang baru saja dimasukkan
        
        // Setelah data ibu disimpan, proses pemeriksaan ANC
        $tanggal_pemeriksaan = $_POST['tanggal_pemeriksaan'];
        $tekanan_darah = $_POST['tekanan_darah'];
        $berat_badan = $_POST['berat_badan'];
        $detak_jantung_janin = $_POST['detak_jantung_janin'];
        $kondisi_janin = $_POST['kondisi_janin'];

        // Insert data pemeriksaan ANC menggunakan id_ibu
        $sql_anc = "INSERT INTO pemeriksaan_anc (id_ibu, tanggal_pemeriksaan, tekanan_darah, berat_badan, detak_jantung_janin, kondisi_janin)
                    VALUES ('$id_ibu', '$tanggal_pemeriksaan', '$tekanan_darah', '$berat_badan', '$detak_jantung_janin', '$kondisi_janin')";
        if (mysqli_query($conn, $sql_anc)) {
            $success = "Data ibu dan pemeriksaan ANC berhasil disimpan.";
            header("Location: input_bayi.php"); // Redirect ke halaman input bayi setelah berhasil
            exit();
        } else {
            $error = "Gagal menyimpan data pemeriksaan ANC: " . mysqli_error($conn);
        }
    } else {
        $error = "Gagal menyimpan data ibu: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Input Data Ibu dan Pemeriksaan Kehamilan (ANC)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    .alert {
      margin-top: 15px;
    }
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
    <h3>Input Data Ibu dan Pemeriksaan Kehamilan (ANC)</h3>
    
    <?php if (!empty($success)): ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="POST">
      <!-- Input Data Ibu -->
      <div class="mb-3">
        <label>Nama Ibu</label>
        <input type="text" name="nama_ibu" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Alamat Ibu</label>
        <input type="text" name="alamat_ibu" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Usia Ibu</label>
        <input type="number" name="usia_ibu" class="form-control" required>
      </div>

      <!-- Input Pemeriksaan ANC -->
      <div class="mb-3">
        <label>Tanggal Pemeriksaan</label>
        <input type="date" name="tanggal_pemeriksaan" class="form-control" required>
      </div>
      
      <div class="mb-3">
        <label>Tekanan Darah</label>
        <input type="text" name="tekanan_darah" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Berat Badan (kg)</label>
        <input type="text" name="berat_badan" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Detak Jantung Janin</label>
        <input type="text" name="detak_jantung_janin" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Kondisi Janin</label>
        <textarea name="kondisi_janin" class="form-control" rows="3" required></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</body>
</html>
