<?php
include 'config.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'");
    header('location:admin_products.php');
}

$products = mysqli_query($conn, "SELECT * FROM `products`");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Products</title>
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
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
         font-family: "DynaPuff", system-ui;
         background-color: #F7E6CA;
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
        .container {
         margin-left: 260px;
         font-family: "DynaPuff", system-ui;
         padding: 20px;
         width: 80%;
      }
        .room-image { width: 100px; height: 60px; object-fit: cover; }
        .form-section { background: #fff; padding: 20px; margin-bottom: 30px; border-radius: 8px; box-shadow: 0 0 10px #ccc;}

        h4{
   background-image: linear-gradient(45deg, #ff6b6b, #ffcc5c, #4ecdc4, #556270, #eb41c0);
   background-size: 300% 300%;
   -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   animation: movingColors 3s infinite linear;
   padding-top: 30px;
   font-size: 1.3rem;
   margin: 0;
}
      @keyframes movingColors {
   0% { background-position: 0% 50%; }
   50% { background-position: 100% 50%; }
   100% { background-position: 0% 50%; }
}
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }
        h2{
         margin-top:20px;
        font-size:3rem;
        color: #573818;
      }
      h3 {
      font-size:1.7rem;
        color: #573818;
    }
    .table-hover th {
        background-color: #573818;
        color: white;
        font-weight:normal;
    }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4>Purrfect Café</h4><br>
   <a href="admin_page.php">Dashboard</a>
   <a href="admin_products.php">Products</a>
   <a href="admin_bookings.php">Bookings</a>
   <a href="admin_users.php">Users</a>
   <a href="admin_logbook.php">Log Book</a>
   <a href="admin_messages.php">Messages</a>
   <a href="admin_reviews.php">Reviews</a>
   <a href="logout.php" onclick="return confirm('Logout?')">Logout</a>
</div>

<!-- Main Content -->
<div class="content">
    <div class="container">
        <h2 class="mb-4">Manage Products</h2>

        <!-- Add Product Form -->
        <div class="form-section mb-4">
            <form action="add_product.php" method="post" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label>Product Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label>Category</label>
                        <select name="category" class="form-select" required>
                            <option value="">Select</option>
                            <option value="Cakes">Cakes</option>
                            <option value="Coffee">Coffee</option>
                            <option value="Ice Cream">Ice Cream</option>
                            <option value="Cupcakes">Cupcakes</option>
                            <option value="Donut">Donut</option>
                            <option value="Smoothies">Smoothies</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label>Stock</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" name="add_product" class="btn btn-success">Add Product</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Product Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price (₱)</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php $i = 1; while ($row = mysqli_fetch_assoc($products)): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><img src="uploaded_img/<?= $row['image'] ?>" class="product-img"></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= number_format($row['price'], 2) ?></td>
                            <td><?= $row['stock'] ?></td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id'] ?>">Edit</button>

                                <!-- Delete Button -->
                                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this product?')" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editLabel<?= $row['id'] ?>" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <form action="update_product.php" method="post" enctype="multipart/form-data">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="editLabel<?= $row['id'] ?>">Edit Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                  </div>
                                  <div class="modal-body row g-3">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Category</label>
                                        <select name="category" class="form-select" required>
                                            <option value="Cakes" <?= $row['category'] == 'Cakes' ? 'selected' : '' ?>>Cakes</option>
                                            <option value="Coffee" <?= $row['category'] == 'Coffee' ? 'selected' : '' ?>>Coffee</option>
                                            <option value="Ice Cream" <?= $row['category'] == 'Ice Cream' ? 'selected' : '' ?>>Ice Cream</option>
                                            <option value="Cupcakes" <?= $row['category'] == 'Cupcakes' ? 'selected' : '' ?>>Cupcakes</option>
                                            <option value="Donut" <?= $row['category'] == 'Donut' ? 'selected' : '' ?>>Donut</option>
                                            <option value="Smoothies" <?= $row['category'] == 'Smoothies' ? 'selected' : '' ?>>Smoothies</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Price</label>
                                        <input type="number" name="price" class="form-control" value="<?= $row['price'] ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Stock</label>
                                        <input type="number" name="stock" class="form-control" value="<?= $row['stock'] ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Image</label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                        <input type="hidden" name="old_image" value="<?= $row['image'] ?>">
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" name="admin_update_products" class="btn btn-success">Update</button>
                                  </div>
                                </div>
                            </form>
                          </div>
                        </div>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
