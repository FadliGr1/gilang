<?php
include 'function/session.php';
include 'function/mysql.php';

$product_id = $_GET['product_id'] ?? '';
$product_name = $_GET['product_name'] ?? '';
$product_price = $_GET['product_price'] ?? '';

$query = "SELECT alamat FROM users WHERE nama_lengkap = '$nama_lengkap'";
$result = mysqli_query($koneksi, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $alamat = $row['alamat'];
    }

    mysqli_free_result($result);
}

// Tambahkan produk ke keranjang jika informasi produk ada
if ($product_id && $product_name && $product_price) {
    $product = [
        'id' => $product_id,
        'name' => $product_name,
        'price' => $product_price,
        'quantity' => 1 // Set jumlah default ke 1
    ];
    // Tambahkan produk ke dalam sesi
    $_SESSION['cart'][$product_id] = $product;
}
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
    <div class="container my-5 pt-5">
        <h2>Keranjang Belanja</h2>

        <?php
        // Tampilkan produk di keranjang belanja
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id => $product) {
        ?>
                <div class="row p-2 my-cart my-2" id="cartItem<?= $product_id ?>">
                    <div class="col-md-3 d-flex">
                        <!-- Tampilkan gambar produk sesuai kebutuhan -->
                        <img src="assets/img/feed.jpg" alt="w-100" class="img-fluid rounded-3">
                    </div>
                    <div class="col-md">
                        <p class="fw-semibold"><?= $product['name'] ?></p>
                        <p class="fw-semibold">Rp. <?= number_format($product['price'], 0, ',', '.') ?></p>
                        <p class="fw-semibold">Jumlah </p>
                        <input type="number" name="quantity" id="quantity<?= $product_id ?>" min="1" value="<?= $product['quantity'] ?>" oninput="updateTotal(<?= $product_id ?>)">
                        <p class="fw-semibold">Total : Rp. <span id="total<?= $product_id ?>"><?= number_format($product['price'] * $product['quantity'], 0, ',', '.') ?></span></p>
                    </div>
                    <div class="col-md d-flex justify-content-end align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault<?= $product_id ?>">
                            <label class="form-check-label" for="flexCheckDefault<?= $product_id ?>">
                            </label>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            // Tampilkan pesan jika tidak ada produk di keranjang
            echo '<p>Keranjang belanja masih kosong.</p>';
        }
        ?>
    </div>

    <nav class="navbar bawah fixed-bottom py-3">
        <div class="container">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="pilihSemua">
                    <label class="form-check-label text-white fw-semibold" for="pilihSemua">
                        Pilih Semua
                    </label>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center">
                <p class="text-white">Total Semua Produk : <span id="totalAll"></span></p>
                <form action="checkout.php" method="post">
                    <input type="hidden" id="totalAllCO" name="totalAllCO" readonly>
                    <input type="hidden" name="user" value="<?= $nama_lengkap ?>" readonly>
                    <input type="hidden" name="alamat" value="<?= $alamat ?>" readonly>
                    <?php foreach ($_SESSION['cart'] as $product_id => $product) : ?>
                        <!-- Menyertakan input dengan nama produk sebagai nilai -->
                        <input type="hidden" name="product_names[]" value="<?= htmlspecialchars($product['name']) ?>" readonly>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-checkout float-end ms-3">Checkout</button>
                </form>
            </div>                                                            
        </div>
    </nav>

    <script>
        function updateTotal(product_id) {
            // Ambil nilai jumlah dari input
            var quantityElement = document.getElementById('quantity' + product_id);
            var quantity = quantityElement.value;

            // Harga produk dari PHP
            var productPriceInCents = <?= $product['price'] * 100 ?>;

            // Hitung total berdasarkan jumlah produk
            var totalInCents = quantity * productPriceInCents;

            // Konversi total ke dalam format rupiah
            var totalFormatted = (totalInCents / 100).toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            });

            // Tampilkan total yang dihitung
            document.getElementById('total' + product_id).innerText = totalFormatted;

            // Update total semua produk
            updateTotalAll();

            // Perbarui nilai input quantity sebelum mengirim formulir
            quantityElement.value = quantity;
        }


        function updateTotalAll() {
            var totalAll = 0;

            <?php
            foreach ($_SESSION['cart'] as $product_id => $product) {
            ?>
                var quantity = document.getElementById('quantity<?= $product_id ?>').value;
                var isChecked = document.getElementById('flexCheckDefault<?= $product_id ?>').checked;
                var productPriceInCents = <?= $product['price'] * 100 ?>;

                if (isChecked) {
                    var totalInCents = quantity * productPriceInCents;
                    totalAll += totalInCents;
                }
            <?php
            }
            ?>

            var totalAllFormatted = (totalAll / 100).toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            });

            document.getElementById('totalAll').innerText = totalAllFormatted;
            document.getElementById('totalAllCO').value = totalAllFormatted;
        }

        // Tambahkan event listener untuk checkbox "Pilih Semua"
        document.getElementById('pilihSemua').addEventListener('change', function() {
            // Ambil nilai checkbox "Pilih Semua"
            var isChecked = this.checked;

            <?php
            // Loop melalui produk di keranjang belanja
            foreach ($_SESSION['cart'] as $product_id => $product) {
            ?>
                // Set nilai checkbox untuk setiap produk sesuai dengan "Pilih Semua"
                var checkbox = document.getElementById('flexCheckDefault<?= $product_id ?>');
                checkbox.checked = isChecked;

                // Update total semua produk
                updateTotalAll();
            <?php
            }
            ?>
        });

        <?php
        foreach ($_SESSION['cart'] as $product_id => $product) {
        ?>
            // Tambahkan event listener pada checkbox masing-masing produk
            document.getElementById('flexCheckDefault<?= $product_id ?>').addEventListener('change', function() {
                updateTotalAll();
            });
        <?php
        }
        ?>
    </script>

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