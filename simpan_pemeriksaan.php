<?php
include 'koneksi.php'; // koneksi database

// Ambil data dari form
$id_ibu = $_POST['id_ibu'];
$tanggal_pemeriksaan = $_POST['tanggal_pemeriksaan'];
$tekanan_darah = $_POST['tekanan_darah'];
$berat_badan = $_POST['berat_badan'];
$tinggi_badan = $_POST['tinggi_badan'];
$posisi_janin = $_POST['posisi_janin'];
$detak_janin = $_POST['detak_janin'];
$pemeriksa = $_POST['pemeriksa'];
$keterangan = $_POST['keterangan'];

// Query untuk menyimpan hasil pemeriksaan
$query = "INSERT INTO pemeriksaan (id_ibu, tanggal_pemeriksaan, tekanan_darah, berat_badan, tinggi_badan, posisi_janin, detak_janin, pemeriksa, keterangan) 
          VALUES ('$id_ibu', '$tanggal_pemeriksaan', '$tekanan_darah', '$berat_badan', '$tinggi_badan', '$posisi_janin', '$detak_janin', '$pemeriksa', '$keterangan')";

if (mysqli_query($conn, $query)) {
    echo "Data pemeriksaan berhasil disimpan!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
