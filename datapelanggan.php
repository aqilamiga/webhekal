<?php
require_once 'not-to-show/connect.php';
require_once 'not-to-show/auth.php';

// Proses insert pelanggan (Tetap sama seperti logika Anda)
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $hp_pelanggan = $_POST['hp_pelanggan'];
    $bentuk_wajah = $_POST['bentuk_wajah'];
    $foto_path = $_POST['foto_path'];

    $sql = "INSERT INTO pelanggan (nama, hp_pelanggan, bentuk_wajah, foto) 
            VALUES ('$nama', '$hp_pelanggan', '$bentuk_wajah', '$foto_path')";

    if (mysqli_query($conn, $sql)) {
        $new_id = mysqli_insert_id($conn);
        echo "<script>alert('Data pelanggan berhasil ditambahkan.'); window.location.href='haircut.php?id_pelanggan=$new_id';</script>";
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
    <title>Manajemen Pelanggan</title>
    <link rel="stylesheet" href="./assets/css/test.css" />
    <link rel="stylesheet" href="./assets/css/datapelanggan.css" />
</head>

<body>
    <?php include 'sidebar.php'; ?>
    
    <main class="content">
        <div class="customer-wrapper">
            <div class="customer-left">
                <div class="glass-card">
                    <h2>Cari Pelanggan</h2>
                    <div class="search-box">
                        <input type="text" id="search" placeholder="Ketik nama pelanggan...">
                        <button id="btnSearch">🔍</button>
                    </div>
                    <div id="result">
                        <p style="color: var(--text-muted); font-size: 0.9rem; text-align: center;">Hasil pencarian akan muncul di sini.</p>
                    </div>
                    <div id="detail" style="margin-top: 20px;"></div>
                </div>
            </div>

            <div class="customer-right">
                <div class="glass-card">
                    <h2>Registrasi Baru</h2>
                    <form class="customer-form" autocomplete="off" method="POST">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" placeholder="Masukkan nama pelanggan" required>
                        </div>

                        <div class="form-group">
                            <label>Nomor HP</label>
                            <input type="text" name="hp_pelanggan" placeholder="Contoh: 08123456789" required>
                        </div>

                        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px dashed #cbd5e0;">
                            <label>AI Smart Detection</label>
                            <button type="button" class="btn-detect" onclick="mulaiDeteksi()">
                                📷 Mulai Deteksi Wajah
                            </button>
                            <p id="status">Sistem siap mendeteksi.</p>
                            
                            <img id="hasil-foto" src="" style="display:none; border-radius:10px;" />
                            
                            <label>Hasil Analisis Bentuk Wajah</label>
                            <input type="text" id="bentuk_wajah" name="bentuk_wajah" 
                                   style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ddd; background: #eee; font-weight: bold; color: var(--accent);" 
                                   placeholder="Otomatis dari sistem" readonly>
                            <input type="hidden" id="foto_path" name="foto_path">
                        </div>

                        <button type="submit" name="submit" class="btn-submit">
                            DAFTARKAN & PILIH HAIRCUT
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Logika JS Anda (Tetap Sama)
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.getElementById("search");
            const btn = document.getElementById("btnSearch");
            
            btn.addEventListener("click", () => doSearch());
            input.addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    doSearch();
                }
            });

            function doSearch() {
                const keyword = input.value;
                if(keyword === "") return;
                fetch("not-to-show/customer_ajax.php?keyword=" + keyword)
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById("result").innerHTML = data;
                        document.getElementById("detail").innerHTML = "";
                    });
            }
        });

        function getDetail(id) {
            fetch("detail_pelanggan.php?id=" + id)
                .then(res => res.text())
                .then(data => {
                    document.getElementById("detail").innerHTML = data;
                });
        }

        function mulaiDeteksi() {
            document.getElementById("status").innerText = "⏳ Sedang memproses wajah...";
            fetch("http://127.0.0.1:5000/detect", { method: "POST" })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("status").innerText = "✅ Deteksi Berhasil!";
                        const img = document.getElementById("hasil-foto");
                        img.src = "http://127.0.0.1:5000/images/" + data.image;
                        img.style.display = "block";
                        document.getElementById("bentuk_wajah").value = data.face_shape;
                        document.getElementById("foto_path").value = data.image;
                    } else {
                        document.getElementById("status").innerText = "❌ Gagal: " + (data.message ?? "Wajah tidak terbaca");
                    }
                })
                .catch(err => {
                    document.getElementById("status").innerText = "🔌 Error: Server Raspberry Offline";
                });
        }
    </script>
</body>
</html>