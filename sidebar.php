<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$nama = $_SESSION["nama"];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/test.css" />
</head>

<body>
    <div class="app">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="user-card">
                <div class="avatar">👤</div>
                <div>
                    <div class="role"><?= htmlspecialchars($nama) ?></div>
                    <div class="sub"><?= ucfirst(htmlspecialchars($role)) ?></div>
                </div>
            </div>

            <?php if ($role === "owner"): ?>
            <nav class="nav">
                <a class="nav-item" href="datapelanggan.php">📝 Input dan Pilih Customer</a>
                <a class="nav-item" href="rekomendasi.php">💇‍♂️ Rekomendasi Model Rambut</a>
                <a class="nav-item" href="list_haircut.php">💾 Data Haircut</a>
                <a class="nav-item" href="caripelanggan.php">📇 Data Customer</a>
                <a class="nav-item" href="fullkapster.php">🔐 Record Akses Kapster</a>
                <a class="nav-item" href="tambahkapster.php">➕ Tambah Akses Kapster</a>
            </nav>
            
            <?php elseif ($role === "kapster"): ?>
            <nav class="nav">
                <a class="nav-item" href="datapelanggan.php">📝 Input dan Pilih Customer</a>
                <a class="nav-item" href="haircut.php">💇‍♂️ Rekomendasi Model Rambut</a>
                <a class="nav-item" href="list_haircut.php">💾 Data Haircut</a>
                <a class="nav-item" href="caripelanggan.php">📇 Data Customer</a>
                <a class="nav-item" href="riwayatkapster.php">🔐 Data Pribadi Kapster</a>
            </nav>

            <?php endif; ?>

            <!-- BAGIAN LOGOUT PALING BAWAH -->
            <a href="not-to-show/logout.php" class="logout-btn">
                <span class="nav-icon">⎋</span>
                Logout
            </a>
        </aside>
    </div>
</body>

</html>