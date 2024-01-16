<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/main.css">
</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-4 col-10">
                <form class="form-auth py-5 px-3" action="function/login.php" method="post" enctype="multipart/form-data">
                    <div class="d-flex justify-content-center mb-5">
                        <img src="assets/img/logo.svg" alt="" class="img-fluid w-25">
                    </div>
                    <div class="">
                        <input type="text" name="email" class="form-control" id="email" placeholder="nomor telephone atau email">
                    </div>
                    <div class="my-3">
                        <input type="password" name="password" class="form-control" id="password" placeholder="kata sandi">
                        <input type="text" id="kategori" name="kategori" value="admin" class="form-control form-control-lg" hidden />
                    </div>
                    <div class="mb-3">
                        <a href="#" class="text-black">Lupa kata sandi?</a>
                    </div>
                    <button type="submit" class="btn btn-success col-12">
                        Masuk
                    </button>
                    <p class="text-center my-3">Or</p>
                    <button class="btn btn-success col-12">
                        Daftar
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>