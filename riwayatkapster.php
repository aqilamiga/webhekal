<?php
require_once 'not-to-show/connect.php';
require_once 'not-to-show/auth.php';

/*
SESSION:
$_SESSION['user_id'] = id kapster
*/

$id_kapster = (int) $_SESSION['user_id'];

/* =========================
   VALIDASI ROLE
   ========================= */
$qUser = $conn->prepare("
    SELECT nama, jabatan
    FROM kapster
    WHERE id = ?
");
$qUser->bind_param("i", $id_kapster);
$qUser->execute();
$user = $qUser->get_result()->fetch_assoc();

if (!$user) {
    die("Kapster tidak ditemukan.");
}

if ($user['jabatan'] !== 'kapster') {
    die("Akses ditolak. Halaman ini hanya untuk kapster.");
}

/* =========================
   QUERY RIWAYAT POTONG
   ========================= */
$sql = "
    SELECT
        p.nama AS nama_pelanggan,
        mr.nama AS model_rambut,
        rk.created_at AS waktu_potong
    FROM riwayat_kapster rk
    JOIN pelanggan p 
        ON rk.id_pelanggan = p.id
    LEFT JOIN riwayat_model_rambut rm 
        ON rm.id_pelanggan = p.id
    LEFT JOIN model_rambut mr 
        ON rm.id_model_rambut = mr.id
    WHERE rk.id_kapster = ?
    ORDER BY rk.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_kapster);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Potong Rambut</title>
    <link rel="stylesheet" href="assets/css/test.css">
    <link rel="stylesheet" href="assets/css/pelanggan.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h2 class="page-title">
            Riwayat Potong Rambut – <?= htmlspecialchars($user['nama']) ?>
        </h2>
        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pelanggan</th>
                        <th>Model Rambut</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                <td><?= htmlspecialchars($row['model_rambut'] ?? '-') ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($row['waktu_potong'])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align:center;">
                                Belum ada riwayat potong rambut
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>