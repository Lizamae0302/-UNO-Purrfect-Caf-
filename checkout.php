<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? 0;
if ($user_id == 0) {
    header('Location: login.php');
    exit;
}

// Fetch all cart items for this user
$cart_query = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('Query failed');

if (mysqli_num_rows($cart_query) == 0) {
    header('Location: order.php'); // Cart is empty
    exit;
}

while ($cart = mysqli_fetch_assoc($cart_query)) {
    $product_id = $cart['product_id'];
    $product_name = mysqli_real_escape_string($conn, $cart['name']);
    $price = (float)$cart['price'];
    $quantity = (int)$cart['quantity'];
    $order_time = date('Y-m-d H:i:s');

    // Insert into product_orders
    $insert_order_sql = "INSERT INTO product_orders (user_id, product_name, product_image, price, quantity, order_time) 
                         VALUES ('$user_id', '$product_name', '$product_image', '$price', '$quantity', '$order_time')";
    
    if (!mysqli_query($conn, $insert_order_sql)) {
        die('Insert order failed: ' . mysqli_error($conn) . ' | SQL: ' . $insert_order_sql);
    }

    // Update stock
    $update_stock_sql = "UPDATE products SET stock = stock - $quantity WHERE id = '$product_id'";
    if (!mysqli_query($conn, $update_stock_sql)) {
        die('Stock update failed: ' . mysqli_error($conn));
    }
}


// Clear the cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'") or die('Cart clear failed: ' . mysqli_error($conn));

// Redirect to order success page
header('Location: order_success.php');
exit;
?>
