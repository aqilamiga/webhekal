<?php

require_once './not-to-show/connect.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $nomor_hp = $_POST['nomor_hp'];
    $jabatan = $_POST['jabatan'];
    $password = $_POST['password'];
    $sql = "INSERT INTO kapster (username, nama, nomor_hp, jabatan, password) VALUES ('$username', '$nama', '$nomor_hp', '$jabatan', '$password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data kapster berhasil ditambahkan.'); window.location.href='tes.php';</script>";
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
      <section class="card header-card">
        <form id="kapsterForm" class="register" autocomplete="off" action="tes.php" method="POST">
          <label class="field-label">Nama Kapster</label>
          <input type="text" name="nama" id="nama" class="text-input" placeholder="Nama lengkap" />

          <label class="field-label">Nomor HP</label>
          <input type="text" name="nomor_hp" id="nomor_hp" class="text-input" placeholder="Isikan nomor HP 11-12 digit" />

          <label class="field-label">Jabatan</label>
          <div class="select-input-wrapper">
            <select name="jabatan" id="jabatan" class="select-input">
              <option value="" disabled selected>Pilih posisi</option>
              <option value="owner">Owner</option>
              <option value="kapster">Kapster</option>
            </select>
          </div>

          <label class="field-label">Password</label>
          <input type="password" name="password" id="password" class="text-input" placeholder="**********" />
          <p id="errorMessage" style="color:red; font-size:14px; display:none; margin-top:10px;"></p>

          <div class="actions">
            <button type="submit" name="submit" class="btn-primary">Daftar</button>
          </div>
        </form>
      </section>
    </main>
  </div>
<script src="script.js"></script>
</body>

</html>