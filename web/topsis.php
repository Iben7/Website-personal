<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "laptop_recommender";

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data laptop dari database
$sql = "SELECT name, price, processor_speed, ram, rating FROM laptops";
$result = $conn->query($sql);

// Matriks Keputusan
$laptops = [];
while ($row = $result->fetch_assoc()) {
    $laptops[] = [
        'name' => $row['name'],
        'price' => $row['price'],
        'processor_speed' => $row['processor_speed'],
        'ram' => $row['ram'],
        'rating' => $row['rating']
    ];
}

// Matriks Keputusan dan Bobot
$decisionMatrix = [];
$weights = [0.4, 0.3, 0.2, 0.1]; // Bobot untuk harga, prosesor, RAM, rating

// Normalisasi Matriks Keputusan
foreach ($laptops as $laptop) {
    $normPrice = $laptop['price'] / sqrt(array_sum(array_column($laptops, 'price')));
    $normProcessorSpeed = $laptop['processor_speed'] / sqrt(array_sum(array_column($laptops, 'processor_speed')));
    $normRam = $laptop['ram'] / sqrt(array_sum(array_column($laptops, 'ram')));
    $normRating = $laptop['rating'] / sqrt(array_sum(array_column($laptops, 'rating')));
    $decisionMatrix[] = [
        'price' => $normPrice,
        'processor_speed' => $normProcessorSpeed,
        'ram' => $normRam,
        'rating' => $normRating
    ];
}

// Hitung Solusi Ideal Positif (+) dan Negatif (-)
$idealPositive = [
    max(array_column($decisionMatrix, 'price')),
    max(array_column($decisionMatrix, 'processor_speed')),
    max(array_column($decisionMatrix, 'ram')),
    max(array_column($decisionMatrix, 'rating'))
];

$idealNegative = [
    min(array_column($decisionMatrix, 'price')),
    min(array_column($decisionMatrix, 'processor_speed')),
    min(array_column($decisionMatrix, 'ram')),
    min(array_column($decisionMatrix, 'rating'))
];

// Hitung Jarak dan Skor TOPSIS
$scores = [];
foreach ($decisionMatrix as $index => $matrix) {
    $dPositive = sqrt(
        pow($matrix['price'] - $idealPositive[0], 2) +
        pow($matrix['processor_speed'] - $idealPositive[1], 2) +
        pow($matrix['ram'] - $idealPositive[2], 2) +
        pow($matrix['rating'] - $idealPositive[3], 2)
    );

    $dNegative = sqrt(
        pow($matrix['price'] - $idealNegative[0], 2) +
        pow($matrix['processor_speed'] - $idealNegative[1], 2) +
        pow($matrix['ram'] - $idealNegative[2], 2) +
        pow($matrix['rating'] - $idealNegative[3], 2)
    );

    $score = $dNegative / ($dPositive + $dNegative);
    $scores[] = ['laptop' => $laptops[$index]['name'], 'score' => $score];
}

// Urutkan berdasarkan skor
usort($scores, function ($a, $b) {
    return $b['score'] <=> $a['score'];
});

// Tampilkan laptop berdasarkan skor
foreach ($scores as $score) {
    echo $score['laptop'] . " - Skor: " . $score['score'] . "<br>";
}

$conn->close();
?>
