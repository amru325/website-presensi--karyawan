<?php
// Koneksi ke database
$judul = "Data Absen Bulanan";
include('../layout/sidebar.php');
require_once('../../config.php');

header("Content-Type: text/html; charset=UTF-8");
date_default_timezone_set('Asia/Jakarta'); // Set timezone ke Asia/Jakarta

// Mendapatkan bulan dan tahun dari input pengguna atau default ke bulan saat ini
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
list($tahun, $bulanAngka) = explode('-', $bulan);

// Query SQL untuk menggabungkan absen_masuk dan absen_keluar berdasarkan bulan
$query = "
    SELECT 
        nama, 
        telepon AS no_telepon, 
        cabang, 
        shift, 
        tanggal, 
        waktu,
        foto,
        'Masuk' AS status
    FROM absen_masuk
    WHERE MONTH(tanggal) = $bulanAngka AND YEAR(tanggal) = $tahun
    UNION ALL
    SELECT 
        nama, 
        telepon AS no_telepon, 
        cabang, 
        shift, 
        tanggal, 
        waktu,
        foto,
        'Keluar' AS status
    FROM absen_keluar
    WHERE MONTH(tanggal) = $bulanAngka AND YEAR(tanggal) = $tahun
    ORDER BY tanggal DESC, waktu DESC
";

$result = mysqli_query($connection, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Riwayat Absen Bulanan| Tukuo Dimsum</title><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/presensi/assets/css/riwayat.css" >
</head>
<body>
    <div class="container">
        <h1>Riwayat Absen Bulanan</h1>

        <!-- Form untuk memilih bulan -->
        <form class="filter-form" method="GET" action="">
            <label for="bulan">Pilih Bulan:</label>
            <input type="month" name="bulan" id="bulan" value="<?= htmlspecialchars($bulan); ?>">
            <button type="submit">Tampilkan</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No Telepon</th>
                    <th>Cabang</th>
                    <th>Shift</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) === 0): ?>
                    <tr>
                        <td colspan="9">Tidak ada data tersedia untuk bulan ini</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['no_telepon']); ?></td>
                            <td><?= htmlspecialchars($row['cabang']); ?></td>
                            <td><?= htmlspecialchars($row['shift']); ?></td>
                            <td><?= htmlspecialchars($row['tanggal']); ?></td>
                            <td><?= htmlspecialchars($row['waktu']); ?></td>
                            <td><?= htmlspecialchars($row['status']); ?></td>
                            <td>
                                <?php if (!empty($row['foto'])): ?>
                                    <img src="/presensi/pegawai/uploads/<?= htmlspecialchars($row['foto']); ?>" alt="Foto Absen" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                <?php else: ?>
                                    <span>Tidak Ada Foto</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
