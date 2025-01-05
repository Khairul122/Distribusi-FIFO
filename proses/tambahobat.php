<?php 
include '../config/koneksi.php';

$nama_obat = $_POST['nama_obat'];
$satuan = $_POST['satuan'];
$jumlah_stock = $_POST['jumlah_stock'];
$harga = $_POST['harga'];
$tanggal_masuk = $_POST['tanggal_masuk'];
$tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];

if ($nama_obat == '') {
    echo '<script type="text/JavaScript">';
    echo 'alert("Nama Obat Tidak Boleh Kosong")';
    echo '</script>';
} else { 
    // Menghasilkan nilai id_obat secara manual
    $id_obat = uniqid(); // Anda perlu membuat fungsi uniqid() sesuai dengan kebutuhan Anda

    // Hitung total harga
    $hargatot = $harga * $jumlah_stock;

    // Periksa apakah nama_obat sudah ada dalam tabel stock
    $query_check_stock = "SELECT nama_obat FROM stock WHERE nama_obat = '$nama_obat'";
    $result_check_stock = mysqli_query($koneksi, $query_check_stock);

    if (mysqli_num_rows($result_check_stock) > 0) {
        // Jika nama_obat sudah ada, lakukan UPDATE pada tabel stock
        $query_stock = "UPDATE stock SET jumlah_stock = jumlah_stock + '$jumlah_stock' WHERE nama_obat = '$nama_obat'";
        $result_stock = mysqli_query($koneksi, $query_stock);
    } else {
        // Jika nama_obat belum ada, lakukan INSERT ke tabel stock
        $query_stock = "INSERT INTO stock (nama_obat, satuan, jumlah_stock) VALUES ('$nama_obat', '$satuan', '$jumlah_stock')";
        $result_stock = mysqli_query($koneksi, $query_stock);
    }

    // Setelah berhasil menambahkan data obat, tambahkan data ke tabel obat
    $query_obat = "INSERT INTO obat (id_obat, nama_obat, satuan, jumlah_stock, harga, tanggal_masuk, tanggal_kadaluarsa, hargatot) 
                  VALUES ('$id_obat', '$nama_obat', '$satuan', '$jumlah_stock', '$harga', '$tanggal_masuk', '$tanggal_kadaluarsa', '$hargatot')";

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
