<?php

include '../config/koneksi.php';

$id = $_POST['id'];
$nama_barang = $_POST['nama_barang'];
$jumlah_stock = $_POST['jumlah_stock'];
$tanggal_masuk = $_POST['tanggal_masuk'];
$tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];

$query = "UPDATE obat SET 
            nama_barang = '$nama_barang',
            jumlah_stock = '$jumlah_stock',
            tanggal_masuk = '$tanggal_masuk',
            tanggal_kadaluarsa = '$tanggal_kadaluarsa'
            WHERE id = $id";

$result = mysqli_query($koneksi, $query);

if ($result) {
    header('location:../views/obat.php');
} else {
    echo "Data gagal diubah";
}
?>
