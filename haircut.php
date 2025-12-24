<?php
require_once 'not-to-show/connect.php';
require_once 'not-to-show/auth.php';

// 1. Identifikasi Pelanggan (Bisa dari input baru atau list lama)
$id_pelanggan = isset($_GET['pelanggan_id']) ? $_GET['pelanggan_id'] : null;
$shape = '';
$name = '';

if ($id_pelanggan) {
    $res = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id = '$id_pelanggan'");
    $data = mysqli_fetch_assoc($res);
    $shape = $data['bentuk_wajah'];
    $name = $data['nama'];
} else {
    // Jika datang dari form input baru (lewat URL params)
    $shape = $_GET['shape'];
    $name = $_GET['name'];
    // Cari ID-nya berdasarkan nama & hp (asumsi data unik)
    $res = mysqli_query($conn, "SELECT id FROM pelanggan WHERE nama = '$name' ORDER BY id DESC LIMIT 1");
    $data = mysqli_fetch_assoc($res);
    $id_pelanggan = $data['id'];
}

// 2. Proses Simpan ke riwayat_model_rambut
if (isset($_POST['pilih_haircut'])) {
    $id_model = $_POST['id_model'];
    $nama_model = $_POST['nama_model'];
    $tgl = date('Y-m-d');
    $waktu = date('H:i:s');

    $sql_riwayat = "INSERT INTO riwayat_model_rambut (id_pelanggan, id_model_rambut, haircut, tanggal, waktu) 
                    VALUES ('$id_pelanggan', '$id_model', '$nama_model', '$tgl', '$waktu')";
    
    if (mysqli_query($conn, $sql_riwayat)) {
        echo "<script>alert('Berhasil memilih haircut!'); window.location.href='pelanggan.php';</script>";
    }
}

$query_model = mysqli_query($conn, "SELECT * FROM model_rambut WHERE bentuk_wajah = '$shape'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pilih Haircut - <?= $name ?></title>
    <link rel="stylesheet" href="assets/css/test.css">
    <style>
        .haircut-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; padding: 20px; }
        .haircut-card { border: 1px solid #ddd; border-radius: 10px; overflow: hidden; background: white; text-align: center; padding-bottom: 15px; }
        .haircut-card img { width: 100%; height: 200px; object-fit: cover; }
        .btn-pilih { background: #00B4D8; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h2>Rekomendasi untuk <?= htmlspecialchars($name) ?> (Wajah: <?= htmlspecialchars($shape) ?>)</h2>
        
        <div class="haircut-grid">
            <?php while($row = mysqli_fetch_assoc($query_model)): ?>
                <div class="haircut-card">
                    <img src="assets/img/model_rambut/<?= $shape ?>/<?= $row['nama'] ?>.jpg" alt="Foto">
                    <h3><?= $row['nama'] ?></h3>
                    <form method="POST">
                        <input type="hidden" name="id_model" value="<?= $row['id'] ?>">
                        <input type="hidden" name="nama_model" value="<?= $row['nama'] ?>">
                        <button type="submit" name="pilih_haircut" class="btn-pilih">Pilih Model Ini</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>