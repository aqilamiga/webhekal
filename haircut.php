<?php

require_once 'connect.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $hp_pelanggan = $_POST['hp_pelanggan'];
    $bentuk_wajah = $_POST['bentuk_wajah'];
    $sql = "INSERT INTO pelanggan (nama, hp_pelanggan, bentuk_wajah) VALUES ('$nama', '$hp_pelanggan', '$bentuk_wajah')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data kapster berhasil ditambahkan.'); window.location.href='data_kapster.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Register Akun</title>
    <link rel="stylesheet" href="./assets/css/test.css" />
</head>

<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        <main class="content">
            
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>