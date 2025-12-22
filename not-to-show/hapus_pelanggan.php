<?php
require_once 'connect.php';
require_once 'auth.php';

if (!isset($_POST['id'])) {
    header("Location: caripelanggan.php");
    exit;
}

$id = intval($_POST['id']);

$sql = "DELETE FROM kapster WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    echo "<script>
        alert('Data pelanggan berhasil dihapus');
        window.location.href='../owner/caripelanggan.php';
    </script>";
} else {
    echo "Gagal menghapus data.";
}
