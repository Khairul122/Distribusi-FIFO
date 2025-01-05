<?php
// Mengaktifkan session PHP
session_start();

// Menghapus semua session
session_destroy();

// Setel nilai $_SESSION['logged_in'] menjadi false
$_SESSION['logged_in'] = false;

// Menghapus cache header
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Mengalihkan halaman ke halaman login atau halaman lain yang sesuai
header("location:../index.php");
?>
