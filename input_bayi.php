<?php
session_start();
$conn = mysqli_connect("localhost","root","","kesehatan_ibu_anak");
if (!$conn) die("Koneksi gagal: ".mysqli_connect_error());

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $id_ibu        = $_POST['id_ibu'];
    $nama_bayi     = mysqli_real_escape_string($conn,$_POST['nama_bayi']);
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jk            = $_POST['jenis_kelamin']; // 'L' atau 'P'
    $berat         = $_POST['berat_lahir'];
    $tinggi        = $_POST['tinggi_lahir'];

    if ($id_ibu && $nama_bayi && $tanggal_lahir && $jk && $berat && $tinggi) {
        $ins = "INSERT INTO bayi
                (nama_bayi,tanggal_lahir,jenis_kelamin,berat_lahir,tinggi_lahir,id_ibu)
                VALUES
                ('$nama_bayi','$tanggal_lahir','$jk','$berat','$tinggi','$id_ibu')";
        if (mysqli_query($conn,$ins)) {
            header("Location: input_imunisasi.php");
            exit;
        } else {
            $error = "Gagal simpan: " . mysqli_error($conn);
        }
    } else {
        $error = "Semua kolom wajib diisi.";
    }
}

$ibu_q = mysqli_query($conn,
    "SELECT ibu.id_ibu, pasien.nama AS nama_ibu 
     FROM ibu JOIN pasien ON ibu.id_pasien=pasien.id_pasien"
) or die(mysqli_error($conn));

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Input Data Bayi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('foto/input.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }
    .form-container {
      background: rgba(255,255,255,0.95);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 500px;
    }
    .form-container h3 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    .form-control, .form-select {
      margin-bottom: 15px;
      border-radius: 5px;
    }
    .btn-submit {
      width: 100%;
      padding: 10px;
      background-color: #4e73df;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 16px;
    }
    .btn-submit:hover {
      background-color: #2e59d9;
    }
    .alert {
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h3>Input Data Bayi</h3>
    <?php if(!empty($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif ?>
    <form method="POST">
      <select name="id_ibu" class="form-select" required>
        <option value="">-- Pilih Ibu --</option>
        <?php while($r=mysqli_fetch_assoc($ibu_q)): ?>
          <option value="<?= $r['id_ibu'] ?>"><?= htmlspecialchars($r['nama_ibu']) ?></option>
        <?php endwhile ?>
      </select>
      <input type="text" name="nama_bayi" class="form-control" placeholder="Nama Bayi" required>
      <input type="date" name="tanggal_lahir" class="form-control" required>
      <select name="jenis_kelamin" class="form-select" required>
        <option value="">-- Jenis Kelamin --</option>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
      </select>
      <input type="number" name="berat_lahir" class="form-control" placeholder="Berat (kg)" step="0.1" required>
      <input type="number" name="tinggi_lahir" class="form-control" placeholder="Tinggi (cm)" step="0.1" required>
      <button type="submit" class="btn-submit">Simpan</button>
    </form>
  </div>
</body>
</html>
