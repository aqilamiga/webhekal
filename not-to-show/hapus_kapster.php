<?php
require_once 'connect.php';
require_once 'auth.php';

if (!isset($_POST['id'])) {
    header("Location: fullkapster.php");
    exit;
}

$id = intval($_POST['id']);

$sql = "DELETE FROM kapster WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    echo "<script>
        alert('Data kapster berhasil dihapus');
        window.location.href='../owner/fullkapster.php';
    </script>";
} else {
    echo "Gagal menghapus data.";
}
