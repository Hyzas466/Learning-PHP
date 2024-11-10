<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Summary</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="csstugas2.css"> 
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav>
  <div class="nav-brand">
    <a href="#">Kafe UPN</a>
  </div>
  <ul class="nav-links">
    <li><a href="dashboard.php">Dashboard</a></li>
    <li><a href="/logout">Logout</a></li>
  </ul>
</nav>

<!-- Konten Utama -->
<div class="container my-5">
  <div class="text-dark p-5 rounded"> 
    <h1>Nota</h1>

    <?php
    $conn = new mysqli("localhost", "root", "", "kafe_upn");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Mengambil data dari form
    $menu = $_POST['menu'] ?? '-';
    $hotIce = $_POST['hotice'] ?? '-';
    $size = $_POST['size'] ?? '-';
    $sweetness = $_POST['sweetness'] ?? '-';
    $dairy = $_POST['dairy'] ?? '-';
    $topping = isset($_POST['topping']) ? $_POST['topping'] : ['-'];
    $note = !empty($_POST['note']) ? $_POST['note'] : '-';

    $topping = implode(', ', $topping);

    // Perintah SQL untuk menyimpan data
    $sql = "INSERT INTO orders (menu, hot_ice, size, sweetness_level, dairy, topping, note) 
            VALUES ('$menu', '$hotIce', '$size', '$sweetness', '$dairy', '$topping', '$note')";

    if ($conn->query($sql) === TRUE) {
      echo "Order success!";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();

    // Data harga
    $menuPrices = [
        "1" => ["Americano", 12000, 0.10],
        "2" => ["Mochaccino", 15000, 0.10],
        "3" => ["Hazelnut Latte", 20000, 0.15],
        "4" => ["Vanilla Latte", 17000, 0.15],
        "5" => ["Salted Caramel", 18000, 0.15]
    ];

    $dairyPrices = ["Milk" => 5000, "Oat Milk" => 6000, "Almond Milk" => 7000];
    $toppingPrices = ["Caramel Sauce" => 3000, "Caramel Crumble" => 3000, "Choco Granola" => 4000, "Sea Salt Cream" => 5000];

    // Menghitung harga
    $menuName = $menuPrices[$menu][0];
    $basePrice = $menuPrices[$menu][1];
    $taxRate = $menuPrices[$menu][2];

    $sizePrice = ($size == "Large") ? 5000 : 0;
    $dairyPrice = ($dairy != '-') ? $dairyPrices[$dairy] : 0;

    $toppingTotalPrice = 0;
    foreach (explode(', ', $topping) as $t) {
        $toppingTotalPrice += $toppingPrices[$t] ?? 0;
    }

    $totalPriceBeforeTax = $basePrice + $sizePrice + $dairyPrice + $toppingTotalPrice;
    $taxAmount = $totalPriceBeforeTax * $taxRate;  
    $finalPrice = $totalPriceBeforeTax + $taxAmount;

    $taxRatePercent = $taxRate * 100;

    echo "<table class='table table-bordered order-summary-table'>";
    echo "<tr><td>Menu</td><td>{$menuName}</td></tr>";
    echo "<tr><td>Price</td><td>Rp " . number_format($basePrice, 0, ',', '.') . "</td></tr>";
    echo "<tr><td>Hot/Ice</td><td>{$hotIce}</td></tr>";
    echo "<tr><td>Size</td><td>{$size} (+ Rp " . number_format($sizePrice, 0, ',', '.') . ")</td></tr>";
    echo "<tr><td>Sweetness Level</td><td>{$sweetness}</td></tr>";
    echo "<tr><td>Dairy</td><td>{$dairy} (+ Rp " . number_format($dairyPrice, 0, ',', '.') . ")</td></tr>";
    echo "<tr><td>Toppings</td><td>" . ($topping != '-' ? $topping : '-') . " (+ Rp " . number_format($toppingTotalPrice, 0, ',', '.') . ")</td></tr>";
    echo "<tr><td>Note</td><td>{$note}</td></tr>";
    echo "<tr><td>Price Before Tax</td><td>Rp " . number_format($totalPriceBeforeTax, 0, ',', '.') . "</td></tr>";
    echo "<tr><td>Tax ({$taxRatePercent}%)</td><td>Rp " . number_format($taxAmount, 0, ',', '.') . "</td></tr>";
    echo "<tr><td>Total Price (after tax)</td><td>Rp " . number_format($finalPrice, 0, ',', '.') . "</td></tr>";
    echo "</table>";
    ?>

    <a href="dashboard.php" class="btn btn-light mt-3 w-100">Order lagi!</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
