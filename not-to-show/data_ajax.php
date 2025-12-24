<?php
require_once 'connect.php';
$keyword = $_GET['keyword'];

$sql = "SELECT * FROM pelanggan WHERE nama LIKE '%$keyword%' OR hp_pelanggan LIKE '%$keyword%' LIMIT 5";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table style='width:100%; border-collapse: collapse;'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr onclick='getDetail(" . $row['id'] . ")' style='cursor:pointer; border-bottom:1px solid #ddd;'>
                <td style='padding:10px;'>" . $row['nama'] . " (" . $row['bentuk_wajah'] . ")</td>
                <td style='text-align:right;'>➡️</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Customer tidak ditemukan.";
}
?>