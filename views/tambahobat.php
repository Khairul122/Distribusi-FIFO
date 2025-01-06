<?php
include '../config/koneksi.php';
// Mulai sesi
session_start();

// Periksa status login pengguna
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika pengguna belum login, alihkan ke halaman login
    header("Location: ../index.php");
    exit();
}

// Set header-cache untuk mencegah caching halaman
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Konten halaman yang memerlukan autentikasi
// ...

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        html,
        body {
            height: 100%;
        }

        #layoutSidenav {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #layoutSidenav_content {
            flex: 1 0 auto;
        }

        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
        }

        .card-text {
            font-size: 18px;
            color: #333;
        }

        .card-primary .card-body {
            background-color: #007bff;
        }

        .card-success .card-body {
            background-color: #28a745;
        }

        .card-warning .card-body {
            background-color: #ffc107;
        }

        .card-danger .card-body {
            background-color: #dc3545;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php

    ?>
<?php include '../template/navbar.php'; ?>
    <div id="layoutSidenav">
        <?php include '../template/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="my-4 text-center">Tambah Barang</h1>
                    <div class="col-md-8 m-auto card p-5 shadow -3 mb-5 bg-body rounded">
                        <form enctype="multipart/form-data" action="../proses/tambahobat.php" method="post">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Nama Barang</label>
                                <input name="nama_barang" type="text" class="form-control id=exampleFormControlInput1">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Satuan</label>
                                <input name="satuan" type="text" class="form-control id=exampleFormControlInput1">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Jumlah Stock</label>
                                <input name="jumlah_stock" type="text" class="form-control id=exampleFormControlInput1">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Harga</label>
                                <input name="harga" type="text" class="form-control id=exampleFormControlInput1">
                            </div>
                            <div class="mb-3">
                                <label for="birthday">Tanggal Masuk</label>
                                <br>
                                <input type="date" id="tanggal_masuk" name="tanggal_masuk">
                            </div>
                            <div class="mb-3">
                                <label for="birthday">Tanggal Kadaluarsa</label>
                                <br>
                                <input type="date" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa">
                            </div>
                            <div class="d-flex justify-content-around">
                                <button name="submit" class="btn btn-md btn-primary px-5 mt-2">Tambah</button>
                                <a href="./obat.php" class="btn btn-md btn-danger px-5 mt-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
           
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>