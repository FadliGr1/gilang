<?php
// connection to mysql
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gilang';

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}
