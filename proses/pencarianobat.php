<?php
include '../config/koneksi.php';

if (isset($_POST['nama_barang'])) {
    $nama_barang = $_POST['nama_barang'];

    // Query untuk mencari obat berdasarkan nama obat
    $query = "SELECT * FROM obat WHERE nama_barang LIKE '%$nama_barang%'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        // Obat ditemukan, tampilkan hasil pencarian
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Nama Obat: " . $row['nama_barang'] . "<br>";
            // Tampilkan informasi lainnya sesuai kebutuhan
        }
    } else {
        // Tidak ada obat yang sesuai dengan pencarian
        echo "Tidak ada obat yang sesuai dengan pencarian.";
    }
}
?>
