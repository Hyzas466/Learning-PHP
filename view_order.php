<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Pesanan - kafe upn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="csstugas2.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=coffee" />
    <style>
    
    body{
    font-family: "Poppins", sans-serif;
    font-weight: 900;
    font-style: italic;
    color: white;
    font: bold;
    background-image: url('https://images.unsplash.com/photo-1545288017-c5bfc9d8820d?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    margin: 0;
    height: 100vh;
    
    .container{
      width: 600px;
      background: grey;
      border-radius: 15px;
      padding: 30px;
    }

    .form-select{
      width: 500px;
    }

    button {
      margin-right: 5%;
    }
}
  </style>
</head>
<body>
<nav>
  <div class="nav-brand">
    <a href="#">Kafe UPN</a>
  </div>
  <ul class="nav-links">
    <li><a href="dashboard.php">Dashboard</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</nav>
    <h1>Rincian Pesanan</h1>

    <?php
    $conn = new mysqli("localhost", "root", "", "kafe_upn");
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($id) {
        $stmt = $conn->prepare("SELECT menu, hot_ice, size, sweetness_level, dairy, topping, note FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $order = $result->fetch_assoc();

            $menuPrices = [
                "1" => ["Americano", 12000, 0.10],
                "2" => ["Mochaccino", 15000, 0.10],
                "3" => ["Hazelnut Latte", 20000, 0.15],
                "4" => ["Vanilla Latte", 17000, 0.15],
                "5" => ["Salted Caramel", 18000, 0.15]
            ];

            $dairyPrices = ["Milk" => 5000, "Oat Milk" => 6000, "Almond Milk" => 7000];
            $toppingPrices = ["Caramel Sauce" => 3000, "Caramel Crumble" => 3000, "Choco Granola" => 4000, "Sea Salt Cream" => 5000];

            // Mengambil nilai dari database
            $menu = $order['menu'];
            $hotIce = $order['hot_ice'];
            $size = $order['size'];
            $sweetness = $order['sweetness_level'];
            $dairy = $order['dairy'] ?? '-';
            $topping = $order['topping'] ?? '-';
            $note = $order['note'] ?? '-';

            if (isset($menuPrices[$menu])) {
                $menuName = $menuPrices[$menu][0];
                $basePrice = $menuPrices[$menu][1];
                $taxRate = $menuPrices[$menu][2];

                $sizePrice = ($size == "Large") ? 5000 : 0;
                $dairyPrice = isset($dairyPrices[$dairy]) ? $dairyPrices[$dairy] : 0;

                $toppingTotalPrice = 0;
                foreach (explode(', ', $topping) as $t) {
                    $toppingTotalPrice += isset($toppingPrices[$t]) ? $toppingPrices[$t] : 0;
                }

                $totalPriceBeforeTax = $basePrice + $sizePrice + $dairyPrice + $toppingTotalPrice;
                $taxAmount = $totalPriceBeforeTax * $taxRate;
                $finalPrice = $totalPriceBeforeTax + $taxAmount;

                $taxRatePercent = $taxRate * 100;
                echo "<div class='container'>";
                echo "<table class='table table-bordered'>";
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
                echo "</div>";
                echo "</table>";

            } else {
                echo "<div class='alert alert-danger'>Menu yang dipilih tidak valid.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Pesanan tidak ditemukan.</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>ID pesanan tidak diberikan.</div>";
    }

    $conn->close();
    ?>

    <a href="dashboard.php" class="btn btn-light mt-3 w-100">Kembali ke Dashboard!</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
