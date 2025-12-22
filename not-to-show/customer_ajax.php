<?php
require_once 'connect.php';

if (!isset($_GET['keyword']) || $_GET['keyword'] == "") {
    echo "Masukkan nama customer untuk mencari.";
    exit;
}

$keyword = $_GET['keyword'];

$sql = "SELECT * FROM pelanggan WHERE nama LIKE '%$keyword%' ORDER BY nama ASC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "<p>Tidak ada data ditemukan.</p>";
    exit;
}

echo "<table class='kapster-table'>";
echo "<tr><th>Nama</th><th>Nomor HP</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr onclick='getDetail(".$row['id'].")'>";
    echo "<td>".$row['nama']."</td>";
    echo "<td>".$row['hp_pelanggan']."</td>";
    echo "</tr>";
}

echo "</table>";
?>