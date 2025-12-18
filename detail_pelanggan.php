<?php
require_once './not-to-show/connect.php';

$id = $_GET['id'];

$sql = "SELECT * FROM pelanggan WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
?>

<h3>Detail Customer</h3>
<p><strong>Nama:</strong> <?= $data['nama']; ?></p>
<p><strong>No HP:</strong> <?= $data['hp_pelanggan']; ?></p>
<p><strong>Bentuk Wajah:</strong> <?= $data['bentuk_wajah']; ?></p>
<p><strong>Foto:</strong></p>
<img src="<?= $data['foto']; ?>" alt="foto">