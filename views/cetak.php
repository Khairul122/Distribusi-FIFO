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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cetak Data</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.5/b-2.4.0/b-html5-2.4.0/b-print-2.4.0/datatables.min.css" rel="stylesheet">

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

        /* Tambahkan border antara thead dan tbody */
        table.dataTable thead th {
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php include '../template/navbar.php'; ?>
    <div id="layoutSidenav">
        <?php include '../template/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="my-4 text-center">Cetak Data</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Tabel Barang Masuk
                        </div>
                        <div class="card-body">
                            <form method="get" action="cetak.php">
                                <div class="mb-3">
                                    <label for="tanggal_filter">Filter Tanggal:</label>
                                    <input type="date" name="tanggal_filter" id="tanggal_filter">
                                    <select name="filter_type" id="filter_type">
                                        <option value="day">Hari</option>
                                        <option value="month">Bulan</option>
                                        <option value="year">Tahun</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="cetak.php" class="btn btn-danger">Hapus Filter</a>
                                </div>
                            </form>
                            <table id="datatablesSimple" class="table table-bordered pt-2">
                                <thead>
                                    <tr>
                                        <th>ID Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Stock</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal Kadaluarsa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Cek apakah parameter tanggal_filter dan filter_type ada dalam URL
                                    if (isset($_GET['tanggal_filter']) && isset($_GET['filter_type'])) {
                                        $tanggal_filter = $_GET['tanggal_filter'];
                                        $filter_type = $_GET['filter_type'];

                                        // Konversi format tanggal ke format yang sesuai dalam database (Y-m-d)
                                        $tanggal_filter = date('Y-m-d', strtotime($tanggal_filter));

                                        // Modifikasi query berdasarkan filter_type yang dipilih
                                        if ($filter_type === 'day') {
                                            $query = "SELECT * FROM obat WHERE DATE(tanggal_masuk) = '$tanggal_filter'";
                                        } elseif ($filter_type === 'month') {
                                            // Dapatkan tahun dan bulan dari tanggal_filter
                                            $tahun_filter = date('Y', strtotime($tanggal_filter));
                                            $bulan_filter = date('m', strtotime($tanggal_filter));
                                            $query = "SELECT * FROM obat WHERE YEAR(tanggal_masuk) = '$tahun_filter' AND MONTH(tanggal_masuk) = '$bulan_filter'";
                                        } elseif ($filter_type === 'year') {
                                            // Dapatkan tahun dari tanggal_filter
                                            $tahun_filter = date('Y', strtotime($tanggal_filter));
                                            $query = "SELECT * FROM obat WHERE YEAR(tanggal_masuk) = '$tahun_filter'";
                                        }
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
                                            <td><?= $data['jumlah_stock'] ?></td>
                                            <td><?= $data['tanggal_masuk'] ?></td>
                                            <td><?= $data['tanggal_kadaluarsa'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <a id="top-of-table2"></a>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Tabel Pengeluaran Barang
                        </div>
                        <div class="card-body">
                            <form method="get" action="cetak.php#top-of-table2">
                                <div class="mb-3">
                                    <label for="tanggal_filter">Filter Tanggal:</label>
                                    <input type="date" name="tanggal_filter" id="tanggal_filter">
                                    <select name="filter_type" id="filter_type">
                                        <option value="day">Hari</option>
                                        <option value="month">Bulan</option>
                                        <option value="year">Tahun</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="cetak.php#top-of-table2" class="btn btn-danger">Hapus Filter</a>
                                </div>
                            </form>
                            <table id="datatablesSimple2" class="table table-bordered pt-2">
                                <thead>
                                    <tr>
                                        <th>ID Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Tujuan</th>
                                        <th>Harga</th>
                                        <th>Tanggal Keluar</th>
                                        <th>Jumlah Keluar</th>
                                        <th>Dokumen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Cek apakah parameter tanggal_filter dan filter_type ada dalam URL
                                    if (isset($_GET['tanggal_filter']) && isset($_GET['filter_type'])) {
                                        $tanggal_filter = $_GET['tanggal_filter'];
                                        $filter_type = $_GET['filter_type'];

                                        // Konversi format tanggal ke format yang sesuai dalam database (Y-m-d)
                                        $tanggal_filter = date('Y-m-d', strtotime($tanggal_filter));

                                        // Modifikasi query berdasarkan filter_type yang dipilih
                                        if ($filter_type === 'day') {
                                            $query = "SELECT * FROM pengeluaran WHERE DATE(tanggal_keluar) = '$tanggal_filter'";
                                        } elseif ($filter_type === 'month') {
                                            // Dapatkan tahun dan bulan dari tanggal_filter
                                            $tahun_filter = date('Y', strtotime($tanggal_filter));
                                            $bulan_filter = date('m', strtotime($tanggal_filter));
                                            $query = "SELECT * FROM pengeluaran WHERE YEAR(tanggal_keluar) = '$tahun_filter' AND MONTH(tanggal_keluar) = '$bulan_filter'";
                                        } elseif ($filter_type === 'year') {
                                            // Dapatkan tahun dari tanggal_filter
                                            $tahun_filter = date('Y', strtotime($tanggal_filter));
                                            $query = "SELECT * FROM pengeluaran WHERE YEAR(tanggal_keluar) = '$tahun_filter'";
                                        }
                                    } else {
                                        // Jika tidak ada parameter tanggal_filter, tampilkan semua data
                                        $query = "SELECT * FROM pengeluaran";
                                    }

                                    $result = mysqli_query($koneksi, $query);

                                    while ($data = mysqli_fetch_assoc($result)) {
                                        // Tampilkan data sesuai kebutuhan
                                    ?>
                                        <tr>
                                            <td><?= $data['id_obat'] ?></td>
                                            <td><?= $data['nama_obat'] ?></td>
                                            <td><?= $data['tujuan'] ?></td>
                                            <td><?= $data['harga'] ?></td>
                                            <td><?= $data['tanggal_keluar'] ?></td>
                                            <td><?= $data['jumlah_keluar'] ?></td>
                                            <td><?= $data['dokumen'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Tabel Stock Barang
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple3" class="table table-bordered pt-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM stock";
                                    $result = mysqli_query($koneksi, $query);

                                    $no = 1;
                                    while ($data = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['nama_obat'] ?></td>
                                            <td><?= $data['jumlah_stock'] ?></td>
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
    <script src="../js/datatables-simple-demo.js"></script>
    <script src="../js/datatables-simple-demo2.js"></script>
    <script src="../js/datatables-simple-demo3.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.5/b-2.4.0/b-html5-2.4.0/b-print-2.4.0/datatables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            // ==========================================
            // Utilitas Format Tanggal dan Periode
            // ==========================================
            const utilityFormatter = {
                tanggal: {
                    keIndonesia: (tanggal) => {
                        return tanggal.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                    },

                    untukNamaFile: (tanggal) => {
                        return tanggal.toISOString().slice(0, 10).replace(/-/g, '');
                    }
                },

                periode: {
                    bulanTahun: () => {
                        const tanggal = new Date();
                        return `${tanggal.toLocaleDateString('id-ID', { month: 'long' })} ${tanggal.getFullYear()}`;
                    }
                },

                nomorSurat: {
                    generate: () => {
                        const tanggal = new Date();
                        const tahun = tanggal.getFullYear();
                        const bulan = String(tanggal.getMonth() + 1).padStart(2, '0');
                        const hari = String(tanggal.getDate()).padStart(2, '0');
                        const nomorUrut = String(Math.floor(Math.random() * 999) + 1).padStart(3, '0');

                        return `${tahun}${bulan}${hari}${nomorUrut}`;
                    }
                }
            };

            // ==========================================
            // Kustomisasi Dokumen untuk Cetak
            // ==========================================
            const dokumenKustomisasi = {
                aturGayaDasar: (dokumen) => {
                    $(dokumen).css({
                        'font-size': '14px',
                        'font-family': 'Arial, sans-serif',
                        'padding': '20px'
                    });
                },

                buatKopSurat: () => {
                    return `
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="../assets/img/logo.jpg" alt="Logo" style="width: 100px; height: 100px;">
                    <h2 style="margin: 0; text-transform: uppercase;">DINAS DKUKMP KABUPATEN TANAH DATAR</h2>
                    <p style="margin: 5px 0; font-size: 14px;">
                       Jalan Prof Muhammad Yamin, Baringin, Kec. Lima Kaum, Kabupaten Tanah Datar, Sumatera Barat 27781
                    </p>
                </div>
                <hr style="border: 2px solid black; margin-bottom: 20px;">
            `;
                },

                buatBlokTandaTangan: () => {
                    return `
                <div style="width: 100%; margin-top: 30px;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 60%;"></td>
                            <td style="width: 40%; text-align: center;">
                                <p style="margin: 0;">Tanah Datar, ${utilityFormatter.tanggal.keIndonesia(new Date())}</p>
                                <p style="margin: 5px 0;">Kepala Dinas DKUKMP</p>
                                <p style="margin: 5px 0;">Kabupaten Tanah Datar</p>
                                <br><br><br><br>
                                <p style="margin: 0;"><u><b>NAMA PEJABAT</b></u></p>
                                <p style="margin: 0;">NIP. 19XXXXXXXXXX</p>
                            </td>
                        </tr>
                    </table>
                </div>
            `;
                },

                aturGayaTabel: (dokumen) => {
                    const tabelDataTable = $(dokumen).find('table.dataTable');

                    tabelDataTable.addClass('table-bordered').css({
                        'border-collapse': 'collapse',
                        'width': '100%',
                        'margin-bottom': '20px',
                        'font-size': '12px'
                    });

                    tabelDataTable.find('thead th').css({
                        'background-color': '#f5f5f5',
                        'font-weight': 'bold',
                        'text-align': 'center',
                        'vertical-align': 'middle',
                        'padding': '8px',
                        'border': '1px solid #000'
                    });

                    tabelDataTable.find('tbody td').css({
                        'padding': '8px',
                        'border': '1px solid #000'
                    });
                }
            };

            // ==========================================
            // Konfigurasi DataTables
            // ==========================================
            const konfigurasiDasar = {
                paging: false,
                searching: false,
                info: false,
                ordering: false,
                dom: 'Bfrtip'
            };

            // Generator tombol cetak PDF
            const buatTombolCetak = (judul) => ({
                extend: 'print',
                text: '<i class="fas fa-print"></i> Cetak PDF',
                className: 'btn btn-danger',
                title: '',
                customize: function(win) {
                    const dokumen = win.document.body;

                    dokumenKustomisasi.aturGayaDasar(dokumen);
                    $(dokumen).prepend(dokumenKustomisasi.buatKopSurat());

                    // Menambahkan judul setelah kop surat dan sebelum tabel
                    $(dokumen).find('table.dataTable').before(`
                <div style="text-align: center; margin: 20px 0;">
                    <h3 style="margin: 0; text-transform: uppercase; text-decoration: underline;">
                        ${judul}
                    </h3>
                </div>
            `);

                    $(dokumen).append(dokumenKustomisasi.buatBlokTandaTangan());
                    dokumenKustomisasi.aturGayaTabel(dokumen);
                }
            });

            // Generator tombol Excel
            const buatTombolExcel = (judul, namaFile) => ({
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-success',
                title: judul,
                filename: `${namaFile}_${utilityFormatter.tanggal.untukNamaFile(new Date())}`
            });

            // Fungsi inisialisasi DataTable
            const inisialisasiDataTable = (selector, judul, namaFile) => {
                return $(selector).DataTable({
                    ...konfigurasiDasar,
                    buttons: [
                        buatTombolCetak(judul),
                        buatTombolExcel(judul, namaFile)
                    ]
                });
            };

            // ==========================================
            // Inisialisasi Semua DataTables
            // ==========================================
            inisialisasiDataTable('#datatablesSimple', 'LAPORAN BARANG MASUK', 'Laporan_Barang_Masuk');
            inisialisasiDataTable('#datatablesSimple2', 'LAPORAN PENGELUARAN BARANG', 'Laporan_Pengeluaran_Barang');
            inisialisasiDataTable('#datatablesSimple3', 'LAPORAN STOK BARANG', 'Laporan_Stok_Barang');
        });
    </script>

</body>

</html>