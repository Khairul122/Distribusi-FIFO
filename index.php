<?php
// Set header-cache untuk mencegah caching halaman
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tambahkan link CSS Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<?php 
session_start();
?>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <img src="./assets/img/Logo Kota Medan.png" alt="Logo" style="height: 200px; display: block; margin: 0 auto;" class="mt-2" />
                        <h1 class="text-center">LOGIN</h1>
                        <form action="proses/login.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username :</label>
                                <input type="text" class="form-control" name="username" id="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password :</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <a href="views/registrasi.php"></a>
                           <!-- Pesan kesalahan -->
                            <?php
                            if (isset($_SESSION['error_message'])) {
                                echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
                                unset($_SESSION['error_message']); // Hapus pesan kesalahan setelah ditampilkan
                            }
                            ?>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
         <?php
        if (isset($_SESSION['error_message'])) {
            echo 'document.getElementById("error-message").textContent = "' . $_SESSION['error_message'] . '";';
            unset($_SESSION['error_message']); // Hapus pesan kesalahan setelah ditampilkan
        }
        ?>
    </script>
</body>
</html>