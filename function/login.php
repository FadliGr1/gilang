<?php
include 'mysql.php';

// Memeriksa login
$email = $_POST['email'];
$password = $_POST['password'];
$kategori = $_POST['kategori'];

$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND kategori = '$kategori'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 1) {
    // Login berhasil
    session_start();
    $_SESSION['loggedin'] = true;
    $_SESSION['kategori'] = $kategori;

    // Ambil data pengguna dari hasil query
    $user = mysqli_fetch_assoc($result);

    if ($kategori == 'admin') {
        $_SESSION['admin_nama'] = $user['nama_lengkap'];
        header('Location: ../index.php');
    } elseif ($kategori == 'pengguna') {
        $_SESSION['user_nama'] = $user['nama_lengkap'];
        $_SESSION['user_id'] = $user['id'];
        header('Location: ../index.php');
    }
} else {
    // Login gagal
    echo "<script>alert('Email, password, atau kategori tidak valid!'); window.location='../index.php';</script>";
}

mysqli_close($koneksi);
