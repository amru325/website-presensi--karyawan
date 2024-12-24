<?php 
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: ../../auth/login.php?pesan=belum_login");
}else if($_SESSION["role"] != 'pegawai') {
    header("Location: ../../auth/login.php?pesan=tolak_akses");
}

$judul = "Absen Keluar";
include('../layout/sidebar.php');
include('../../config.php');
date_default_timezone_set('Asia/Jakarta');

$result = mysqli_query($connection, "SELECT * FROM absen_keluar ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Keluar| Tukuo Dimsum</title><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/presensi/assets/css/am.css" >
</head>
<body>
    <div class="form-container">
        <h2>Absen Keluar</h2>
        <form action="proses.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required>
            </div>

            <div class="form-group">
                <label for="telepom">No Telepon:</label>
                <input type="tel" id="telepon" name="telepon" required>
            </div>

            <div class="form-group">
                <label for="cabang">Cabang:</label>
                <select id="cabang" name="cabang" required>
                    <option value="">Pilih Cabang</option>
                    <option value="Cabang Ngembal">Cabang Ngembal</option>
                    <option value="Cabang Burikan">Cabang Burikan</option>
                    <option value="Cabang Alun-Alun">Cabang Alun-Alun</option>
                    <option value="Cabang Alun-Alun">Cabang Bulung</option>
                    <option value="Cabang Alun-Alun">Cabang Stain</option>
                    <option value="Cabang Alun-Alun">Cabang Gebog</option>
                </select>
            </div>

            <div class="form-group">
                <label for="shift">Shift:</label>
                <select id="shift" name="shift" required>
                    <option value="">Pilih Shift</option>
                    <option value="Pagi">Pagi</option>
                    <option value="Siang">Siang</option>
                </select>
            </div>

            <div class="form-group">
                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>
            </div>

            <div class="form-group">
                <button type="submit" name="submit">Submit</button>
            </div>
        </form>

        <div class="timestamp">
            <p>Tanggal: <span id="tanggal"></span></p>
            <p>Waktu: <span id="waktu"></span></p>
        </div>
    </div>

    <script>
    function updateTimestamp() {
        // Membuat objek Date baru dengan waktu saat ini
        const now = new Date();

        // Opsi format untuk tanggal dan waktu
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            timeZone: 'Asia/Jakarta', // Zona waktu WIB (UTC+7)
            timeZoneName: 'short'
        };

        // Mengonversi tanggal dan waktu ke format lokal Indonesia dengan zona waktu WIB
        const tanggalDanWaktu = now.toLocaleString('id-ID', options);

        // Memisahkan tanggal dan waktu
        const [tanggal, waktu] = tanggalDanWaktu.split(' pukul ');

        // Menampilkan tanggal dan waktu di elemen HTML
        document.getElementById('tanggal').textContent = tanggal;
        document.getElementById('waktu').textContent = waktu;
    }

    // Memperbarui timestamp saat halaman dimuat
    updateTimestamp();

    // Memperbarui setiap detik
    setInterval(updateTimestamp, 1000);
</script>


</body>