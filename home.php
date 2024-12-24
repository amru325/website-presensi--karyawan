<?php 
require_once('../../config.php') ?>
<?php 
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'admin') {
    header("Location: ../../auth/login.php?pesan=tolak_akses");
}

$judul = "Home";
include('../layout/sidebar.php'); ?>

<!-- Page body -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absen</title>
    <title>Presensi Pegawai | Tukuo Dimsum</title><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/presensi/assets/css/homea.css" >
</head>
<body>
    <div class="page-body">
        <div class="container-xl">
                <div class="col-sm-6 col-lg-3">
                    <a href="<?= base_url(url: 'admin/riwayat/riwayat.php')?>" class="card">
                        <div class="card-body">
                            <div class="icon-lg text-info">&#x1F4C4;</div>
                            <h3>Riwayat</h3>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a href="<?= base_url(url: 'admin/laporan/laporan.php')?>" class="card">
                        <div class="card-body">
                            <div class="icon-lg text-primary">&#x1F4CA;</div>
                            <h3>Laporan</h3>
                        </div>
                        <?php if(isset($_GET['status'])): ?>
        <div class="notification <?php echo $_GET['status'] == 'sukses' ? 'success' : 'error'; ?>">
            <p>
                <?php
                    if($_GET['status'] == 'sukses'){
                        echo "Berhasil login!";
                    } else {
                        echo "Login gagal!";
                    }
                ?>
            </p>
        </div>
<?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

