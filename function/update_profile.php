<?php
include 'mysql.php';

// Periksa apakah data formulir dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $user_id = $_POST['user_id'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    // Update data pengguna di database
    $query = "UPDATE users SET nama_lengkap='$nama_lengkap', no_hp='$no_hp', email='$email', alamat='$alamat' WHERE id=$user_id ";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data pengguna berhasil diperbarui'); window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data pengguna'); window.location='profile.php';</script>";
    }
}

mysqli_close($koneksi);
