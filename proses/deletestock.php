<?php 

include '../config/koneksi.php';

$nama_barang = $_POST['nama_barang'];

// Hapus data dari tabel stock
$query_stock = "DELETE FROM stock WHERE nama_barang = '$nama_barang'";
$result_stock = mysqli_query($koneksi, $query_stock);

// Hapus data dari tabel obat
$query_obat = "DELETE FROM obat WHERE nama_barang = '$nama_barang'";
$result_obat = mysqli_query($koneksi, $query_obat);

if ($result_stock && $result_obat) {
    header('location: ../views/stock.php');
} else {
    echo "Data gagal dihapus";
}
?>
