<?php
require_once 'not-to-show/connect.php';

$id = intval($_GET['id']);

$sql = "SELECT * FROM kapster WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$data = mysqli_fetch_assoc($result)) {
    echo "<p>Data kapster tidak ditemukan.</p>";
    exit;
}
?>

<style>
    .detail-card {
        margin-top: 20px;
        padding: 20px;
        background: #f7f7f7;
        border-radius: 12px;
        max-width: 400px;
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
        width: 90px;
        color: #555;
    }

    .btn-danger {
        margin-top: 15px;
        padding: 10px 14px;
        background: #e74c3c;
        color: white;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-danger:hover {
        background: #c0392b;
    }
</style>

<div class="detail-card">
    <h3>Detail Kapster</h3>

    <div class="detail-row">
        <strong>Nama</strong>: <?= htmlspecialchars($data['nama']) ?>
    </div>

    <div class="detail-row">
        <strong>No HP</strong>: <?= htmlspecialchars($data['nomor_hp']) ?>
    </div>

    <div class="detail-row">
        <strong>Jabatan</strong>: <?= htmlspecialchars($data['jabatan']) ?>
    </div>

    <form action="../webhekal/not-to-show/hapus_kapster.php" method="POST"
          onsubmit="return confirm('Yakin ingin menghapus kapster ini? Data tidak bisa dikembalikan!');">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <button type="submit" class="btn-danger">Hapus Kapster</button>
    </form>
</div>