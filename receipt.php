<?php
@include 'config.php'; // database connection
if (!isset($_GET['reservation_id'])) {
    echo "No receipt available.";
    exit();
}

$id = intval($_GET['reservation_id']);
$result = mysqli_query($conn, "SELECT * FROM reservations WHERE id = $id LIMIT 1");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
        background-color:#F7E6CA;
    }
        .receipt-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
        }
        .checkmark {
            font-size: 4rem;
            color: #28a745;
        }
        h2{
        font-size:2.3rem;
        font-weight:bold;
        color:#573818;
      }
      p{
        font-size:1.3rem;
      }
      .btn-success{
        font-size:1.2rem;
      }
    </style>
</head>
<body>
<div class="receipt-container">
    <div class="checkmark">✔</div>
    <h2 class="mt-3">Reservation Confirmed!</h2>
    <p>Thank you, <strong><?= htmlspecialchars($data['name']) ?></strong>.</p>
    <hr>
    <div class="text-start mt-4">
        <p><strong>Email:</strong> <?= htmlspecialchars($data['email']) ?></p>
        <p><strong>Branch:</strong> <?= htmlspecialchars($data['branch']) ?></p>
        <p><strong>Room:</strong> <?= htmlspecialchars($data['room']) ?></p>
        <p><strong>Date & Time:</strong> <?= $data['date'] ?> @ <?= $data['time'] ?></p>
        <p><strong>Guests:</strong> <?= $data['guests'] ?></p>
        <p><strong>Notes:</strong> <?= nl2br(htmlspecialchars($data['notes'])) ?></p>
    </div>
    <hr>
    <a href="shop.php" class="btn btn-success mt-3">Back to Shop</a>
</div>
</body>
</html>
