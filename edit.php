<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}



$conn = new mysqli("localhost", "root", "", "kafe_upn");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    $sql = "SELECT * FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if (!$order) {
        die("Order not found.");
    }

    $order['topping'] = explode(', ', $order['topping']);
} else {
    die("No order ID specified.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order - kafe upn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="csstugas2.css" />
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
        margin-top: 10%;
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

    <div class="container">
        <div class="sisi-kiri">
            <form action="order_baru.php" method="POST">    
               
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="Menu">
                    <label for="menu"> <b>Menu</b> </label>
                    <br>
                    <select class="form-select" name="menu" id="menu" aria-label="Default select example">
                        <option value="Americano" <?php if ($order['menu'] == 'Americano') echo 'selected'; ?>>Americano</option>
                        <option value="Mochaccino" <?php if ($order['menu'] == 'Mochaccino') echo 'selected'; ?>>Mochaccino</option>
                        <option value="Hazelnut Latte" <?php if ($order['menu'] == 'Hazelnut Latte') echo 'selected'; ?>>Hazelnut Latte</option>
                        <option value="Vanilla Latte" <?php if ($order['menu'] == 'Vanilla Latte') echo 'selected'; ?>>Vanilla Latte</option>
                        <option value="Salted Caramel" <?php if ($order['menu'] == 'Salted Caramel') echo 'selected'; ?>>Salted Caramel</option>
                    </select>
                </div>
                <br>
                <div class="Kondisi">
                    <label><b>Hot/ice</b></label>
                    <br>
                    <input class="form-check-input" type="radio" name="hotice" id="hot" value="Hot" <?php if ($order['hot_ice'] == 'Hot') echo 'checked'; ?>>
                    <label class="form-check-label" for="hot"> Hot </label>
                    <input class="form-check-input" type="radio" name="hotice" id="ice" value="Ice" <?php if ($order['hot_ice'] == 'Ice') echo 'checked'; ?>>
                    <label class="form-check-label" for="ice"> Ice </label>
                </div>
                <br>
                <div class="Ukuran">
                    <label><b>Size</b></label>
                    <br>
                    <input class="form-check-input" type="radio" name="size" id="regular" value="Regular" <?php if ($order['size'] == 'Regular') echo 'checked'; ?>>
                    <label class="form-check-label" for="regular"> Regular </label>
                    <input class="form-check-input" type="radio" name="size" id="large" value="Large" <?php if ($order['size'] == 'Large') echo 'checked'; ?>>
                    <label class="form-check-label" for="large"> Large </label>
                </div>
                <br>
                <div class="Gula">
                    <label><b>Sweetness Level</b></label>
                    <br>
                    <input class="form-check-input" type="radio" name="sweetness" id="normal" value="Normal Sugar" <?php if ($order['sweetness_level'] == 'Normal Sugar') echo 'checked'; ?>>
                    <label class="form-check-label" for="normal"> Normal Sugar </label>
                    <input class="form-check-input" type="radio" name="sweetness" id="less" value="Less Sugar" <?php if ($order['sweetness_level'] == 'Less Sugar') echo 'checked'; ?>>
                    <label class="form-check-label" for="less"> Less Sugar </label>
                </div>
                <br>
                <div class="Susu">
                    <label><b>DAIRY</b> <sup> (optional) </sup></label>
                    <br>
                    <input class="form-check-input" type="radio" name="dairy" id="milk" value="Milk" <?php if ($order['dairy'] == 'Milk') echo 'checked'; ?>>
                    <label class="form-check-label" for="milk"> Milk </label>
                    <input class="form-check-input" type="radio" name="dairy" id="oat_milk" value="Oat Milk" <?php if ($order['dairy'] == 'Oat Milk') echo 'checked'; ?>>
                    <label class="form-check-label" for="oat_milk"> Oat Milk </label>
                    <input class="form-check-input" type="radio" name="dairy" id="almond_milk" value="Almond Milk" <?php if ($order['dairy'] == 'Almond Milk') echo 'checked'; ?>>
                    <label class="form-check-label" for="almond_milk"> Almond Milk </label>
                </div>
                <br>
                <div class="Topping">
                    <label><b>TOPPINGS</b> <sup> (optional) </sup></label>
                    <br>
                    <input class="form-check-input" type="checkbox" name="topping[]" value="Caramel Sauce" <?php if (in_array('Caramel Sauce', $order['topping'])) echo 'checked'; ?>>
                    <label class="form-check-label"> Caramel Sauce </label>
                    <br>
                    <input class="form-check-input" type="checkbox" name="topping[]" value="Caramel Crumble" <?php if (in_array('Caramel Crumble', $order['topping'])) echo 'checked'; ?>>
                    <label class="form-check-label"> Caramel Crumble </label>
                    <br>
                    <input class="form-check-input" type="checkbox" name="topping[]" value="Choco Granola" <?php if (in_array('Choco Granola', $order['topping'])) echo 'checked'; ?>>
                    <label class="form-check-label"> Choco Granola </label>
                    <br>
                    <input class="form-check-input" type="checkbox" name="topping[]" value="Sea Salt Cream" <?php if (in_array('Sea Salt Cream', $order['topping'])) echo 'checked'; ?>>
                    <label class="form-check-label"> Sea Salt Cream </label>
                </div>
                <br>
                <div class="Note">
                    <label><b>NOTE</b></label>
                    <br>
                    <textarea class="form-control" name="note"><?php echo htmlspecialchars($order['note']); ?></textarea>
                </div>
                <br>
                <div class="Tombol_submit">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>