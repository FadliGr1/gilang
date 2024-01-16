<?php
session_start(); // Pastikan session dimulai di awal file

// Pengecekan status login
if (isset($_SESSION['loggedin'])) {
    // Jika sudah login
    $profileLink = 'profile.php';
    $ordersLink = 'pesanan.php';
    $cartLink = 'keranjang.php';
    $logoutLink = 'function/logout.php'; // Sesuaikan dengan halaman logout yang sesuai
} else {
    // Jika belum login
    $profileLink = 'login.php';
    $ordersLink = 'login.php';
    $cartLink = 'login.php';
    $logoutLink = ''; // Tidak perlu menampilkan link logout jika belum login
}

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin'])) {
    // Jika belum login, mungkin akan diarahkan ke halaman login atau tindakan lainnya
    header('Location: login.php');
    exit;
}

$no_hp = '';
$email = '';
$alamat = '';

// Menampilkan informasi pengguna berdasarkan kategori
if ($_SESSION['kategori'] == 'admin') {
    $nama_lengkap = $_SESSION['admin_nama'];
} elseif ($_SESSION['kategori'] == 'pengguna') {
    $nama_lengkap = $_SESSION['user_nama'];
    $user_id = $_SESSION['user_id'];

    include 'mysql.php';

    $query_user_info = "SELECT no_hp, email, alamat FROM users WHERE id = $user_id";
    $result_user_info = mysqli_query($koneksi, $query_user_info);

    if ($result_user_info && mysqli_num_rows($result_user_info) > 0) {
        $user_info = mysqli_fetch_assoc($result_user_info);
        $no_hp = $user_info['no_hp'];
        $email = $user_info['email'];
        $alamat = $user_info['alamat'];
    } else {
        // Penanganan kesalahan jika query tidak berhasil
        $no_hp = $email = $alamat = 'Data tidak ditemukan';
    }

    mysqli_close($koneksi);
}
