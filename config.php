<?php
// Database connection
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "presensi";

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(!$connection) {
    echo "Koneksi ke database gagal: " . mysqli_connect_error();
}

// Fungsi untuk mendapatkan base URL
function base_url($url = null) {
    $base_url = 'http://localhost/presensi'; // Pastikan base URL sesuai dengan lokasi proyek Anda
    if($url != null) {
        return $base_url . '/' . $url;
    } else {
        return $base_url;
    }
}
?>
