<?php

include '../config/koneksi.php';

$id = $_POST['id'];
$nama_barang = $_POST['nama_barang'];
$jumlah_stock = $_POST['jumlah_stock'];

$query = "UPDATE stock SET 
            nama_barang = '$nama_barang',
            jumlah_stock = '$jumlah_stock'           
            WHERE id = $id";

$result = mysqli_query($koneksi, $query);

if ($result) {
    header('location:../views/stock.php');
} else {
    echo "Data gagal diubah";
}
?>
