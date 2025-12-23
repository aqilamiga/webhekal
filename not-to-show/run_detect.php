<?php
header('Content-Type: application/json');

$command = "python3 /home/pi/yolov4tinyrpi4/detect_once.py 2>&1";
$output = shell_exec($command);

$result = json_decode(trim($output), true);

if ($result && isset($result['success']) && $result['success']) {
    echo json_encode([
        "success" => true,
        "face_shape" => $result["face_shape"],
        "image" => "assets/img/captures/" . $result["image"]
    ]);
} else {
    echo json_encode([
        "success" => false,
        "raw" => $output
    ]);
}