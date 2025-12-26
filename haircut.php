<?php
require_once 'not-to-show/connect.php';
require_once 'not-to-show/auth.php';

// 1. Identifikasi Pelanggan
$id_pelanggan = isset($_GET['pelanggan_id']) ? $_GET['pelanggan_id'] : (isset($_GET['id_pelanggan']) ? $_GET['id_pelanggan'] : null);
$shape = '';
$name = '';

if ($id_pelanggan) {
    $res = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id = '$id_pelanggan'");
    $data = mysqli_fetch_assoc($res);
    $shape = $data['bentuk_wajah'];
    $name = $data['nama'];
} else {
    $shape = $_GET['shape'] ?? '';
    $name = $_GET['name'] ?? '';
    $res = mysqli_query($conn, "SELECT id FROM pelanggan WHERE nama = '$name' ORDER BY id DESC LIMIT 1");
    $data = mysqli_fetch_assoc($res);
    $id_pelanggan = $data['id'] ?? null;
}

// 2. Proses Simpan ke riwayat_model_rambut
if (isset($_POST['pilih_haircut'])) {
    $id_model = $_POST['id_model'];
    $nama_model = $_POST['nama_model'];
    $tgl = date('Y-m-d');
    $waktu = date('H:i:s');

    // Menambahkan created_at menggunakan NOW() sesuai field yang Anda ralat sebelumnya
    $sql_riwayat = "INSERT INTO riwayat_model_rambut (id_pelanggan, id_model_rambut, created_at, haircut, tanggal, waktu) 
                    VALUES ('$id_pelanggan', '$id_model', NOW(), '$nama_model', '$tgl', '$waktu')";
    
    if (mysqli_query($conn, $sql_riwayat)) {
        echo "<script>alert('Berhasil memilih haircut!'); window.location.href='datapelanggan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// 2. Proses Simpan ke riwayat_model_rambut & riwayat_kapster
if (isset($_POST['pilih_haircut'])) {
    $id_model = $_POST['id_model'];
    $nama_model = $_POST['nama_model'];
    $id_petugas = $_SESSION['user_id']; // ID Kapster/Owner yang sedang login
    $tgl = date('Y-m-d');
    $waktu = date('H:i:s');

    // Simpan ke riwayat_model_rambut (Data untuk pelanggan)
    $sql_riwayat_model = "INSERT INTO riwayat_model_rambut (id_pelanggan, id_model_rambut, created_at, haircut, tanggal, waktu) 
                          VALUES ('$id_pelanggan', '$id_model', NOW(), '$nama_model', '$tgl', '$waktu')";
    
    // Simpan ke riwayat_kapster (Data performa staf)
    $sql_riwayat_kapster = "INSERT INTO riwayat_kapster (id_kapster, id_pelanggan, created_at) 
                            VALUES ('$id_petugas', '$id_pelanggan', NOW())";

    // Eksekusi kedua query
    if (mysqli_query($conn, $sql_riwayat_model) && mysqli_query($conn, $sql_riwayat_kapster)) {
        echo "<script>alert('Berhasil memilih haircut!'); window.location.href='pelanggan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$query_model = mysqli_query($conn, "SELECT * FROM model_rambut WHERE bentuk_wajah = '$shape'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Haircut - <?= htmlspecialchars($name) ?></title>
    <link rel="stylesheet" href="assets/css/test.css">
    <style>
        .haircut-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; padding: 20px; }
        .haircut-card { border: 1px solid #ddd; border-radius: 10px; overflow: hidden; background: white; text-align: center; padding-bottom: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        
        /* Perbaikan: object-position top agar rambut terlihat */
        .haircut-card img { 
            width: 100%; 
            height: 250px; 
            object-fit: cover; 
            object-position: top; 
        }
        
        .haircut-card h3 { margin: 15px 0; font-size: 18px; color: #333; }
        .btn-pilih { background: #525252; color: #00B4D8; border: none; padding: 10px 20px; border-radius: 20px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .btn-pilih:hover { background: #333; }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <div style="padding: 20px; background: #fff; border-radius: 10px; margin: 20px;">
            <h2 style="margin:0;">Rekomendasi untuk <?= htmlspecialchars($name) ?></h2>
            <p style="color: #666;">Bentuk Wajah: <strong><?= htmlspecialchars($shape) ?></strong></p>
        </div>
        
        <div class="haircut-grid">
            <?php if (mysqli_num_rows($query_model) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($query_model)): ?>
                    <?php 
                        // Logika cek berbagai ekstensi file
                        $exts = ['jpg', 'jpeg', 'png', 'webp'];
                        $gambar = 'assets/img/no-image.jpg'; // default
                        foreach ($exts as $ext) {
                            $path = "assets/img/model_rambut/" . strtolower($shape) . "/" . $row['nama'] . "." . $ext;
                            if (file_exists($path)) {
                                $gambar = $path;
                                break;
                            }
                        }
                    ?>
                    <div class="haircut-card">
                        <img src="<?= $gambar ?>" alt="<?= htmlspecialchars($row['nama']) ?>">
                        <h3><?= htmlspecialchars($row['nama']) ?></h3>
                        <form method="POST">
                            <input type="hidden" name="id_model" value="<?= $row['id'] ?>">
                            <input type="hidden" name="nama_model" value="<?= htmlspecialchars($row['nama']) ?>">
                            <button type="submit" name="pilih_haircut" class="btn-pilih">Pilih Model Ini</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="padding: 20px;">Belum ada data model rambut untuk bentuk wajah ini.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>