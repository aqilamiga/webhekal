<?php
require_once 'not-to-show/connect.php';

if (!isset($_GET['id'])) {
    echo "<p>ID kapster tidak valid.</p>";
    exit;
}

$id_kapster = (int) $_GET['id'];

/* =========================
   AMBIL DATA KAPSTER
   ========================= */
$qKapster = mysqli_query(
    $conn,
    "SELECT id, nama, nomor_hp, jabatan 
     FROM kapster 
     WHERE id = $id_kapster"
);

$kapster = mysqli_fetch_assoc($qKapster);

if (!$kapster) {
    echo "<p>Data kapster tidak ditemukan.</p>";
    exit;
}

/* =========================
   TOTAL POTONG RAMBUT
   ========================= */
$qTotal = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total 
     FROM riwayat_kapster 
     WHERE id_kapster = $id_kapster"
);

$total = mysqli_fetch_assoc($qTotal)['total'] ?? 0;

/* =========================
   RIWAYAT POTONG
   ========================= */
$qRiwayat = mysqli_query(
    $conn,
    "SELECT 
        pelanggan.nama AS nama_pelanggan,
        riwayat_kapster.created_at
     FROM riwayat_kapster
     JOIN pelanggan 
        ON pelanggan.id = riwayat_kapster.id_pelanggan
     WHERE riwayat_kapster.id_kapster = $id_kapster
     ORDER BY riwayat_kapster.created_at DESC"
);
?>

<style>
.detail-card {
    margin-top: 20px;
    padding: 20px;
    background: #f7f7f7;
    border-radius: 12px;
    max-width: 500px;
}
.detail-row {
    margin-bottom: 10px;
    font-size: 14px;
}
.detail-row strong {
    display: inline-block;
    width: 140px;
}
.riwayat-list {
    margin-top: 15px;
    font-size: 14px;
}
.riwayat-item {
    padding: 6px 0;
    border-bottom: 1px solid #ddd;
}
</style>

<div class="detail-card">
    <h3>Detail Kapster</h3>

    <div class="detail-row">
        <strong>Nama</strong>: <?= htmlspecialchars($kapster['nama']) ?>
    </div>

    <div class="detail-row">
        <strong>No HP</strong>: <?= htmlspecialchars($kapster['nomor_hp']) ?>
    </div>

    <div class="detail-row">
        <strong>Jabatan</strong>: <?= htmlspecialchars($kapster['jabatan']) ?>
    </div>

    <div class="detail-row">
        <strong>Total Potong Rambut</strong>: <?= $total ?>
    </div>

    <h4>Riwayat Potong</h4>

    <div class="riwayat-list">
        <?php if (mysqli_num_rows($qRiwayat) > 0): ?>
            <?php while ($r = mysqli_fetch_assoc($qRiwayat)): ?>
                <div class="riwayat-item">
                    <?= htmlspecialchars($r['nama_pelanggan']) ?>
                    <br>
                    <small><?= $r['created_at'] ?></small>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Belum ada riwayat potong.</p>
        <?php endif; ?>
    </div>
</div>
