<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    // Handle image upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    if (!empty($image) && move_uploaded_file($image_tmp, $image_folder)) {
    $query = "INSERT INTO products (name, category, price, stock, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssdis', $name, $category, $price, $stock, $image);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: admin_products.php?success=1');
        exit();
    } else {
        echo "Database insert error: " . mysqli_error($conn);
    }
} else {
        echo "Image upload failed. Please try again.";
    }
} else {
    echo "Invalid access.";
}
?>
