<?php 

    include '../config/koneksi.php';

    $id = $_POST['id'];

    $query      = "DELETE FROM pengeluaran WHERE id = '$id'";
    $result     = mysqli_query($koneksi,$query);

    if ($result) {
        header('location: ../views/pengeluaran.php');
    }else{
        echo "Data gagal dihapus";
    }
?>