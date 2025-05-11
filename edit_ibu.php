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

// Proses edit data ibu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_ibu = $_POST['id_ibu'];
    $nama = $_POST['nama'];
    $usia_kehamilan = $_POST['usia_kehamilan'];
    $status_kehamilan = $_POST['status_kehamilan'];

    $query = "UPDATE ibu SET nama='$nama', usia_kehamilan='$usia_kehamilan', status_kehamilan='$status_kehamilan' WHERE id_ibu='$id_ibu'";

    if (mysqli_query($conn, $query)) {
        echo "Data ibu berhasil diperbarui!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Ambil data ibu berdasarkan ID
$id_ibu = $_GET['id_ibu'];
$query = "SELECT * FROM ibu WHERE id_ibu='$id_ibu'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Ibu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Edit Data Ibu</h2>
        <form action="edit_ibu.php" method="POST">
            <input type="hidden" name="id_ibu" value="<?php echo htmlspecialchars($row['id_ibu']); ?>">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Ibu</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="usia_kehamilan" class="form-label">Usia Kehamilan (minggu)</label>
                <input type="number" class="form-control" id="usia_kehamilan" name="usia_kehamilan" value="<?php echo htmlspecialchars($row['usia_kehamilan']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="status_kehamilan" class="form-label">Status Kehamilan</label>
                <input type="text" class="form-control" id="status_kehamilan" name="status_kehamilan" value="<?php echo htmlspecialchars($row['status_kehamilan']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Perbarui Data</button>
        </form>
    </div>
</body>
</html>
