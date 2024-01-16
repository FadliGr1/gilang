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

    <div class="container my-5 pt-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-6 col-10">
                <div class="card card-profile p-md-5 p-2 rounded-4">
                    <p class="text-black fw-semibold fs-5 text-center mb-5">
                        Profil
                    </p>
                    <p class="text-black-50 fw-normal fs-6 text-start">Nama Lengkap: <?= $nama_lengkap ?></p>
                    <?php
                    $profile = "SELECT * FROM users WHERE nama_lengkap = '$nama_lengkap'";
                    $result = mysqli_query($koneksi, $profile);
                    $row = mysqli_fetch_assoc($result);
                    $user_id = $row['id'];
                    $no_hp = $row['no_hp'];
                    $email = $row['email'];
                    $alamat = $row['alamat'];
                    ?>
                    <p class="text-black-50 fw-normal fs-6 text-start">Nomor Telephone: <?= $no_hp ?></p>
                    <p class="text-black-50 fw-normal fs-6 text-start">Email: <?= $email ?></p>
                    <p class="text-black-50 fw-normal fs-6 text-start">Alamat: <?= $alamat ?></p>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-profile mt-5 d-inline" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Edit Profile
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="">
                                        <div class="mb-3">
                                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Gilang ...">
                                        </div>
                                        <div class="mb-3">
                                            <label for="no_handphone" class="form-label">Nomor Telephone</label>
                                            <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="08xxx">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="sayhai@gilang.com">
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                                        </div>

                                        <!-- Tambahkan input untuk mengirim user_id -->
                                        <input type="hidden" name="user_id" value="<?= $user_id ?>">

                                        <!-- Tombol submit -->
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Update</button>
                                        <!-- <button type="button" class="btn btn-primary">Update</button> -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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