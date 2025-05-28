<?php
include('config/config.php');

if (isset($_GET['barcode'])) {
    $barcode = $_GET['barcode'];

    $stmt = $mysqli->prepare("SELECT prod_id, prod_name, prod_price FROM rpos_products WHERE barcode = ?");
    $stmt->bind_param("s", $barcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($product = $result->fetch_assoc()) {
        echo json_encode($product);
    } else {
        echo json_encode(null); // Barcode not found
    }
}
?>
