<?php
session_start(); // Pastikan session dimulai

// Hapus semua data sesi
session_unset();
session_destroy();

// Arahkan pengguna ke halaman login atau halaman lain yang sesuai
header('Location: ../login.php');
exit();
?>