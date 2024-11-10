<?php
session_start();
include 'config.php';
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
    <title>Order List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    
    .table{
      width: 600px;
      background: grey;
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

    <div class="container mt-5">
        <h4>All Orders</h4>
        <a href="tugas2.php" class="btn btn-primary mb-3">Add Order</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Hot/Ice</th>
                    <th>Size</th>
                    <th>Sweetness Level</th>
                    <th>Dairy</th>
                    <th>Topping</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM orders";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $no = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $row['menu'] . "</td>";
                        echo "<td>" . $row['hot_ice'] . "</td>";
                        echo "<td>" . $row['size'] . "</td>";
                        echo "<td>" . $row['sweetness_level'] . "</td>";
                        echo "<td>" . $row['dairy'] . "</td>";
                        echo "<td>" . $row['topping'] . "</td>";
                        echo "<td>" . $row['note'] . "</td>";
                        echo "<td>
                                <a href='view_order.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'>View</a>
                                <a href='edit.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
