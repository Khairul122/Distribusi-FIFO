<?php 
    include '../config/koneksi.php';

    $id = $_POST['id'];

    // Dapatkan nama obat dan jumlah_stock yang akan dihapus
    $query_obat = "SELECT nama_obat, jumlah_stock FROM obat WHERE id = '$id'";
    $result_obat = mysqli_query($koneksi, $query_obat);

    if ($row_obat = mysqli_fetch_assoc($result_obat)) {
        $nama_obat = $row_obat['nama_obat'];
        $jumlah_stock_hapus = $row_obat['jumlah_stock'];

        // Hapus data obat berdasarkan id
        $query_delete_obat = "DELETE FROM obat WHERE id = '$id'";
        $result_delete_obat = mysqli_query($koneksi, $query_delete_obat);

        if ($result_delete_obat) {
            // Kurangkan jumlah_stock pada tabel stock berdasarkan nama obat dan jumlah_stock yang dihapus
            $query_stock = "UPDATE stock SET jumlah_stock = jumlah_stock - $jumlah_stock_hapus WHERE nama_obat = '$nama_obat'";
            mysqli_query($koneksi, $query_stock);

            header('location: ../views/obat.php');
        } else {
            echo "Data obat gagal dihapus.";
        }
    } else {
        echo "Obat tidak ditemukan.";
    }
?>
