<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Laptop Recommender</title>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: #f4f7fc;
            color: #333;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            border-radius: 8px;
            margin-top: 20px;
        }

        .sidebar h2 {
            font-size: 1.6em;
            margin-bottom: 20px;
            color: #4e73df;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
            margin: 8px 0;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background: #4e73df;
            color: #fff;
        }

        /* Main Content */
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        .main-content h1 {
            font-size: 2.4em;
            color: #4e73df;
            margin-bottom: 30px;
        }

        /* Product Cards */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: #fff;
            padding: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .product-card h3 {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 10px;
        }

        .product-card p {
            font-size: 1em;
            color: #666;
            margin-bottom: 15px;
        }

        .product-card .price {
            font-size: 1.2em;
            color: #4e73df;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .product-card button {
            background: #4e73df;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .product-card button:hover {
            background: #3e5bbf;
        }

        /* Filter Section */
        .filter-section {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .filter-section h2 {
            font-size: 1.8em;
            color: #4e73df;
            margin-bottom: 15px;
        }

        .filter-section select,
        .filter-section input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .filter-section button {
            width: 100%;
            background: #4e73df;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .filter-section button:hover {
            background: #3e5bbf;
        }

    </style>
</head>
<body>

<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Filter Produk</h2>
        <a href="#">Kategori</a>
        <a href="#">Harga</a>
        <a href="#">Merek</a>
        <a href="#">Tipe Prosesor</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Rekomendasi Laptop</h1>

        <!-- Filter Section -->
        <div class="filter-section">
            <h2>Filter Pencarian</h2>
            <input type="text" placeholder="Cari laptop..." id="searchInput">
            <select id="categorySelect">
                <option value="">Pilih Kategori</option>
                <option value="gaming">Gaming</option>
                <option value="ultrabook">Ultrabook</option>
                <option value="student">Untuk Pelajar</option>
            </select>
            <select id="ramSelect">
                <option value="">Pilih RAM</option>
                <option value="4GB">4GB</option>
                <option value="8GB">8GB</option>
                <option value="16GB">16GB</option>
            </select>
            <select id="processorSelect">
                <option value="">Pilih Prosesor</option>
                <option value="i3">Intel i3</option>
                <option value="i5">Intel i5</option>
                <option value="i7">Intel i7</option>
            </select>
            <input type="number" id="minPrice" placeholder="Harga Min (juta)" min="0">
            <input type="number" id="maxPrice" placeholder="Harga Max (juta)" min="0">
            <button id="filterButton">Filter</button>
        </div>

        <!-- Product Grid -->
        <div class="product-grid" id="productGrid">
            <!-- Product Cards will be populated dynamically based on filter -->
        </div>

    </div>
</div>

<script>
    // Array of products with category and details
    const products = [
        { name: 'MSI Bravo 15', category: 'gaming', description: 'Intel i7, 16GB RAM, 512GB SSD', price: 23000000, image: 'MSI Bravo 15.jpg', ram: '16GB', processor: 'i7' },
        { name: 'MSI Thin GF63 12UCX', category: 'gaming', description: 'Intel i5, 8GB RAM, 256GB SSD', price: 17000000, image: 'MSI Thin GF63 12UCX.jpg', ram: '8GB', processor: 'i5' },
        { name: 'MSI Thin A15', category: 'gaming', description: 'Intel i3, 4GB RAM, 128GB SSD', price: 7000000, image: 'MSI Thin A15.jpg', ram: '4GB', processor: 'i3' },
        { name: 'HP Victus 15', category: 'gaming', description: 'Intel i5, 8GB RAM, 256GB SSD', price: 8999999, image: 'HP Victus 15.jpg', ram: '8GB', processor: 'i5' },
        { name: 'Acer Aspire 14 A14', category: 'ultrabook', description: 'Intel i5, 8GB RAM, 256GB SSD', price: 16999999, image: 'A14-51M.jpg', ram: '8GB', processor: 'i5' },
        { name: 'Acer Aspire Ultrabook 1', category: 'ultrabook', description: 'Intel i5, 8GB RAM, 256GB SSD', price: 16000000, image: 'ultra1.jpg', ram: '8GB', processor: 'i5' }
        // Add more products as needed
    ];

    const filterButton = document.getElementById('filterButton');
    const productGrid = document.getElementById('productGrid');

    // Bobot untuk kriteria
    const weights = {
        category: 2,      // Kategori lebih penting
        ram: 1,           // RAM agak penting
        processor: 1.5,   // Prosesor penting
        price: 1          // Harga cukup penting
    };

    // Function to display products
    function displayProducts(filteredProducts) {
        productGrid.innerHTML = '';
        filteredProducts.forEach(product => {
            const productCard = document.createElement('div');
            productCard.classList.add('product-card');
            productCard.innerHTML = `
                <img src="${product.image}" alt="${product.name}">
                <h3>${product.name}</h3>
                <p>${product.description}</p>
                <p class="price">Rp ${product.price.toLocaleString()}</p>
                <button>Buy Now</button>
            `;
            productGrid.appendChild(productCard);
        });
    }

    filterButton.addEventListener('click', () => {
        const category = document.getElementById('categorySelect').value;
        const ram = document.getElementById('ramSelect').value;
        const processor = document.getElementById('processorSelect').value;
        const minPrice = parseFloat(document.getElementById('minPrice').value) * 1000000 || 0;
        const maxPrice = parseFloat(document.getElementById('maxPrice').value) * 1000000 || Infinity;

        // Filter produk sesuai kriteria
        const filteredProducts = products.filter(product => {
            return (
                (category === '' || product.category === category) &&
                (ram === '' || product.ram === ram) &&
                (processor === '' || product.processor === processor) &&
                (product.price >= minPrice && product.price <= maxPrice)
            );
        });

        // Hitung skor berdasarkan pembobotan
        const scoredProducts = filteredProducts.map(product => {
            let score = 0;

            if (category === '' || product.category === category) {
                score += weights.category;
            }
            if (ram === '' || product.ram === ram) {
                score += weights.ram;
            }
            if (processor === '' || product.processor === processor) {
                score += weights.processor;
            }
            if (product.price >= minPrice && product.price <= maxPrice) {
                score += weights.price;
            }

            return { product, score };
        });

        // Urutkan produk berdasarkan skor
        scoredProducts.sort((a, b) => b.score - a.score);

        // Tampilkan produk yang sudah diurutkan berdasarkan skor
        displayProducts(scoredProducts.map(scoredProduct => scoredProduct.product));
    });
</script>

</body>
</html>
