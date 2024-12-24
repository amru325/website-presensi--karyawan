<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #333;
            color: #fff;
            position: fixed;
            left: -250px;
            transition: all 0.3s ease;
        }
        .sidebar.open {
            left: 0;
        }
        .sidebar .menu {
            padding: 40px;
        }
        .sidebar .menu a {
            display: block;
            text-decoration: none;
            color: #fff;
            margin: 10px 0;
            padding: 10px;
            background: #444;
            border-radius: 4px;
        }
        .sidebar .menu a:hover {
            background: #555;
        }
        .sidebar .profile {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
        }
        .sidebar .profile img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .sidebar .profile button {
            padding: 10px;
            background-color: #f00;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .toggle-btn {
            padding: 10px;
            background: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            position: fixed;
            top: 20px;
            left: 20px;
        }
    </style>
</head>
<body>

<?php
// Simulasi data pengguna dari server PHP
$userName = "Tukuo Dimsum";
$profileImage = "https://via.placeholder.com/50";
?>

<button class="toggle-btn" onclick="toggleSidebar()">☰ </button>

<div class="sidebar" id="sidebar">
    <ul class="menu">
            <li><a href="/presensi/admin/home/home.php" class="<?php echo ($currentPage == '/presensi/admin/home/home.php') ? 'active' : ''; ?>">Home</a></li>
      </ul>
    <div class="profile">
        <img src="<?php echo $profileImage; ?>" alt="Profile Image">
        <p><?php echo $userName; ?></p>
        <form action="/presensi/auth/logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

 <!-- Main Content -->
 <div class="main-content sidebar-closed" id="main-content">
    <button class="toggle-btn" id="toggle-btn">☰</button>
  </div>

  <script>
    // JavaScript for Sidebar Toggle
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleBtn = document.getElementById('toggle-btn');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('open');
      mainContent.classList.toggle('sidebar-closed');
    });

    // Logout Function
    function logout() {
      alert('You have logged out!');
      // Add your logout logic here
    }
  </script>
</body>
</html>

