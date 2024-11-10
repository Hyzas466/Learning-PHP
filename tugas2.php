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
    <title>Kafe UPN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

    
    <br>
<div class="container">
    <h4> masukkan pesanan anda</h4> 
    <form action="tugas2hasil.php" method="POST">
      <!-- menu -->
      <label class="fw-bold">Menu</label>
      <select class="form-select" name="menu" aria-label="Menu">
        <option selected value="">Pilih Menu</option>
        <option value="1">Americano</option>
        <option value="2">Mochaccino</option>
        <option value="3">Hazelnut Latte</option>
        <option value="4">Vanilla Latte</option>
        <option value="5">Salted Caramel</option>
      </select>
      <!-- panas atau dingin -->
      <br>
      <label>
        <span class="fw-bold">Hot/Ice</span>
      <div>
        <input type="radio" name="hotice" value="Hot" />Hot
        <input type="radio" name="hotice" value="Ice" />Ice
      </div>
     
      <br>
      <!-- size -->
      <label>
        <span class="fw-bold">Size</span>
      <div>
        <input type="radio" name="size" value="Reguler" />Reguler
        <input type="radio" name="size" value="Large" />Large
      </div>
      
      <!-- sweetness -->
      <br>
      <label>
        <div>
        <span class="fw-bold">Sweetness Level</span> <br>
        <input type="radio" name="sweetness" value="Normal Sweet" />Normal Sweet
        <input type="radio" name="sweetness" value="Less Sweet" />Less Sweet
      </div>
      </label>
      <!--  Dairy -->
      <br>
      <br>
      <label>
        <span class="fw-bold">dairy</span> <span class="text-muted">* optional</span>
        <div>
            <input type="radio" name="dairy" value="Milk" />Milk
            <input type="radio" name="dairy" value="Oat Milk" />Oat Milk
            <input type="radio" name="dairy" value="Almond Milk" />Almond Milk
        </div>
      </label>
      <!-- topping -->
      <br>
      <br>
      <label class="fw-bold">Topping <span class="text-muted">*optional</span></label> 
            <div>
                <input type="checkbox" name="topping[]" value="Caramel Sauce" />Caramel Sauce<br>
                <input type="checkbox" name="topping[]" value="Caramel Crumble" />Caramel Crumble<br>
                <input type="checkbox" name="topping[]" value="Choco Granola" />Choco Granola<br>
                <input type="checkbox" name="topping[]" value="Sea Salt Cream" />Sea Salt Cream
            </div>
      <br>
      <!--  note -->
      <label class="fw-bold">Additional Note</label>
        <br>
         <div class="form-group">
                <textarea class="form-control" name="note" placeholder="Write your additional note here"></textarea>
                </div>
                <!-- button -->
              <div class="form-group form-inline">
                <button type="submit">Submit</button>
                <button type="reset" class="reset">Reset</button>
            </div>
    </form>
</div>
</body>
</html>