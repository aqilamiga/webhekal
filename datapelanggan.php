<?php
require_once 'not-to-show/connect.php';
require_once 'not-to-show/auth.php';

// proses insert pelanggan
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $hp_pelanggan = $_POST['hp_pelanggan'];
    $bentuk_wajah = $_POST['bentuk_wajah'];

    $sql = "INSERT INTO pelanggan (nama, hp_pelanggan, bentuk_wajah)
            VALUES ('$nama', '$hp_pelanggan', '$bentuk_wajah')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data pelanggan berhasil ditambahkan.');
        window.location.href='pelanggan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Pelanggan</title>
    <link rel="stylesheet" href="./assets/css/test.css" />
    <link rel="stylesheet" href="./assets/css/pelanggan.css" />
    <style>
        :root {
            --bg: #f7f7f8;
        }

        .customer-wrapper {
            display: flex;
            gap: 50px;
            align-items: flex-start;
            padding-right: 50px;
        }

        /* Kolom kiri 40% */
        .customer-left {
            width: 40%;
            flex: 1;
        }

        /* Kolom kanan 60% */
        .customer-right {
            width: 60%;
            flex: 1;

            /* Hilangkan card putih */
            background: transparent;
            padding: 0;
            box-shadow: none;
            border-radius: 0;
        }

        .customer-right h2 {
            margin-bottom: 20px;
            font-size: 22px;
            color: #333;
        }

        /* Style input disamakan dengan kiri */
        .customer-form input,
        .customer-form button,
        .customer-search input {
            width: 100%;
            padding: 12px;
            border: none;
            background: #f5f5f5;
            border-radius: 6px;
            font-size: 14px;
        }

        /* Tombol submit */
        .btn-primary {
            background: #525252;
            color: #00B4D8;
            cursor: pointer;
            transition: 0.2s;
            border: none;
            border-radius: 20px;
        }

        .btn-primary:hover {
            background: #3E3532;
        }

        /* Tombol Deteksi */
        .btn-secondary {
            background: #dcdcdc;
            padding: 10px 12px;
            border-radius: 6px;
            cursor: pointer;
            border: none;
            transition: 0.2s;
            margin-bottom: 10px;
        }

        .btn-secondary:hover {
            background: #c5c5c5;
        }

        /* Style hasil deteksi */
        #hasil-foto {
            display: none;
            width: 180px;
            border-radius: 10px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main class="content">
        <div class="customer-wrapper">
            <!-- BAGIAN KIRI — DATA CUSTOMER -->
            <div class="customer-left">
                <h2>Data Customer</h2>

                <div class="customer-search">
                    <input type="text" id="search" placeholder="Pilih Nama Customer">
                    <button id="btnSearch">🔍</button>
                </div>

                <div id="result"></div>
                <div id="detail"></div>
            </div>
            <!-- BAGIAN KANAN — INPUT CUSTOMER -->
            <div class="customer-right">
                <h2>Input Customer Baru</h2>
                <form class="customer-form" autocomplete="off" method="POST">
                    <label>Nama Customer</label>
                    <input type="text" name="nama" placeholder="Nama lengkap" required>
                    <label>Nomor HP</label>
                    <input type="text" name="hp_pelanggan" placeholder="11-12 digit" required>
                    <label>Deteksi Bentuk Wajah</label>
                    <button type="button" onclick="mulaiDeteksi()">Mulai Deteksi Wajah</button>
                    <p id="status" style="margin-top: 10px; color: gray;">Belum ada deteksi.</p>
                    <img id="hasil-foto" src=""
                        style="display:none; width:180px; margin-top:10px; border-radius:10px;" />
                    <label>Hasil Deteksi</label>
                    <input type="text" id="bentuk_wajah" name="bentuk_wajah" placeholder="Hasil otomatis" readonly>
                    <button type="submit" name="submit" class="btn-primary">
                        Daftar dan Rekomendasi Haircut
                    </button>
                </form>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const input = document.getElementById("search");
            const btn = document.getElementById("btnSearch");
            // tombol search
            btn.addEventListener("click", () => doSearch());
            // tekan ENTER untuk search
            input.addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    doSearch();
                }
            });

            function doSearch() {
                const keyword = input.value;

                fetch("not-to-show/customer_ajax.php?keyword=" + keyword)
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById("result").innerHTML = data;
                        document.getElementById("detail").innerHTML = "";
                    });
            }
        });
        // klik row → detail
        function getDetail(id) {
            fetch("detail_pelanggan.php?id=" + id)
                .then(res => res.text())
                .then(data => {
                    document.getElementById("detail").innerHTML = data;
                });
        }
        // fungsi mulai deteksi wajah via Raspberry Pi
        function mulaiDeteksi() {
            document.getElementById("status").innerText = "Mendeteksi wajah...";

            fetch("http://127.0.0.1:5000/detect", {
                    method: "POST"
                })
                .then(res => {
                    if (!res.ok) throw new Error("Server error");
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        document.getElementById("status").innerText = "Deteksi berhasil";
                        document.getElementById("hasil-foto").src = data.image;
                        document.getElementById("bentuk_wajah").value = data.face_shape;
                    } else {
                        document.getElementById("status").innerText = data.message ?? "Gagal mendeteksi wajah";
                    }
                })
                .catch(err => {
                    document.getElementById("status").innerText = "Server Raspberry tidak bisa diakses";
                    console.error(err);
                });
        }
    </script>
</body>

</html>