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
            html, body {
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
                        <h1 class="my-4 text-center">Barang Masuk</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Tabel Barang Masuk
                            </div>
                            <div class="card-body">
                                <form method="get" action="obat.php">
                                    <div class="mb-3">
                                        <label for="tanggal_filter">Filter Tanggal:</label>
                                        <input type="date" name="tanggal_filter" id="tanggal_filter">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="obat.php" class="btn btn-danger">Hapus Filter</a>
                                    </div>
                                </form>
                                <div id="pagination-container" class="d-flex mb-3">
                                    <a href="tambahobat.php" class="btn btn-primary ms-2">Tambah Data</a>
                                </div>
                                <table id="datatablesSimple" class="table">
                                    <thead>
                                        <tr>
                                            <th>ID Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Satuan</th>
                                            <th>Jumlah Stock</th>
                                            <th>Harga</th>
                                            <th>Harga Total</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Kadaluarsa</th>
                                            <th>Action</th>                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Cek apakah parameter tanggal_filter ada dalam URL
                                            if (isset($_GET['tanggal_filter'])) {
                                                $tanggal_filter = $_GET['tanggal_filter'];
                                                // Konversi format tanggal ke format yang sesuai dalam database (Y-m-d)
                                                $tanggal_filter = date('Y-m-d', strtotime($tanggal_filter));
                                                // Modifikasi query untuk mengambil data berdasarkan tanggal
                                                $query = "SELECT * FROM obat WHERE DATE(tanggal_masuk) = '$tanggal_filter'";
                                            } else {
                                                // Jika tidak ada parameter tanggal_filter, tampilkan semua data
                                                $query = "SELECT * FROM obat";
                                            }

                                            $result = mysqli_query($koneksi, $query);

                                            while ($data = mysqli_fetch_assoc($result)) {
                                                // Tampilkan data sesuai kebutuhan
                                        ?>
                                        <tr>
                                            <td><?= $data['id_obat'] ?></td>
                                            <td><?= $data['nama_obat'] ?></td>
                                            <td><?= $data['satuan'] ?></td>
                                            <td><?= $data['jumlah_stock'] ?></td>
                                            <td><?= $data['harga'] ?></td>
                                            <td><?= $data['hargatot'] ?></td>
                                            <td><?= $data['tanggal_masuk'] ?></td>
                                            <td><?= $data['tanggal_kadaluarsa'] ?></td>                                          
                                            <td>
                                                <ul class="list-inline d-flex justify-content-evenly">
                                                    <li><a href="./editobat.php?id=<?= $data['id'] ?>" class="btn btn-success">Edit</a></li>
                                                    <li>
                                                        <form action="../proses/deleteobat.php" method="post">
                                                            <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                                            <button class="btn btn-danger text-light">Delete</button>
                                                        </form>
                                                    </li>                                       
                                                </ul>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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
