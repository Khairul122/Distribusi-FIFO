<?php 
include '../config/koneksi.php';

$nama_barang = $_POST['nama_barang'];
$satuan = $_POST['satuan'];
$jumlah_stock = $_POST['jumlah_stock'];
$harga = $_POST['harga'];
$tanggal_masuk = $_POST['tanggal_masuk'];
$tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];

if ($nama_barang == '') {
    echo '<script type="text/JavaScript">';
    echo 'alert("Nama Obat Tidak Boleh Kosong")';
    echo '</script>';
} else { 
    // Menghasilkan nilai id_barang secara manual
    $id_barang = uniqid(); // Anda perlu membuat fungsi uniqid() sesuai dengan kebutuhan Anda

    // Hitung total harga
    $hargatot = $harga * $jumlah_stock;

    // Periksa apakah nama_barang sudah ada dalam tabel stock
    $query_check_stock = "SELECT nama_barang FROM stock WHERE nama_barang = '$nama_barang'";
    $result_check_stock = mysqli_query($koneksi, $query_check_stock);

    if (mysqli_num_rows($result_check_stock) > 0) {
        // Jika nama_barang sudah ada, lakukan UPDATE pada tabel stock
        $query_stock = "UPDATE stock SET jumlah_stock = jumlah_stock + '$jumlah_stock' WHERE nama_barang = '$nama_barang'";
        $result_stock = mysqli_query($koneksi, $query_stock);
    } else {
        // Jika nama_barang belum ada, lakukan INSERT ke tabel stock
        $query_stock = "INSERT INTO stock (nama_barang, satuan, jumlah_stock) VALUES ('$nama_barang', '$satuan', '$jumlah_stock')";
        $result_stock = mysqli_query($koneksi, $query_stock);
    }

    // Setelah berhasil menambahkan data obat, tambahkan data ke tabel obat
    $query_obat = "INSERT INTO obat (id_barang, nama_barang, satuan, jumlah_stock, harga, tanggal_masuk, tanggal_kadaluarsa, hargatot) 
                  VALUES ('$id_barang', '$nama_barang', '$satuan', '$jumlah_stock', '$harga', '$tanggal_masuk', '$tanggal_kadaluarsa', '$hargatot')";

    $result_obat = mysqli_query($koneksi, $query_obat);

    if ($result_obat && $result_stock) {
        header('location: ../views/obat.php');
    } else {
        echo '<script type="text/JavaScript">';
        echo 'alert("Tambah Data Gagal")';
        echo '</script>';
    }
}
?>
