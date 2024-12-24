<?php
include('../../config.php'); // Pastikan file config.php sudah di-include dengan benar
include('../layout/sidebar.php');
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Laporan Presensi Mingguan| Tukuo Dimsum</title><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/presensi/assets/css/laporan.css" >
</head>
<body>
    <div class="container">
        <h1>Laporan Kehadiran Mingguan</h1>

        <div class="filter">
            <form method="GET">
                <label for="week">Pilih Minggu:</label>
                <input type="week" id="week" name="week" value="<?= htmlspecialchars($_GET['week'] ?? date('Y-\WW')) ?>">
                <button type="submit">Tampilkan</button>
            </form>
        </div>

        <?php
        // Filter tanggal berdasarkan minggu yang dipilih
        $selected_week = $_GET['week'] ?? date('Y-\WW');
        $year = substr($selected_week, 0, 4);
        $week = substr($selected_week, -2);

        // Hitung tanggal awal dan akhir minggu
        $start_date = date("Y-m-d", strtotime($year . "W" . $week . "1")); // Senin
        $end_date = date("Y-m-d", strtotime($year . "W" . $week . "7")); // Minggu

        // Ambil data dari tabel absen_masuk dan absen_keluar
        $query = "
        SELECT 
            am.nama, 
            am.telepon, 
            am.cabang, 
            am.shift, 
            am.tanggal AS tanggal_masuk, 
            am.waktu AS waktu_masuk, 
            ak.tanggal AS tanggal_keluar, 
            ak.waktu AS waktu_keluar
        FROM absen_masuk am
        LEFT JOIN absen_keluar ak 
        ON am.nama = ak.nama AND am.tanggal = ak.tanggal
        WHERE am.tanggal BETWEEN '$start_date' AND '$end_date'
        ORDER BY am.tanggal DESC, am.waktu DESC
        ";

        $result = mysqli_query($connection, $query);
        ?>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Cabang</th>
                    <th>Shift</th>
                    <th>Tanggal Masuk</th>
                    <th>Waktu Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Waktu Keluar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) === 0): ?>
                    <tr>
                        <td colspan="8">Tidak ada data yang tersedia</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['cabang']); ?></td>
                            <td><?= htmlspecialchars($row['shift']); ?></td>
                            <td>
                                <?= htmlspecialchars($row['tanggal_masuk']); ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($row['waktu_masuk']); ?>
                            </td>
                            <td>
                                <?= isset($row['tanggal_keluar']) ? htmlspecialchars($row['tanggal_keluar']) : '-'; ?>
                            </td>
                            <td>
                                <?= isset($row['waktu_keluar']) ? htmlspecialchars($row['waktu_keluar']) : '-'; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <form action="excel.php" method="POST">
            <input type="hidden" name="start_date" value="<?= $start_date ?>">
            <input type="hidden" name="end_date" value="<?= $end_date ?>">
            <button type="submit" class="export-button">Export ke Excel</button>
        </form>
    </div>
</body>
</html>
