<?php
require_once 'not-to-show/connect.php';
require_once 'not-to-show/auth.php';

$baseDir = 'assets/img/model_rambut/';
$allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

$folders = array_filter(glob($baseDir . '*'), 'is_dir');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Model Rambut</title>
    <link rel="stylesheet" href="assets/css/test.css">
    <link rel="stylesheet" href="assets/css/pelanggan.css">
    <style>
        .haircut-group {
            margin-bottom: 40px;
        }

        .haircut-group h3 {
            margin-bottom: 15px;
            text-transform: capitalize;
        }

        .haircut-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 16px;
        }

        .haircut-card {
            background: #fff;
            border-radius: 12px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }

        .haircut-card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 8px;
        }

        .haircut-name {
            margin-top: 8px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="content">
    <h2 class="page-title">Semua Model Rambut</h2>

    <?php foreach ($folders as $folder): ?>
        <?php
        $bentukWajah = basename($folder);
        $files = scandir($folder);
        ?>

        <div class="haircut-group">
            <h3><?= htmlspecialchars($bentukWajah) ?></h3>

            <div class="haircut-grid">
                <?php foreach ($files as $file): ?>
                    <?php
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    if (!in_array(strtolower($ext), $allowedExt)) continue;
                    ?>

                    <div class="haircut-card">
                        <img src="<?= $folder . '/' . $file ?>" alt="">
                        <div class="haircut-name">
                            <?= htmlspecialchars(pathinfo($file, PATHINFO_FILENAME)) ?>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>

    <?php endforeach; ?>
</div>

</body>
</html>