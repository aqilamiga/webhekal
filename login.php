<?php
session_start();
require_once 'not-to-show/connect.php';

// Kalau sudah login, jangan balik ke login
if (isset($_SESSION['user_id'])) {
    header('Location: datapelanggan.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama     = trim($_POST['nama'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($nama === '' || $password === '') {
        $error = 'Nama dan password wajib diisi';
    } else {

        $stmt = $conn->prepare(
            "SELECT id, nama, jabatan, password FROM kapster WHERE nama = ? LIMIT 1"
        );

        if (!$stmt) {
            die("Query error: " . $conn->error);
        }
        $stmt->bind_param("s", $nama);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // ===============================
            // PASSWORD CHECK (PLAINTEXT)
            // ===============================
            if ($password === $user['password']) {

                // SESSION WAJIB LENGKAP
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nama']    = $user['nama'];
                $_SESSION['role']    = $user['jabatan'];

                // REGENERATE SESSION (GOOD PRACTICE)
                session_regenerate_id(true);

                header('Location: datapelanggan.php');
                exit;
            }
        }
        $error = 'Nama atau password salah';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>

    <div class="container">
        <div class="form-container sign-in">
            <form method="POST" autocomplete="off">
                <h1>Masuk</h1>
                <span>Gunakan akun yang telah disediakan staf</span>
                <?php if ($error): ?>
                    <p style="color:red; margin:10px 0;"> <?= htmlspecialchars($error) ?>
                    </p>
                <?php endif; ?>
                <input type="text" name="nama" placeholder="Nama" required>
                <input type="password" name="password" placeholder="Password"required>
                <a href="#">Jika lupa password, hubungi staf</a>
                <button type="submit">Masuk</button>
            </form>
        </div>
    </div>

</body>

</html>