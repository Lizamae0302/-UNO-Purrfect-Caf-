<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['admin_update_products'])) {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    // If a new image is uploaded, use it; otherwise, keep the old image
    if (!empty($image)) {
        move_uploaded_file($image_tmp, $image_folder);
        $final_image = $image;
    } else {
        $final_image = $old_image;
    }

    $query = "UPDATE products SET name=?, category=?, price=?, stock=?, image=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssdisi', $name, $category, $price, $stock, $final_image, $id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: admin_products.php?update=success');
        exit();
    } else {
        echo "Update failed: " . mysqli_error($conn);
    }
} else {
    echo "Invalid access.";
}
?>
