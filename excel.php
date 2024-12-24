<?php

// Include file konfigurasi database
include '../../config.php';

// Set header untuk mendownload file Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Presensi.xls");

// Query untuk mendapatkan data dari tabel absen_masuk dan absen_keluar
$query = "
    SELECT 'Absen Masuk' AS jenis_presensi, nama, telepon, cabang, shift, tanggal, waktu, foto
    FROM absen_masuk
    UNION ALL
    SELECT 'Absen Keluar' AS jenis_presensi, nama, telepon, cabang, shift, tanggal, waktu, foto
    FROM absen_keluar
    ORDER BY tanggal, waktu
";

$result = mysqli_query($connection, $query);

// Buat header tabel di file Excel
echo "<table border='1'>";
echo "<tr>
        <th>No.</th>
        <th>Jenis Presensi</th>
        <th>Nama</th>
        <th>No. Telepon</th>
        <th>Cabang</th>
        <th>Shift</th>
        <th>Tanggal</th>
        <th>Waktu</th>
        <th>Foto</th>
      </tr>";

// Isi data dari database ke dalam tabel
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>{$no}</td>";
    echo "<td>{$row['jenis_presensi']}</td>";
    echo "<td>{$row['nama']}</td>";
    echo "<td>{$row['telepon']}</td>";
    echo "<td>{$row['cabang']}</td>";
    echo "<td>{$row['shift']}</td>";
    echo "<td>{$row['tanggal']}</td>";
    echo "<td>{$row['waktu']}</td>";
    echo "<td>{$row['foto']}</td>"; // Menampilkan nama file foto
    echo "</tr>";
    $no++;
}

echo "</table>";
