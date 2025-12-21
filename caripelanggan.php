<?php
require_once 'not-to-show/connect.php';

$search_result = null;
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $search_term = $conn->real_escape_string($_POST['search_term']);
    
    $query = "SELECT * FROM pelanggan WHERE nama LIKE '%$search_term%' OR hp_pelanggan LIKE '%$search_term%' LIMIT 1";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $search_result = $result->fetch_assoc();
    } else {
        $error_message = "Pelanggan tidak ditemukan.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/test.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h1>Cari Pelanggan</h1>
        <form method="POST" class="search-form">
            <input type="text" name="search_term" placeholder="Masukkan nama atau nomor HP" required>
            <button type="submit" name="search">Cari</button>
        </form>
        
        <?php if ($error_message): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if ($search_result): ?>
            <div class="customer-details">
                <h2>Detail Pelanggan</h2>
                <table>
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td><?php echo htmlspecialchars($search_result['nama']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nomor HP:</strong></td>
                        <td><?php echo htmlspecialchars($search_result['hp_pelanggan']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Bentuk Wajah:</strong></td>
                        <td><?php echo htmlspecialchars($search_result['bentuk_wajah']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Riwayat Potongan Rambut:</strong></td>
                        <td><?php echo htmlspecialchars($search_result['haircut_history']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Foto</strong></td>
                        <td><?php echo htmlspecialchars($search_result['foto']); ?></td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>