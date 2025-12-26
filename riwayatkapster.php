<?php
require_once 'not-to-show/connect.php';
require_once 'not-to-show/auth.php';

$id_login = $_SESSION['user_id'];
$nama_login = $_SESSION['nama'];
$role = $_SESSION['role'];

// Query untuk menghitung berapa kali tiap pelanggan dipotong oleh staf ini
// Menggunakan COUNT dan GROUP BY
$query = "SELECT p.nama as nama_pelanggan, p.hp_pelanggan, COUNT(rk.id) as total_layanan, MAX(rk.created_at) as terakhir_pada
          FROM riwayat_kapster rk
          JOIN pelanggan p ON rk.id_pelanggan = p.id
          WHERE rk.id_kapster = '$id_login'
          GROUP BY rk.id_pelanggan
          ORDER BY terakhir_pada DESC";

if ($role === 'owner') {
    // Owner melihat semua staf
    $query = "SELECT k.nama as nama_staf, p.nama as nama_pelanggan, COUNT(rk.id) as total_layanan ... 
              FROM riwayat_kapster rk 
              JOIN kapster k ON rk.id_kapster = k.id ...";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat Pekerjaan Saya</title>
    <link rel="stylesheet" href="assets/css/test.css">
    <style>
        .stats-card { background: #fff; padding: 20px; border-radius: 10px; margin: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #f8f9fa; padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        .badge-count { background: #00B4D8; color: #fff; padding: 2px 8px; border-radius: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <div class="stats-card">
            <h2>Riwayat Pekerjaan: <?= htmlspecialchars($nama_login) ?></h2>
            <p>Berikut adalah daftar pelanggan yang pernah Anda layani:</p>

            <table>
                <thead>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>Nomor HP</th>
                        <th>Frekuensi Potong</th>
                        <th>Terakhir Melayani</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($row['nama_pelanggan']) ?></strong></td>
                                <td><?= htmlspecialchars($row['hp_pelanggan']) ?></td>
                                <td><span class="badge-count"><?= $row['total_layanan'] ?> x</span></td>
                                <td><?= date('d M Y, H:i', strtotime($row['terakhir_pada'])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4" style="text-align:center;">Anda belum pernah mencatat aktivitas potong rambut.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>