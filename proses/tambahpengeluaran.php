<?php
include '../config/koneksi.php';

$nama_barang = $_POST['nama_barang']; // Mendapatkan nama obat yang dipilih oleh pengguna

// Query untuk mengambil semua obat dengan nama obat tertentu, diurutkan berdasarkan tanggal masuk ASC (metode FIFO)
$query_obat = "SELECT id_barang, nama_barang FROM obat WHERE nama_barang = '$nama_barang' ORDER BY tanggal_masuk ASC";
$result_obat = mysqli_query($koneksi, $query_obat);

$id_barang_keluar = ""; // Inisialisasi id_barang
$nama_barang_keluar = $nama_barang; // Set nama obat

// Mendapatkan data lain yang diinputkan oleh pengguna
$tujuan = $_POST['tujuan'];
$harga = $_POST['harga'];
$tanggal_keluar = $_POST['tanggal_keluar'];
$dokumen = $_FILES['dokumen']['name'];

// Pemrosesan upload file dokumen
$tmp_file = $_FILES['dokumen']['tmp_name'];
$direktori = "C:/xampp/htdocs/fifo-sim/upload/"; // Sesuaikan dengan direktori penyimpanan Anda
move_uploaded_file($tmp_file, $direktori . $dokumen);

$total_pengeluaran = $_POST['jumlah_keluar']; // Jumlah pengeluaran yang diminta
$stok_sisa = $total_pengeluaran; // Stok yang masih perlu dipenuhi
$satuan_obat = ""; // Inisialisasi satuan obat di luar perulangan

while ($row_obat = mysqli_fetch_assoc($result_obat)) {
    $id_barang = $row_obat['id_barang'];

    // Mendapatkan informasi stok obat yang dipilih
    $query_stok_obat = "SELECT jumlah_stock, satuan FROM obat WHERE id_barang = '$id_barang'";
    $result_stok_obat = mysqli_query($koneksi, $query_stok_obat);
    $row_stok_obat = mysqli_fetch_assoc($result_stok_obat);

    $stok_obat_keluar = $row_stok_obat['jumlah_stock'];
    $satuan_obat = $row_stok_obat['satuan']; // Mendapatkan nilai satuan

    // Mendapatkan informasi stok obat di tabel "stock" berdasarkan "nama_barang"
    $query_stok_stock = "SELECT jumlah_stock FROM stock WHERE nama_barang = '$nama_barang_keluar'";
    $result_stok_stock = mysqli_query($koneksi, $query_stok_stock);
    $stok_stock_keluar = mysqli_fetch_assoc($result_stok_stock)['jumlah_stock'];

    if ($stok_sisa <= 0) {
        // Jika stok yang masih perlu dipenuhi sudah habis, keluar dari loop
        break;
    } else if ($stok_obat_keluar > 0) {
        // Jika stok obat tanggal masuk ini tersedia
        $jumlah_yang_diambil = min($stok_obat_keluar, $stok_sisa);

        // Perbarui stok obat di tabel obat
        $query_update_stok_obat = "UPDATE obat SET jumlah_stock = jumlah_stock - $jumlah_yang_diambil WHERE id_barang = '$id_barang'";
        mysqli_query($koneksi, $query_update_stok_obat);

        // Perbarui stok obat di tabel stock
        $query_update_stok_stock = "UPDATE stock SET jumlah_stock = jumlah_stock - $jumlah_yang_diambil WHERE nama_barang = '$nama_barang_keluar'";
        mysqli_query($koneksi, $query_update_stok_stock);

        // Kurangi stok yang masih perlu dipenuhi
        $stok_sisa -= $jumlah_yang_diambil;

        // Gabungkan id_barang dengan tanda "&" jika ada lebih dari satu
        if (!empty($id_barang_keluar)) {
            $id_barang_keluar .= " & ";
        }
        $id_barang_keluar .= $id_barang;
    }
}

if ($stok_sisa <= 0) {
    // Hitung total harga
    $hargatot = $harga * $total_pengeluaran;

    // Semua pengeluaran berhasil dipenuhi, simpan sebagai satu entri di tabel pengeluaran
    $query_insert_pengeluaran = "INSERT INTO pengeluaran (id_barang, nama_barang, satuan, tujuan, harga, tanggal_keluar, jumlah_keluar, dokumen, hargatot) VALUES ('$id_barang_keluar', '$nama_barang', '$satuan_obat', '$tujuan', '$harga', '$tanggal_keluar', $total_pengeluaran, '$dokumen', '$hargatot')";
    $result_insert_pengeluaran = mysqli_query($koneksi, $query_insert_pengeluaran);

    if ($result_insert_pengeluaran) {
        // Hapus baris obat yang memiliki jumlah_stock 0
        $query_hapus_obat = "DELETE FROM obat WHERE jumlah_stock = 0";
        mysqli_query($koneksi, $query_hapus_obat);

        header('location:../views/pengeluaran.php');
    } else {
        echo '<script type="text/JavaScript">';
        echo 'alert("Tambah Data Gagal")';
        echo '</script>';
    }
} else {
    // Jika stok obat tidak mencukupi untuk semua pengeluaran
    echo '<script type="text/JavaScript">';
    echo 'alert("Stok obat tidak mencukupi untuk semua pengeluaran.")';
    echo '</script>';
}
?>
