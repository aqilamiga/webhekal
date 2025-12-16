<?php
header('Content-Type: application/json');

// Jalankan Python
$command = "python3 /home/pi/deteksi_wajah.py 2>&1";
$output = shell_exec($command);

// Python akan return JSON string
$result = json_decode($output, true);

if ($result) {
    echo json_encode([
        "success" => true,
        "face_shape" => $result["face_shape"],
        "image" => "captures/" . $result["image"]   // lokasi foto
    ]);
} else {
    echo json_encode(["success" => false]);
}
?>
