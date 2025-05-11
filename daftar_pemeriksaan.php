<?php
include 'koneksi.php'; // koneksi database

$query = "SELECT p.*, i.nama FROM pemeriksaan p JOIN ibu i ON p.id_ibu = i.id";
$result = mysqli_query($conn, $query);

echo "<table border='1'>
        <tr>
            <th>Nama Ibu</th>
            <th>Tanggal Pemeriksaan</th>
            <th>Tekanan Darah</th>
            <th>Berat Badan</th>
            <th>Tinggi Badan</th>
            <th>Posisi Janin</th>
            <th>Detak Janin</th>
            <th>Pemeriksa</th>
            <th>Keterangan</th>
        </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>" . $row['nama'] . "</td>
            <td>" . $row['tanggal_pemeriksaan'] . "</td>
            <td>" . $row['tekanan_darah'] . "</td>
            <td>" . $row['berat_badan'] . "</td>
            <td>" . $row['tinggi_badan'] . "</td>
            <td>" . $row['posisi_janin'] . "</td>
            <td>" . $row['detak_janin'] . "</td>
            <td>" . $row['pemeriksa'] . "</td>
            <td>" . $row['keterangan'] . "</td>
          </tr>";
}

echo "</table>";
?>
