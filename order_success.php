<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Success</title>

    <!-- fonts links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
    <!-- fonts links -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
         font-family: "DynaPuff", system-ui;
         background-color: #F7E6CA;
         text-align: center;
      padding-top: 5rem;
      }
    h1 {
      color: #d68c00;
      font-size: 3rem;
    }
    p {
      font-size: 1.5rem;
    }
  </style>
</head>
<body>
  <h1>Thank You!</h1><br>
  <p>Your order has been placed successfully.</p>
  <a href="order.php" class="btn btn-primary mt-3">Back to Shop</a>
</body>
</html>
    