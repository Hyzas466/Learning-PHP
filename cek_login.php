<?php 
session_start();
include 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['login'] = true;
    header("Location: dashboard.php");
} else {
    header("Location: login.php?pesan=gagal");
}
?>
