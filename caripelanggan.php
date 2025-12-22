<?php

require_once 'not-to-show/connect.php';
require_once 'not-to-show/auth.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Data Kapster</title>
    <link rel="stylesheet" href="./assets/css/kapster.css" />
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main class="content kapster-page">
        <div class="kapster-card-wrapper">
            <div class="kapster-card">
                <h2>Data Pelanggan</h2>
                <div class="kapster-search">
                    <input type="text" id="search" placeholder="Nama Pelanggan">
                    <button id="btnSearch">🔍</button>
                </div>
                <div id="pelanggan-result"></div>
                <div id="pelanggan-detail"></div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("btnSearch").addEventListener("click", function () {
                const keyword = document.getElementById("search").value;
                fetch("not-to-show/customer_ajax.php?keyword=" + keyword)
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById("pelanggan-result").innerHTML = data;
                        document.getElementById("pelanggan-detail").innerHTML = "";
                    });
            });
        });
        function getDetail(id) {
            fetch("detail_pelanggan.php?id=" + id)
                .then(res => res.text())
                .then(data => {
                    document.getElementById("pelanggan-detail").innerHTML = data;
                });
        }
    </script>
</body>
</html>
