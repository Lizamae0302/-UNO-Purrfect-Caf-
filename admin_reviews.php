<?php
@include 'config.php'; // adjust path as needed

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM reviews WHERE id = $id") or die('Query Failed');
    header('Location: admin_reviews.php');
    exit();
}

$reviews = mysqli_query($conn, "SELECT * FROM reviews ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <!-- fonts links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
    <!-- fonts links -->

    <!-- icons links -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- icons links -->
     
    <!-- animation links -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation links -->

   

  <style>
    .reviews-table {
      width: 97%;
      border-collapse: collapse;
      margin-top: 100px;
      margin-left:20px;
    }
    .reviews-table th, .reviews-table td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }
    .reviews-table th {
      background-color:#B08968;
      color:white;
      font-size:2rem;
      font-weight:normal;
    }
    .reviews-table td {
      color:#573818;
      font-size:1.5rem;
      font-weight:normal;
    }
    .reviews-table .star-display {
      color:#ff8c42;
      font-size:2.3rem;
    }

    .reviews-table .delete-btn {
      color: white;
      background:rgb(235, 135, 193);
      border: none;
      padding: 6px 12px;
      cursor: pointer;
      border-radius: 4px;
    }
    .reviews-table .delete-btn:hover{
      color: black;
    background-color: #B08968;
    }
  </style>
</head>
<body>

<?php @include 'admin_header.php'; ?>

  <h2>Client Reviews Management</h2>

  <table class="reviews-table">
    <tr>
      <th>Name</th>
      <th>Rating</th>
      <th>Message</th>
      <th>Date</th>
      <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($reviews)) { ?>
      <tr>
        <td><?= htmlspecialchars($row['name']); ?></td>
        <td class="star-display">
          <?php
          for ($i = 1; $i <= 5; $i++) {
            echo $i <= $row['rating'] ? '★' : '☆';
          }
          ?>
        </td>
        <td><?= nl2br(htmlspecialchars($row['message'])); ?></td>
        <td><?= date('F j, Y', strtotime($row['created_at'])); ?></td>
        <td>
          <a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Delete this review?');">
            <button class="delete-btn">Delete</button>
          </a>
        </td>
      </tr>
    <?php } ?>
  </table>

</body>
</html>




<script src="js/script.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
      </script>