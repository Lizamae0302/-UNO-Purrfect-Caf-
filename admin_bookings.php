<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle Add/Edit/Delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Upload image helper function
    function uploadImage($file) {
        $targetDir = "uploads/rooms/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $filename = basename($file['name']);
        $targetFilePath = $targetDir . time() . '_' . preg_replace('/\s+/', '_', $filename);
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allow only image files
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileType, $allowedTypes)) {
            return false;
        }

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $targetFilePath;
        }
        return false;
    }

    // ADD ROOM
    if (isset($_POST['add_room'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $branch = mysqli_real_escape_string($conn, $_POST['branch']);
        $price = floatval($_POST['price']);
        $guest_limit = intval($_POST['guest_limit']);
        $availability = $_POST['availability'] === 'fully_booked' ? 'fully_booked' : 'available';

        $image_path = null;
        if (!empty($_FILES['image']['name'])) {
            $uploaded = uploadImage($_FILES['image']);
            if ($uploaded !== false) {
                $image_path = $uploaded;
            }
        }

        $sql = "INSERT INTO rooms (name, branch, price, guest_limit, availability, image) VALUES ('$name', '$branch', $price, $guest_limit, '$availability', " . ($image_path ? "'$image_path'" : "NULL") . ")";
        if (mysqli_query($conn, $sql)) {
            $msg = "Room added successfully.";
        } else {
            $msg = "Error: " . mysqli_error($conn);
        }
    }

    // UPDATE ROOM
    if (isset($_POST['update_room'])) {
        $id = intval($_POST['room_id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $branch = mysqli_real_escape_string($conn, $_POST['branch']);
        $price = floatval($_POST['price']);
        $guest_limit = intval($_POST['guest_limit']);
        $availability = $_POST['availability'] === 'fully_booked' ? 'fully_booked' : 'available';

        // Check if new image uploaded
        $image_sql_part = "";
        if (!empty($_FILES['image']['name'])) {
            $uploaded = uploadImage($_FILES['image']);
            if ($uploaded !== false) {
                $image_sql_part = ", image='$uploaded'";
            }
        }

        $sql = "UPDATE rooms SET 
            name='$name',
            branch='$branch',
            price=$price,
            guest_limit=$guest_limit,
            availability='$availability'
            $image_sql_part
            WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            $msg = "Room updated successfully.";
        } else {
            $msg = "Error: " . mysqli_error($conn);
        }
    }

    // DELETE ROOM
    if (isset($_POST['delete_room'])) {
        $id = intval($_POST['room_id']);
        // Optionally: delete image file too here if you want

        $sql = "DELETE FROM rooms WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            $msg = "Room deleted successfully.";
        } else {
            $msg = "Error: " . mysqli_error($conn);
        }
    }
}

// Fetch all rooms
$rooms = mysqli_query($conn, "SELECT * FROM rooms ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Manage Rooms</title>
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
      h2{
        font-size:3rem;
        color: #573818;
      }
      h3 {
      font-size:1.7rem;
        color: #573818;
    }
    .table-striped th {
        background-color: #573818;
        color: white;
        font-weight:normal;
    }
      .container {
         margin-left: 260px;
         font-family: "DynaPuff", system-ui;
         padding: 20px;
         width: 100%;
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
    </style>
</head>
<body>
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

<div class="container mt-4">
    <h2 class="mb-4">Manage Rooms</h2>

    <?php if (!empty($msg)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <!-- Add Room Form -->
    <div class="form-section">
        <h3>Add New Room</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Room Name</label>
                    <input type="text" name="name" class="form-control" required />
                </div>
                <div class="form-group col-md-4">
                    <label>Branch</label>
                    <input type="text" name="branch" class="form-control" required />
                </div>
                <div class="form-group col-md-2">
                    <label>Price (₱)</label>
                    <input type="number" step="0.01" name="price" class="form-control" required />
                </div>
                <div class="form-group col-md-2">
                    <label>Guest Limit</label>
                    <input type="number" name="guest_limit" class="form-control" min="1" required />
                </div>
            </div>
            <div class="form-row align-items-center">
                <div class="form-group col-md-4">
                    <label>Availability</label>
                    <select name="availability" class="form-control">
                        <option value="available" selected>Available</option>
                        <option value="fully_booked">Fully Booked</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label>Room Image</label>
                    <input type="file" name="image" accept="image/*" class="form-control-file" />
                </div>
                <div class="form-group col-md-4 mt-4">
                    <button type="submit" name="add_room" class="btn btn-success">Add Room</button>
                </div>
            </div>
        </form>
    </div><br>

    <!-- Rooms Table -->
    <h3>Existing Rooms</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Branch</th>
                <th>Price (₱)</th>
                <th>Guest Limit</th>
                <th>Availability</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($room = mysqli_fetch_assoc($rooms)): ?>
            <tr>
                <td><?= $room['id'] ?></td>
                <td>
                    <?php if ($room['image'] && file_exists($room['image'])): ?>
                        <img src="<?= htmlspecialchars($room['image']) ?>" alt="Room Image" class="room-image" />
                    <?php else: ?>
                        <span>No image</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($room['name']) ?></td>
                <td><?= htmlspecialchars($room['branch']) ?></td>
                <td>₱<?= number_format($room['price'], 2) ?></td>
                <td><?= $room['guest_limit'] ?></td>
                <td><?= ucfirst(str_replace('_', ' ', $room['availability'])) ?></td>
                <td>
                    <!-- Edit button triggers modal -->
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal<?= $room['id'] ?>">Edit</button>

                    <!-- Delete form -->
                    <form method="post" style="display:inline-block" onsubmit="return confirm('Delete this room?');">
                        <input type="hidden" name="room_id" value="<?= $room['id'] ?>" />
                        <button type="submit" name="delete_room" class="btn btn-sm btn-danger">Delete</button>
                    </form>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $room['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $room['id'] ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <form method="post" enctype="multipart/form-data" class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="editModalLabel<?= $room['id'] ?>">Edit Room - <?= htmlspecialchars($room['name']) ?></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="room_id" value="<?= $room['id'] ?>" />
                                <div class="form-group">
                                    <label>Room Name</label>
                                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($room['name']) ?>" required />
                                </div>
                                <div class="form-group">
                                    <label>Branch</label>
                                    <input type="text" name="branch" class="form-control" value="<?= htmlspecialchars($room['branch']) ?>" required />
                                </div>
                                <div class="form-group">
                                    <label>Price (₱)</label>
                                    <input type="number" step="0.01" name="price" class="form-control" value="<?= $room['price'] ?>" required />
                                </div>
                                <div class="form-group">
                                    <label>Guest Limit</label>
                                    <input type="number" name="guest_limit" class="form-control" value="<?= $room['guest_limit'] ?>" min="1" required />
                                </div>
                                <div class="form-group">
                                    <label>Availability</label>
                                    <select name="availability" class="form-control">
                                        <option value="available" <?= $room['availability'] === 'available' ? 'selected' : '' ?>>Available</option>
                                        <option value="fully_booked" <?= $room['availability'] === 'fully_booked' ? 'selected' : '' ?>>Fully Booked</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Room Image (Leave empty to keep existing)</label>
                                    <input type="file" name="image" accept="image/*" class="form-control-file" />
                                    <?php if ($room['image'] && file_exists($room['image'])): ?>
                                        <img src="<?= htmlspecialchars($room['image']) ?>" alt="Room Image" style="width:100px; margin-top:10px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              <button type="submit" name="update_room" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                      </div>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php if (mysqli_num_rows($rooms) == 0): ?>
                <tr><td colspan="8" class="text-center">No rooms found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap 4 and jQuery scripts for modal -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
