<?php
require_once 'not-to-show/connect.php';
require_once 'not-to-show/auth.php';

$role = $_SESSION['role']; 
$message = "";

if (isset($_POST['btn_simpan']) && $role === 'owner') {
    // 1. Ambil data dari form (Pastikan key-nya sama dengan atribut 'name' di HTML)
    $nama_rambut = trim($_POST['nama_model']); 
    $deskripsi   = trim($_POST['deskripsi']);
    $wajah       = $_POST['bentuk_wajah'];
    
    // 2. Handler File Gambar
    if (isset($_FILES['foto_rambut']) && $_FILES['foto_rambut']['error'] === 0) {
        $targetDir = "assets/img/model_rambut/" . $wajah . "/";
        $ext = strtolower(pathinfo($_FILES["foto_rambut"]["name"], PATHINFO_EXTENSION));
        
        // Kita beri nama file gambar sesuai nama haircut
        $namaFileBaru = $nama_rambut . "." . $ext;
        $targetFile = $targetDir . $namaFileBaru;

        // Buat folder jika belum ada
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        if (move_uploaded_file($_FILES["foto_rambut"]["tmp_name"], $targetFile)) {
            
            // 3. Query INSERT (Hanya 4 field sesuai struktur Anda)
            // id biasanya AUTO_INCREMENT, jadi tidak perlu dimasukkan manual
            $stmt = $conn->prepare("INSERT INTO model_rambut (nama, deskripsi, bentuk_wajah) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nama_rambut, $deskripsi, $wajah);
            
            if ($stmt->execute()) {
                header("Location: list_haircut.php?success=1");
                exit();
            } else {
                $message = "Gagal simpan ke database: " . $conn->error;
            }
        } else {
            $message = "Gagal upload gambar ke folder.";
        }
    } else {
        $message = "Silakan pilih foto.";
    }
}

// =========================================================
// 2. AMBIL DATA UNTUK TAMPILAN
// =========================================================
$query = "SELECT * FROM model_rambut";
$result = $conn->query($query);
$dbData = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $key = strtolower(trim($row['nama'])); 
        $dbData[$key] = [
            'deskripsi' => $row['deskripsi'],
            'bentuk_wajah' => $row['bentuk_wajah']
        ];
    }
}

