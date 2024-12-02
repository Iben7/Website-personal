<?php
// Konfigurasi database
$host = "localhost";
$user = "root"; // Default user MySQL
$pass = "";     // Kosongkan jika tidak ada password
$dbname = "db_web";

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
echo "Koneksi berhasil!";
?>
