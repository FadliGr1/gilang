<?php
include 'function/session.php';
include 'function/mysql.php';
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
    <nav class="navbar atas fixed-top">
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
    <div class="container mt-5 pt-5">
        <div class="row p-4 list-card rounded-3 align-items-center">
            <div class="col-md-3 justify-content-center align-items-center">
                <img src="assets/img/KS.png" alt="" class="img-fluid">
                <p class="fw-semibold text-center mt-2 desc">Kedai Susmiyati</p>
            </div>
            <div class="col-md-6">
                <img src="assets/img/ibuk.png" alt="w-100" class="img-fluid">
            </div>
            <div class="col-md-3 justify-content-center align-items-center">
                <p class="fw-semibold text-center fs-3 desc">
                    Belanja Hemat
                    di KS Mart
                </p>
            </div>
        </div>
        <div class="row p-4 rounded-3 justify-content-center align-items-center mt-3">
            <?php

            $query = "SELECT * FROM product";
            $result = mysqli_query($koneksi, $query);

            // Hitung total produk dan tentukan jumlah maksimal yang akan ditampilkan
            $totalProducts = mysqli_num_rows($result);
            $maxProductsToShow = 6;

            // Tentukan apakah tombol "Lihat Lainnya" perlu ditampilkan
            $showLoadMoreButton = $totalProducts > $maxProductsToShow;

            // Hitung iterasi maksimal berdasarkan jumlah produk dan maksimum yang ditampilkan
            $maxIterations = min($totalProducts, $maxProductsToShow);

            for ($i = 0; $i < $maxIterations; $i++) {
                $row = mysqli_fetch_assoc($result);
            ?>
                <div class="col-md-3 p-2 list-card rounded-2 m-2">
                    <img src="<?= $row['image_url'] ?>" alt="" class="img-fluid w-100 rounded-3">
                    <div class="d-flex justify-content-end align-items-center mt-3">
                        <p class="text-white fw-semibold text-end me-3"><?= $row['product_name'] ?></p>
                        <a href="keranjang.php?product_id=<?= $row['id'] ?>&product_name=<?= $row['product_name'] ?>&product_price=<?= $row['price'] ?>" class="btn btn-secondary">Order</a>

                    </div>
                </div>
            <?php
            }

            mysqli_close($koneksi);
            ?>

            <?php if ($showLoadMoreButton) : ?>
                <button id="loadMoreButton" class="btn btn-next mt-4">Lihat Lainnya</button>

                <script>
                    document.getElementById('loadMoreButton').addEventListener('click', function() {
                        // Redirect atau tampilkan produk tambahan berikutnya
                        window.location.href = 'product.php';
                    });
                </script>
            <?php endif; ?>

        </div>
    </div>

    <!-- footer -->
    <div class="container-fluid py-5" style="background-color: #41704B;">
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
                    <img src="assets/img/KS.png" alt="" class="img-fluid w-75">
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