$baseDir = 'assets/img/model_rambut/';
$allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
// Ambil daftar folder untuk loop tampilan DAN untuk dropdown opsi tambah data
$folders = array_filter(glob($baseDir . '*'), 'is_dir');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Model Rambut</title>
    <link rel="stylesheet" href="assets/css/test.css">
    <style>
        /* --- Style Dasar --- */
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .haircut-group { margin-bottom: 40px; }
        .haircut-group h3 { margin-bottom: 15px; text-transform: capitalize; color: #333; }
        .haircut-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px; }
        
        /* --- Card Style --- */
        .haircut-card {
            background: #fff; border-radius: 12px; padding: 10px;
            text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,.08);
            cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;
        }
        .haircut-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,.15); }
        .haircut-card img { width: 100%; height: 140px; object-fit: cover; border-radius: 8px; }
        .haircut-name { margin-top: 8px; font-size: 14px; font-weight: 600; color: #555; }

        /* --- Button Tambah (Hanya Owner) --- */
        .btn-add {
            background-color: #28a745; color: white; padding: 10px 20px;
            text-decoration: none; border-radius: 5px; font-weight: bold; border: none; cursor: pointer;
        }
        .btn-add:hover { background-color: #218838; }

        /* --- Style MODAL (Popup Detail & Popup Tambah) --- */
        .modal {
            display: none; position: fixed; z-index: 1000; left: 0; top: 0;
            width: 100%; height: 100%; overflow: auto;
            background-color: rgba(0,0,0,0.8); backdrop-filter: blur(5px);
        }
        .modal-content {
            background-color: #fefefe; margin: 5% auto; padding: 0; border-radius: 15px;
            width: 90%; max-width: 600px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            overflow: hidden; position: relative; animation: slideIn 0.3s;
        }
        @keyframes slideIn { from {transform: translateY(-50px); opacity: 0;} to {transform: translateY(0); opacity: 1;} }
        
        .close {
            color: #fff; position: absolute; top: 10px; right: 20px; font-size: 28px; font-weight: bold;
            cursor: pointer; z-index: 1010; background: rgba(0,0,0,0.3); width: 40px; height: 40px;
            line-height: 40px; text-align: center; border-radius: 50%;
        }
        
        /* Layout Detail Modal */
        .modal-body { display: flex; flex-direction: column; }
        .modal-img-container { width: 100%; height: 300px; background: #eee; }
        .modal-img-container img { width: 100%; height: 100%; object-fit: cover; object-position: top; border-radius: 8px 8px 0 0;}
        .modal-info { padding: 25px; }
        .modal-category { background: #e0f7fa; color: #006064; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .modal-desc { color: #666; line-height: 1.6; white-space: pre-wrap; margin-top: 15px;}

        /* Style Form Tambah Data */
        .form-group { margin-bottom: 15px; text-align: left; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;
        }
        .form-header { background: #333; color: white; padding: 20px; text-align: center; }
        .form-container { padding: 20px; }
        .btn-submit { width: 100%; padding: 12px; background: #333; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="content">
    
    <div class="page-header">
        <h2 class="page-title">Semua Model Rambut</h2>
        
        <?php if ($role === 'owner'): ?>
            <button class="btn-add" onclick="openAddModal()">+ Tambah Model Baru</button>
        <?php endif; ?>
    </div>

    <?php if(!empty($message)) echo "<p style='color:red; text-align:center;'>$message</p>"; ?>
    <?php if(isset($_GET['success'])) echo "<p style='color:green; text-align:center;'>Data berhasil ditambahkan!</p>"; ?>

    <?php foreach ($folders as $folder): ?>
        <?php
        $bentukWajah = basename($folder);
        $files = scandir($folder);
        ?>

        <div class="haircut-group">
            <h3>Model Untuk Wajah: <?= htmlspecialchars($bentukWajah) ?></h3>
            <div class="haircut-grid">
                <?php foreach ($files as $file): ?>
                    <?php
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    if (!in_array(strtolower($ext), $allowedExt)) continue;
                    
                    $fullPath = $folder . '/' . $file;
                    $rawName = pathinfo($file, PATHINFO_FILENAME);
                    
                    // Cek Data DB
                    $searchKey = strtolower(trim($rawName));
                    $deskripsi = isset($dbData[$searchKey]) ? $dbData[$searchKey]['deskripsi'] : "Belum ada deskripsi detail untuk model ini.";
                    ?>

                    <div class="haircut-card" onclick="showDetail(
                        '<?= $fullPath ?>', 
                        '<?= htmlspecialchars($rawName, ENT_QUOTES) ?>', 
                        '<?= htmlspecialchars($bentukWajah, ENT_QUOTES) ?>',
                        `<?= str_replace('`', '\`', htmlspecialchars($deskripsi)) ?>` 
                    )">
                        <img src="<?= $fullPath ?>" alt="<?= htmlspecialchars($rawName) ?>" loading="lazy">
                        <div class="haircut-name"><?= htmlspecialchars($rawName) ?></div>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div id="detailModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('detailModal')">&times;</span>
        <div class="modal-body">
            <div class="modal-img-container"><img id="modalImg" src=""></div>
            <div class="modal-info">
                <span id="modalCategory" class="modal-category">Kategori</span>
                <h2 id="modalTitle">Nama Model</h2>
                <p id="modalDesc" class="modal-desc"></p>
            </div>
        </div>
    </div>
</div>

<?php if ($role === 'owner'): ?>
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addModal')">&times;</span>
        
        <div class="form-header"><h3>Tambah Model Rambut</h3></div>
        
        <form class="form-container" method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Model Rambut</label>
                <input type="text" name="nama_model" required placeholder="Contoh: Comma Hair">
            </div>

            <div class="form-group">
                <label>Cocok untuk Bentuk Wajah</label>
                <select name="bentuk_wajah" required>
                    <?php foreach ($folders as $folder): ?>
                        <?php $folderName = basename($folder); ?>
                        <option value="<?= htmlspecialchars($folderName) ?>"><?= ucfirst($folderName) ?></option>
                    <?php endforeach; ?>
                </select>
                <small style="color:#888;">*Otomatis masuk ke folder yang dipilih</small>
            </div>

            <div class="form-group">
                <label>Upload Foto</label>
                <input type="file" name="foto_rambut" accept="image/*" required>
            </div>

            <div class="form-group">
                <label>Deskripsi Lengkap</label>
                <textarea name="deskripsi" rows="4" placeholder="Jelaskan detail gaya rambut ini..."></textarea>
            </div>

            <button type="submit" name="btn_simpan" class="btn-submit">Simpan Data</button>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
    // --- Fungsi Modal Detail ---
    function showDetail(imageSrc, name, category, description) {
        var modal = document.getElementById("detailModal");
        document.getElementById("modalImg").src = imageSrc;
        document.getElementById("modalTitle").innerText = name;
        document.getElementById("modalCategory").innerText = "Wajah " + category;
        document.getElementById("modalDesc").innerText = description;
        
        modal.style.display = "block";
        document.body.style.overflow = "hidden";
    }

    // --- Fungsi Modal Tambah (Hanya jalan jika elemen ada) ---
    function openAddModal() {
        var modal = document.getElementById("addModal");
        if(modal) {
            modal.style.display = "block";
            document.body.style.overflow = "hidden";
        }
    }

    // --- Fungsi Tutup Modal (Generic) ---
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
        document.body.style.overflow = "auto";
    }

    // --- Klik Outside Close ---
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = "none";
            document.body.style.overflow = "auto";
        }
    }
</script>

</body>
</html>