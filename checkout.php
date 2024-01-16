<?php
include 'function/session.php';
include 'function/mysql.php';

$query = "SELECT * FROM users WHERE nama_lengkap = '$nama_lengkap'";
$result = mysqli_query($koneksi, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $alamat = $row['alamat'];
        $no_hp = $row['no_hp'];
    }

    mysqli_free_result($result);
}

$totalAllCO = isset($_POST['totalAllCO']) ? $_POST['totalAllCO'] : '';
$user = isset($_POST['user']) ? $_POST['user'] : '';
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
$product_names = isset($_POST['product_names']) ? $_POST['product_names'] : [];

// Inisialisasi variabel $image_url
$image_url = '';

// Loop melalui daftar product_names
foreach ($product_names as $product_name) {
    $query = "SELECT * FROM product WHERE product_name = '$product_name'";
    $result_img = mysqli_query($koneksi, $query);

    if ($result_img) {
        // Check if any row is returned
        if (mysqli_num_rows($result_img) > 0) {
            $row = mysqli_fetch_assoc($result_img);
            // Gunakan .= untuk menggabungkan URL gambar dari setiap produk
            $image_url .= $row['image_url'] . ', ';
        }

        // Free the result set
        mysqli_free_result($result_img);
    }
}

// Hapus koma dan spasi ekstra dari akhir string $image_url
$image_url = rtrim($image_url, ', ');

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/main.css">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">KS</a>
            <ul class="navbar-nav me-auto ms-5 d-none d-md-block">
                <li class="nav-item">
                    <a class="nav-link text-white" href="product.php">Produk</a>
                </li>
            </ul>
            <div class="d-flex justify-content-center align-items-center me-3 d-none d-md-block">
                <form class="d-flex MT-3" role="search">
                    <input class="form-control me-2 " type="search" placeholder="Cari di KS" aria-label="Search">
                    <button class="btn btn-secondary px-3" type="submit">Cari</button>
                </form>
            </div>
            <a href="keranjang.php" class="d-none d-md-block">
                <i data-feather="shopping-cart" class="ms-3 me-5 text-white"></i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background-color: #41704B; color: #fff;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">KS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?php echo $profileLink; ?>">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $ordersLink; ?>">Pesanan Saya</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $cartLink; ?>">Keranjang</a>
                        </li>
                        <?php if ($logoutLink != '') : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $logoutLink; ?>">Keluar</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- kontent -->
    <div class="container mt-5 pt-5 ">
        <div class="row checkout-page rounded-3">
            <div class="col py-3 ">
                <p class="fw-semibold fs-5 text-start text-black">Data Pembeli</p>
                <p class="fw-normal fs-6 text-start text-black"><?= $nama_lengkap . ' ' . $no_hp ?></p>
                <p class="fw-normal fs-6 text-start text-black"><?= $alamat ?></p>
            </div>
        </div>
        <?php
        // Loop melalui daftar nama produk dari session
        foreach ($_POST['product_names'] as $product_name) {
            $query = "SELECT * FROM product WHERE product_name = '$product_name'";
            $result_img = mysqli_query($koneksi, $query);

            if ($result_img && mysqli_num_rows($result_img) > 0) {
                $row = mysqli_fetch_assoc($result_img);
                $image_url = $row['image_url'];
                $product_price = $row['price'];
                // Tampilkan blok HTML untuk setiap produk dengan heredoc
                echo <<<HTML
                            <div class="row my-3 py-3 checkout-page rounded-3">
                                <div class="col-2">
                                    <img src="$image_url" alt="" class="img-fluid w-100 rounded-4">
                                </div>
                                <div class="col-md-8 align-items-center">
                                    <p class="fw-semibold">$product_name</p>
                                    <p class="fw-normal fs-6 text-start text-black">Harga satuan : Rp. $product_price</p>
                                </div>
                            </div>
                        HTML;
                // Free the result set
                mysqli_free_result($result_img);
            }
        }
        ?>
    </div>

    <!-- footer -->
    <div class="container-fluid py-5 mt-5" style="background-color: #41704B;">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <p class="text-white fw-semibold text-start">
                        Kedai Susmiyati
                        <br> <br>
                        Jalan Raya Kedungwringin, Kelurahan
                        Kedungwringin, Kec. Patikraja,
                        Kab. Banyumas, Jawa Tengah

                    </p>
                </div>
                <div class="col-md-4">
                    <p class="text-white fw-semibold text-start">
                        Hubungi Kami :
                        <br> <br>
                        Whatsapp +6281393436632
                    </p>
                </div>
                <div class="col-md-4">
                    <img src="assets/img/KS.png" alt="" class="img-fluid w-50">
                </div>
            </div>
        </div>
    </div>
    <script>
        feather.replace();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>