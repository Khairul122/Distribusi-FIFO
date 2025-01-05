<?php
include '../config/koneksi.php';

$id = $_POST['id'];
$tujuan = $_POST['tujuan'];
$harga = $_POST['harga'];
$tanggal_keluar = $_POST['tanggal_keluar'];

    // Perintah UPDATE dengan menggabungkan nama_obat yang diambil dari tabel obat
    $query = "UPDATE pengeluaran SET              
                tujuan = '$tujuan',
                harga = '$harga',
                tanggal_keluar = '$tanggal_keluar'
                WHERE id = $id";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header('location:../views/pengeluaran.php');
    } else {
        echo "Data gagal diubah";
    }
?>
