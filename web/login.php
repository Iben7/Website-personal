<?php
session_start();

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];  // Password tidak akan diverifikasi

    // Koneksi ke database
    $conn = new mysqli('localhost', 'root', '', 'laptop_recommender'); // Sesuaikan dengan kredensial database Anda

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mengambil data pengguna berdasarkan username/email
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah pengguna ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Set session untuk pengguna
        $_SESSION['user_id'] = $user['id'];  // Misalnya ID pengguna
        $_SESSION['username'] = $user['username'];  // Simpan username di session

        // Tampilkan pesan pop-up dan alihkan ke dashboard
        echo "<script>
                alert('Login berhasil! Data telah tercatat di database.');
                window.location.href = 'dashboard.php';  // Arahkan ke halaman dashboard
              </script>";
    } else {
        echo "<script>alert('Pengguna tidak ditemukan!');</script>";
    }

    $conn->close();
}
?>
