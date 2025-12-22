<?php
require_once 'not-to-show/connect.php';
require_once 'not-to-show/auth.php';

// proses simpan kapster
if (isset($_POST['submit'])) {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $hp       = $_POST['nomor_hp'];
    $jabatan  = $_POST['jabatan'];
    $password = $_POST['password'];

    $sql = "INSERT INTO kapster (nama, username, nomor_hp, jabatan, password)
            VALUES ('$nama', '$username', '$hp', '$jabatan', '$password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Kapster berhasil ditambahkan');location.href='fullkapster.php';</script>";
    } else {
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kapster</title>
    <link rel="stylesheet" href="./assets/css/pelanggan.css">

    <style>
        /* === LAYOUT LEBAR SEPERTI DATAPELANGGAN === */
        .wide-wrapper {
            display: flex;
            gap: 50px;
            align-items: flex-start;
            padding-right: 50px;
        }

        .wide-left {
            width: 420px;
        }

        .wide-right {
            flex: 1;
        }

        .register label {
            display: block;
            margin-top: 14px;
            margin-bottom: 6px;
            font-size: 14px;
            color: #555;
        }

        .register input,
        .register select {
            width: 100%;
            padding: 12px;
            border: none;
            background: #f1f1f1;
            border-radius: 20px;
            font-size: 14px;
        }

        .register button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background: #a7a7a7;
            border: none;
            border-radius: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .register button:hover {
            background: #8e8e8e;
        }
    </style>
</head>

<body>

<?php include 'sidebar.php'; ?>

<main class="content">
    <div class="wide-wrapper">
        <div class="wide-left">
            <div class="card">
                <h2>Tambah Kapster</h2>
                <form method="POST" class="register" autocomplete="off">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" required>
                    <label>Username</label>
                    <input type="text" name="username" required>
                    <label>Nomor HP</label>
                    <input type="text" name="nomor_hp" placeholder="11–12 digit" required>
                    <label>Jabatan</label>
                    <select name="jabatan" required>
                        <option value="">Pilih posisi</option>
                        <option value="owner">Owner</option>
                        <option value="kapster">Kapster</option>
                    </select>
                    <label>Password</label>
                    <input type="password" name="password" required>
                    <button type="submit" name="submit">Daftar</button>
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>
