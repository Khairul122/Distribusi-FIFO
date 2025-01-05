<?php 

include '../config/koneksi.php';

$nama_obat = $_POST['nama_obat'];

// Hapus data dari tabel stock
$query_stock = "DELETE FROM stock WHERE nama_obat = '$nama_obat'";
$result_stock = mysqli_query($koneksi, $query_stock);

// Hapus data dari tabel obat
$query_obat = "DELETE FROM obat WHERE nama_obat = '$nama_obat'";
$result_obat = mysqli_query($koneksi, $query_obat);

if ($result_stock && $result_obat) {
    header('location: ../views/stock.php');
} else {
    echo "Data gagal dihapus";
}
?>
