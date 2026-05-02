<?php
header('Content-Type: application/json');

// Use absolute paths to avoid any confusion
$baseDir = __DIR__ . DIRECTORY_SEPARATOR;
$storageDir = $baseDir . 'storage' . DIRECTORY_SEPARATOR;
$jsonFile = $storageDir . 'uploads.json';

// Create directory if it doesn't exist
if (!file_exists($storageDir)) {
    mkdir($storageDir, 0777, true);
}

$response = [
    'success' => false,
    'message' => 'Gagal mengunggah file.',
    'url' => '',
    'debug' => []
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $key = $_POST['key'] ?? ''; 
    $fileName = basename($file['name']);
    $fileSize = $file['size'];
    $fileTmp = $file['tmp_name'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $response['debug']['key'] = $key;

    // Allowed file types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($fileType, $allowedTypes)) {
        if ($fileSize <= 5000000) {
            $newFileName = uniqid('img_', true) . '.' . $fileType;
            $targetPath = $storageDir . $newFileName;
            // Public path for browser
            $publicPath = 'storage/' . $newFileName;

            if (move_uploaded_file($fileTmp, $targetPath)) {
                $response['success'] = true;
                $response['message'] = 'File berhasil diunggah!';
                $response['url'] = $publicPath;

                // Save to JSON for persistence
                if (!empty($key)) {
                    $data = [];
                    if (file_exists($jsonFile)) {
                        $jsonContent = file_get_contents($jsonFile);
                        $data = json_decode($jsonContent, true) ?: [];
                    }
                    $data[$key] = $publicPath;
                    
                    if (file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT))) {
                        $response['debug']['json_save'] = 'success';
                    } else {
                        $response['debug']['json_save'] = 'failed';
                        $response['message'] .= ' Namun gagal menyimpan data ke JSON.';
                    }
                } else {
                    $response['debug']['key_status'] = 'empty';
                }
            } else {
                $response['message'] = 'Gagal menyimpan file di server. Cek izin folder.';
            }
        } else {
            $response['message'] = 'Ukuran file terlalu besar (Maksimal 5MB).';
        }
    } else {
        $response['message'] = 'Tipe file tidak didukung. Gunakan JPG, PNG, atau WEBP.';
    }
} else {
    $response['message'] = 'Tidak ada file yang dikirim atau metode bukan POST.';
}

echo json_encode($response);
