<?php
$filename = $_GET['file'] ?? '';
$path = '../uploads/' . basename($filename);

// Cek apakah file ada
if (!file_exists($path)) {
    echo "❌ File tidak ditemukan.";
    exit;
}

$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

if ($ext === 'pdf') {
    // Tampilkan PDF langsung di browser
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $filename . '"');
    readfile($path);
    exit;
} elseif ($ext === 'txt') {
    // Tampilkan isi TXT di halaman HTML
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Preview TXT</title>
    <style>
      body {
        background-color: #1e1e2f;
        color: #eee;
        font-family: monospace;
        padding: 20px;
      }
      pre {
        white-space: pre-wrap;
        word-wrap: break-word;
        background-color: #2a2b3d;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #444;
      }
      h3 {
        color: #4e9af1;
      }
    </style>
    </head><body>
    <h3>📄 Isi File TXT: $filename</h3><hr><pre>";
    echo htmlspecialchars(file_get_contents($path));
    echo "</pre></body></html>";
    exit;
} else {
    echo "⚠️ Tipe file tidak didukung untuk ditampilkan.";
    exit;
}
?>
