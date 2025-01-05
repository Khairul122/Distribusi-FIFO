<?php
// Ambil nama file dokumen yang akan didownload dari parameter URL
if (isset($_GET['filename'])) {
    $filename = $_GET['filename'];

    // Lokasi penyimpanan file dokumen
    $filepath = '../upload/' . $filename;

    // Periksa apakah file dokumen ada
    if (file_exists($filepath)) {
        // Atur header untuk memicu unduhan
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Content-Length: ' . filesize($filepath));

        // Baca file dan kirimkan ke output
        readfile($filepath);
        exit;
    } else {
        echo 'File tidak ditemukan.';
    }
} else {
    echo 'Parameter filename tidak valid.';
}
?>
