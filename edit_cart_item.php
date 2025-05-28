<?php
session_start();
include 'config.php';
$id = $_POST['id'];
$qty = $_POST['quantity'];
mysqli_query($conn, "UPDATE cart SET quantity = $qty WHERE id = $id AND user_id = {$_SESSION['user_id']}");
include 'render_cart.php';
