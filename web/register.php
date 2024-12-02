<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Validasi input
    if ($password === $confirm_password) {
        // Koneksi ke database
        $conn = new mysqli('localhost', 'root', '', 'laptop_recommender');

        // Mengecek koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Enkripsi password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Menyimpan data ke database
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Selamat! Anda berhasil membuat akun!'); window.location.href = 'index.html';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "<script>alert('Password dan konfirmasi password tidak cocok!');</script>";
    }
}
?>
