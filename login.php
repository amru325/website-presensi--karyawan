<?php 
session_start();

require_once('../config.php');

if(isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($connection, "SELECT * FROM users JOIN pegawai ON users.id_pegawai = pegawai.id WHERE username = '$username'");

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row["password"])) {
        if($row['status'] == 'Aktif') {

          $_SESSION["login"] = true;
          $_SESSION['id'] = $row['id'];
          $_SESSION['role'] = $row['role'];
          $_SESSION['nama'] = $row['nama'];
          $_SESSION['nip'] = $row['nip'];
          $_SESSION['jabatan'] = $row['jabatan'];
          $_SESSION['lokasi_presensi'] = $row['lokasi_presensi'];

          if($row['role'] === 'admin') {
            header("Location: ../admin/home/home.php");
            exit();
          }else{
            header("Location: ../pegawai/home/home.php");
            exit();
          }
        }else{
          $_SESSION["gagal"] = "Akun anda belum aktif";
        }
    } else {
      $_SESSION["gagal"] = "Password salah, silahkan coba lagi";
    }
  } else {
    $_SESSION["gagal"] = "Username salah, silahkan coba lagi";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="/presensi/assets/css/login.css" >
</head>
<body>
  <div class="page-center">
    <!-- Left Side - Login Form -->
    <div class="login-container">
      <h2>Login to Your Account</h2>
      <form method="POST" action="">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
        </div>
        <button type="submit" name="login" class="btn-primary">Sign in</button>
      </form>
    </div>

    <!-- Right Side - Image -->
    <div class="image-container">
      <img src="/presensi/assets/img/dimsumtukuO.png" alt="Image">
    </div>
  </div>
</body>
</html>
