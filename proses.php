<?php
include("../../config.php");
// cek apakah tombol tambah sudah diklik atau belum
if(isset($_POST['submit'])){

    // ambil data dari formulir
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $cabang = $_POST['cabang'];
    $shift = $_POST['shift'];
    $tanggal = date('Y-m-d'); // tanggal saat ini
    date_default_timezone_set('Asia/Jakarta');
    $waktu = date('H:i:s'); // waktu saat ini

    $foto = $_FILES['foto']['name'];
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/presensi/pegawai/uploads/";
    $target_file = $target_dir . basename($foto);


    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
        $query = "INSERT INTO absen_masuk (nama, telepon, cabang, shift, foto, tanggal, waktu) 
                  VALUES ('$nama', '$telepon', '$cabang', '$shift', '$foto', '$tanggal', '$waktu')";
        $connection->query($query);
    }

    // apakah query simpan berhasil
    if($query) {
        // kalau berhasil alihkan ke halaman riwayat.php dengan status=sukses
        header('Location: /presensi/pegawai/riwayat/riwayat.php?status=sukses');
    } else {
        // kalau gagal alihkan ke halaman riwayat.php dengan status=gagal
        header('Location: /presensi/pegawai/riwayat/riwayat.php?status=gagal');

    }

} else {
    die("Akses dilarang...");
}
?>