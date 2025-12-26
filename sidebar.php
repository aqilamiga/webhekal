<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$nama = $_SESSION["nama"] ?? 'User';
$role = $_SESSION['role'] ?? 'guest';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/test.css" />
    <style>
        /* CSS Tambahan agar SVG rapi berdampingan dengan teks */
        .nav-item, .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px; /* Jarak antara icon dan teks */
            text-decoration: none;
        }

        .icon-svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            fill: currentColor; /* Agar warna icon mengikuti warna teks */
        }

        .avatar-svg {
            width: 32px;
            height: 32px;
            fill: #00B4D8;
        }
    </style>
</head>

<body>
    <div class="app">
        <aside class="sidebar">
            <div class="user-card">
                <div class="avatar">
                    <svg class="avatar-svg" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" opacity="0.2"/>
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div>
                    <div class="role"><?= htmlspecialchars($nama) ?></div>
                    <div class="sub"><?= ucfirst(htmlspecialchars($role)) ?></div>
                </div>
            </div>

            <nav class="nav">
                <?php if ($role === "owner"): ?>
                    <a class="nav-item" href="datapelanggan.php">
                        <img src="assets/logo/write.svg" class="icon-svg" alt="icon">
                        <span>Input dan Pilih Customer</span>
                    </a>
                    
                    <a class="nav-item" href="list_haircut.php">
                        <img src="assets/logo/save.svg" class="icon-svg" alt="icon">
                        <span>Data Haircut</span>
                    </a>

                    <a class="nav-item" href="caripelanggan.php">
                        <img src="assets/logo/data.svg" class="icon-svg" alt="icon">
                        <span>Data Customer</span>
                    </a>

                    <a class="nav-item" href="fullkapster.php">
                        <img src="assets/logo/profile.svg" class="icon-svg" alt="icon">
                        <span>Record Akses Kapster</span>
                    </a>

                    <a class="nav-item" href="tambahkapster.php">
                        <img src="assets/logo/plus.svg" class="icon-svg" alt="icon">
                        <span>Tambah Akses Kapster</span>
                    </a>
                
                <?php elseif ($role === "kapster"): ?>
                    <a class="nav-item" href="datapelanggan.php">
                        <img src="assets/logo/write.svg" class="icon-svg" alt="icon">
                        <span>Input dan Pilih Customer</span>
                    </a>

                    <a class="nav-item" href="list_haircut.php">
                        <img src="assets/logo/save.svg" class="icon-svg" alt="icon">
                        <span>Data Haircut</span>
                    </a>

                    <a class="nav-item" href="caripelanggan.php">
                        <img src="assets/logo/data.svg" class="icon-svg" alt="icon">
                        <span>Data Customer</span>
                    </a>

                    <a class="nav-item" href="riwayatkapster.php">
                        <img src="assets/logo/profile.svg" class="icon-svg" alt="icon">
                        <span>Data Pribadi Kapster</span>
                    </a>
                <?php endif; ?>
            </nav>

            <a href="not-to-show/logout.php" class="logout-btn">
                <svg class="icon-svg" viewBox="0 0 24 24">
                    <path d="M16 17v-3H9v-4h7V7l5 5-5 5M14 2a2 2 0 012 2v2h-2V4H5v16h9v-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h9z"/>
                </svg>
                Logout
            </a>
        </aside>
    </div>
</body>
</html>