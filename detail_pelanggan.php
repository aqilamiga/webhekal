<?php
require_once 'not-to-show/connect.php';

// Pastikan ID ada
if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);

// Ambil data pelanggan
$sql = "SELECT * FROM pelanggan WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$data = mysqli_fetch_assoc($result)) {
    echo "<p>Data pelanggan tidak ditemukan.</p>";
    exit;
}

// --- PENGATURAN PATH GAMBAR ---
// __DIR__ akan menghasilkan C:\xampp\htdocs\webhekal
$root_path = __DIR__; 
$nama_file = $data['foto'];

// Lokasi fisik untuk file_exists (Windows style) - jika beda pc, tambahkan public_html sebelum assets
$file_fisik = $root_path . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "pelanggan" . DIRECTORY_SEPARATOR . $nama_file;

// Lokasi URL untuk tag <img>
$url_gambar = "assets/img/pelanggan/" . $nama_file;
?>

<style>
    .detail-card {
        margin-top: 20px;
        padding: 20px;
        background: #f7f7f7;
        border-radius: 12px;
        max-width: 400px;
        font-family: sans-serif;
    }

    .detail-card h3 {
        margin-bottom: 15px;
        font-size: 18px;
        color: #333;
    }

    .detail-row {
        margin-bottom: 10px;
        font-size: 14px;
    }

    .detail-row strong {
        display: inline-block;
        width: 100px;
        color: #555;
    }

    .detail-img-wrapper {
        margin-top: 15px;
        background: #fff;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .detail-img {
        width: 100%;
        max-width: 300px;
        border-radius: 5px;
    }

    .no-photo {
        font-size: 12px;
        color: #999;
        padding: 20px;
    }

    .btn-danger {
        margin-top: 15px;
        padding: 10px 14px;
        background: #e74c3c;
        color: white;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        width: 100%;
    }
</style>

<div class="detail-card">
    <h3>Detail Pelanggan</h3>

    <div class="detail-row">
        <strong>Nama</strong>: <?= htmlspecialchars($data['nama']) ?>
    </div>

    <div class="detail-row">
        <strong>No HP</strong>: <?= htmlspecialchars($data['hp_pelanggan']) ?>
    </div>

    <div class="detail-row">
        <strong>Bentuk Wajah</strong>: <?= htmlspecialchars($data['bentuk_wajah']) ?>
    </div>

    <div class="detail-img-wrapper">
        <?php if (!empty($nama_file) && file_exists($file_fisik)): ?>
            <img src="<?= $url_gambar ?>" alt="Foto Wajah" class="detail-img">
        <?php else: ?>
            <div class="no-photo">
                <b>Foto tidak ditemukan di folder.</b><br>
                <small>Nama file di DB: <?= htmlspecialchars($nama_file) ?></small><br>
                <small style="font-size: 10px; color: #cc0000;">Path dicari: <?= $file_fisik ?></small>
            </div>
        <?php endif; ?>
    </div>

    <form action="not-to-show/hapus_pelanggan.php" method="POST"
          onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?');">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <button type="submit" class="btn-danger">Hapus Pelanggan</button>
    </form>
</div>