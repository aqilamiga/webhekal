<?php
require_once 'not-to-show/connect.php';
require_once 'not-to-show/auth.php';

// Pastikan ada ID yang dikirim
if (!isset($_GET['id'])) {
    die("ID Pelanggan tidak ditemukan.");
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// 1. Ambil data profil pelanggan
$query = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id = '$id'");
if (mysqli_num_rows($query) == 0) {
    die("Data pelanggan tidak ditemukan.");
}
$p = mysqli_fetch_assoc($query);

// 2. Ambil riwayat pangkas dari tabel riwayat_model_rambut
// Diurutkan berdasarkan yang terbaru (descending)
$query_riwayat = mysqli_query($conn, "SELECT * FROM riwayat_model_rambut 
                                     WHERE id_pelanggan = '$id' 
                                     ORDER BY tanggal DESC, waktu DESC");
?>

<style>
    .detail-card { background: #fff; padding: 20px; border-radius: 12px; }
    .profile-header { display: flex; gap: 20px; align-items: center; margin-bottom: 25px; }
    .profile-header img { width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 3px solid #f0f0f0; }
    .info-text h3 { margin: 0; font-size: 20px; color: #333; }
    .info-text p { margin: 5px 0; color: #666; font-size: 14px; }
    .badge-shape { display: inline-block; background: #00B4D8; color: white; padding: 2px 10px; border-radius: 15px; font-size: 12px; font-weight: bold; }

    .history-section { margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px; }
    .history-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .history-table th { text-align: left; font-size: 12px; color: #999; text-transform: uppercase; padding: 10px; border-bottom: 2px solid #f5f5f5; }
    .history-table td { padding: 12px 10px; font-size: 14px; border-bottom: 1px solid #f9f9f9; }
    .model-name { font-weight: 600; color: #333; }
    
    .btn-new-order {
        display: block; width: 100%; text-align: center; background: #333; color: #00B4D8;
        padding: 12px; border-radius: 8px; text-decoration: none; font-weight: bold; margin-top: 20px;
        transition: 0.2s;
    }
    .btn-new-order:hover { background: #000; }
</style>

<div class="detail-card">
    <div class="profile-header">
        <img src="assets/img/pelanggan/<?php echo htmlspecialchars($p['foto']); ?>" 
             onerror="this.src='assets/img/no-image.jpg'">
        <div class="info-text">
            <h3><?= htmlspecialchars($p['nama']) ?></h3>
            <p>📱 <?= htmlspecialchars($p['hp_pelanggan']) ?></p>
            <p><span class="badge-shape"><?= htmlspecialchars($p['bentuk_wajah']) ?></span></p>
        </div>
    </div>

    <div class="history-section">
        <h4 style="margin: 0; color: #333;">Riwayat Model Rambut</h4>
        
        <?php if (mysqli_num_rows($query_riwayat) > 0): ?>
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Tanggal & Waktu</th>
                        <th>Model Rambut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($h = mysqli_fetch_assoc($query_riwayat)): ?>
                    <tr>
                        <td>
                            <div style="font-weight: 500;"><?= date('d/m/Y', strtotime($h['tanggal'])) ?></div>
                            <div style="font-size: 11px; color: #aaa;"><?= $h['waktu'] ?></div>
                        </td>
                        <td>
                            <span class="model-name"><?= htmlspecialchars($h['haircut']) ?></span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="text-align: center; padding: 20px; color: #bbb; font-style: italic; font-size: 13px;">
                Belum ada riwayat pangkas untuk pelanggan ini.
            </div>
        <?php endif; ?>
    </div>

    <a href="haircut.php?id_pelanggan=<?= $id ?>" class="btn-new-order">
        + Pilih Gaya Rambut Baru
    </a>
</div>