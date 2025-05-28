<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (!isset($_GET['order_id'])) {
    echo "<script>alert('Invalid order ID'); window.location.href='payments.php';</script>";
    exit();
}

$orderID = $_GET['order_id'];

$stmt = $mysqli->prepare("
    SELECT o.*, s.staff_name 
    FROM rpos_orders o 
    LEFT JOIN rpos_staff s ON o.staff_id = s.staff_id 
    WHERE o.order_id = ?
");
$stmt->bind_param("s", $orderID);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$cashierName = $order['staff_name'] ?? 'Unknown';

$stmt = $mysqli->prepare("SELECT oi.*, p.prod_name, p.barcode FROM rposorder_items oi JOIN rpos_products p ON oi.product_id = p.prod_id WHERE oi.order_id = ?");
$stmt->bind_param("s", $orderID);
$stmt->execute();
$orderItems = $stmt->get_result();

$totalItems = 0;
$totalQuantity = 0;
$orderItemData = [];
while ($item = $orderItems->fetch_assoc()) {
    $orderItemData[] = $item;
    $totalItems++;
    $totalQuantity += intval($item['quantity']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
    <style>
    body {
        width: 3.15in;
        font-family: 'Courier New', Courier, monospace;
        margin: auto;
        background: #f8f8e8;
    }
    .receipt {
        padding: 8px 10px;
        box-sizing: border-box;
        display: inline-block;
    }
    .center {
        text-align: center;
    }
    .bold {
        font-weight: bold;
    }
    hr {
        border: 1px dashed #000;
        margin: 8px 0;
    }
    table {
        width: 100%;
        font-size: 14px;
        border-collapse: collapse;
    }
    svg#barcode {
        display: block;
        margin: 4px auto 0;
        width: 100%;
        height: 35px;
    }
    .print-btn {
        display: block;
        margin: 10px auto 0;
        padding: 6px 12px;
        font-size: 14px;
        cursor: pointer;
    }
    @media print {
        .print-btn {
            display: none;
        }
    }
    .footer-info {
        text-align: center;
        font-size: 13px;
        margin-top: 5px;
    }
    .small-text {
        font-size: 11px;
    }
    .row-space-between {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        margin-top: 5px;
    }
    </style>
</head>
<body>

    <div class="receipt">
        <div class="center">
            <img src="assets/img/brand/logooo.png" alt="Purrfect Cafe Logo" style="max-width: 70px; margin-bottom: 5px;">
            <p class="bold">PURRFECT CAFE</p>
            <p class="small-text">SABANG, DANAO CITY<br>(63)9926057337<br>www.purrfectcafecafe.com</p>
        </div>
        <hr>
        <p>Receipt No.: <span class="bold"><?php echo htmlspecialchars($orderID); ?></span><br>
           Date: <?php echo date("Y-m-d H:i:s"); ?></p>
        <table>
            <thead>
                <tr class="bold">
                    <td>Item</td>
                    <td>Qty</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderItemData as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['prod_name']); ?></td>
                    <td><?php echo intval($item['quantity']); ?></td>
                    <td>$<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="row-space-between">
            <span>Item(s): <?php echo $totalItems; ?></span>
            <span>Qty(s): <?php echo $totalQuantity; ?></span>
        </div>

        <hr>
        <p>Subtotal: $<?php echo number_format($order['total_price'], 2); ?><br>
           <span class="bold">Grand Total: $<?php echo number_format($order['total_price'], 2); ?></span></p>
        <hr>
        <p class="bold">Payment Detail:</p>
        <p>
            Mode: Cash<br>
            Card Number: -<br>
            Amount: $<?php echo number_format($order['cash_received'], 2); ?><br>
            Change: $<?php echo number_format($order['change_amount'], 2); ?><br>
            Cashier: <?php echo htmlspecialchars($cashierName); ?>
        </p>
    </div>

    <!-- Line before barcode -->
    <hr style="margin: 10px 0;">
    <svg id="barcode"></svg>

    <div class="footer-info">
        <p class="bold">INC: Purrfect Cafe Inc.</p>
        <p class="small-text">Address: Sabang, Danao City, Cebu</p>
        <p class="small-text">Date Issued: <?php echo date("Y-m-d"); ?></p>
        <p class="small-text">Effective Date: <?php echo date("Y-m-d"); ?></p>
        <p class="small-text">Valid Until: <?php echo date("Y-m-d", strtotime("+1 year")); ?></p>
        <p class="bold">Thank you for your visit</p>
    </div>

    <!-- Buttons -->
    <button onclick="window.print()" class="print-btn">Print Receipt</button>
    <button onclick="window.location.href='payments.php'" class="print-btn">Done</button>

    <!-- JsBarcode Script -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script>
        JsBarcode("#barcode", "<?php echo preg_replace('/^ord/i', '', $orderID); ?>", {
            format: "CODE128",
            lineColor: "#000",
            width: 1.5,
            height: 35,
            displayValue: false,
            margin: 0
        });
    </script>
</body>
</html>
