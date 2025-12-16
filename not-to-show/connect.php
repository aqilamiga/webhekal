<?php

$conn = mysqli_connect("localhost", "root", "", "haekal");

if (!$conn) {
    die("koneksi gagal" . mysqli_connect_error());
}

?>