<?php
// upload_handler.php
$target_dir = "assets/img/pelanggan/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if (isset($_FILES['foto'])) {
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    echo "Berhasil upload";
}
?>