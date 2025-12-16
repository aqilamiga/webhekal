<?php
require_once './not-to-show/connect.php';

$id = $_GET['id'];

$sql = "SELECT * FROM kapster WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
?>

<h3>Detail Customer</h3>
<p><strong>Nama:</strong> <?= $data['nama']; ?></p>
<p><strong>No HP:</strong> <?= $data['nomor_hp']; ?></p>
<p><strong>Jabatan:</strong> <?= $data['jabatan']; ?></p>