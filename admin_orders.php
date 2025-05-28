<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit;
}

// Fetch distinct user IDs from orders
$user_query = mysqli_query($conn, "SELECT DISTINCT user_id FROM orders ORDER BY order_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Order Receipts</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body {
         font-family: Arial, sans-serif;
         background-color: #f5f5f5;
         display: flex;
      }
      .sidebar {
         width: 250px;
         background: #2e1700;
         color: white;
         height: 100vh;
         padding: 20px;
         position: fixed;
      }
      .sidebar a {
         display: block;
         color: white;
         margin-bottom: 15px;
         text-decoration: none;
      }
    .receipt-card {
      background: #fff;
      border: 1px dashed #aaa;
      border-radius: 8px;
      padding: 20px 30px;
      margin-bottom: 30px;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
    }
    .receipt-header {
      text-align: center;
      margin-bottom: 15px;
    }
    .receipt-header h4 {
      margin: 0;
      font-size: 1.6rem;
      font-weight: bold;
    }
    .receipt-header small {
      color: #666;
    }
    .user-info {
      font-size: 0.95rem;
      margin-bottom: 10px;
      color: #333;
      border-bottom: 1px dashed #ccc;
      padding-bottom: 8px;
    }
    .receipt-body {
      margin-bottom: 1rem;
    }
    .receipt-body table {
      width: 100%;
      font-size: 1rem;
    }
    .receipt-body th, .receipt-body td {
      padding: 6px 0;
    }
    .receipt-footer {
      text-align: right;
      font-size: 1.2rem;
      font-weight: bold;
    }
  </style>
</head>
<body>
   <div class="sidebar">
   <h4>Purrfect Café</h4>
   <a href="admin_page.php">Dashboard</a>
   <a href="admin_products.php">Products</a>
   <a href="admin_pass.php">Pass</a>
   <a href="admin_users.php">Users</a>
   <a href="admin_logs.php">Log Book</a>
   <a href="admin_contacts.php">Messages</a>
   <a href="admin_reviews.php">Reviews</a>
   <a href="logout.php">Logout</a>
</div>

<h2 class="text-center mb-4">User Order Receipts</h2>

<?php
while ($user = mysqli_fetch_assoc($user_query)) {
    $uid = $user['user_id'];

    // Fetch user info
    $user_info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name, email FROM users WHERE id = '$uid'"));
    $user_name = $user_info['name'] ?? 'Unknown';
    $user_email = $user_info['email'] ?? 'Not Found';

    // Get order dates
    $order_dates_query = mysqli_query($conn, "SELECT DISTINCT DATE(order_date) as odate FROM orders WHERE user_id='$uid' ORDER BY odate DESC");

    while ($date_row = mysqli_fetch_assoc($order_dates_query)) {
        $odate = $date_row['odate'];
        $orders_query = mysqli_query($conn, "
            SELECT o.*, p.name AS product_name, p.price 
            FROM orders o
            JOIN products p ON o.product_id = p.id
            WHERE o.user_id = '$uid' AND DATE(o.order_date) = '$odate'
        ");

        if (mysqli_num_rows($orders_query) > 0) {
            $grand_total = 0;

            echo '<div class="receipt-card">';
            echo '<div class="receipt-header">';
            echo '<h4>Café Receipt</h4>';
            echo "<small>Date: " . date("F j, Y", strtotime($odate)) . "</small>";
            echo '</div>';

            echo "<div class='user-info'>
                    <strong>Name:</strong> " . htmlspecialchars($user_name) . "<br>
                    <strong>Email:</strong> " . htmlspecialchars($user_email) . "
                  </div>";

            echo '<div class="receipt-body">';
            echo '<table>';
            echo '<thead><tr><th>Item</th><th class="text-right">Qty</th><th class="text-right">Subtotal</th></tr></thead><tbody>';

            while ($order = mysqli_fetch_assoc($orders_query)) {
                $subtotal = $order['quantity'] * $order['price'];
                $grand_total += $subtotal;

                echo "<tr>
                        <td>" . htmlspecialchars($order['product_name']) . "</td>
                        <td class='text-right'>{$order['quantity']}</td>
                        <td class='text-right'>₱" . number_format($subtotal, 2) . "</td>
                      </tr>";
            }

            echo '</tbody></table>';
            echo '</div>';

            echo '<div class="receipt-footer">';
            echo "Total: ₱" . number_format($grand_total, 2);
            echo '</div>';
            echo '</div>';
        }
    }
}
?>

</body>
</html>
