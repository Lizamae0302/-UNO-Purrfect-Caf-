<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
?>

<body>
<style>
    body {
        background-color: #b09081;
        font-family: "DynaPuff", system-ui;
    }
    h4{
        background-color:rgb(109, 89, 80);
    }
</style>
<?php require_once('partials/_sidebar.php'); ?>
<div class="main-content">
    <?php require_once('partials/_topnav.php'); ?>
    <div style="background-image: url(assets/img/theme/bjes.png); background-size: cover;" class="header pb-8 pt-5 pt-md-9">
        <span class="mask bg-gradient-dark opacity-5"></span>
        <div class="container-fluid">
            <div class="header-body"></div>
        </div>
    </div>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">

    <div class="container-fluid mt--8">
        <div class="row">
            <div class="col">
                <div class="card shadow" style="background-color: #F7E6CA;">
                    <div class="card-header border-0" style="background-color: #F7E6CA;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>Orders Report</h3>
                            <form method="GET" class="form-inline">
                                <input type="date" name="date" class="form-control" 
                                       value="<?php echo isset($_GET['date']) ? htmlspecialchars($_GET['date']) : ''; ?>">
                                <button type="submit" class="btn btn-primary ml-2">Search by Date</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive" style="background-color: #F7E6CA;">
                        <?php
                        $date = isset($_GET['date']) ? trim($_GET['date']) : '';
                        $staff_id = $_SESSION['staff_id'];

                        $query = "SELECT o.order_id, p.prod_name, oi.quantity, p.prod_price, 
                                        (oi.quantity * p.prod_price) AS total_price, o.created_at,
                                        s.staff_name, s.staff_number
                                  FROM rpos_orders o 
                                  JOIN rposorder_items oi ON o.order_id = oi.order_id 
                                  JOIN rpos_products p ON oi.product_id = p.prod_id
                                  LEFT JOIN rpos_staff s ON o.staff_id = s.staff_id";

                        if (!empty($date)) {
                            $query .= " WHERE o.staff_id = ? AND DATE(o.created_at) = ?";
                            $stmt = $mysqli->prepare($query . " ORDER BY o.created_at DESC");
                            $stmt->bind_param("ss", $staff_id, $date);
                        } else {
                            $query .= " WHERE o.staff_id = ?";
                            $stmt = $mysqli->prepare($query . " ORDER BY o.created_at DESC");
                            $stmt->bind_param("s", $staff_id);
                        }

                        $stmt->execute();
                        $res = $stmt->get_result();

                        $current_order_id = null;
                        while ($row = $res->fetch_assoc()) {
                            if ($current_order_id !== $row['order_id']) {
                                if ($current_order_id !== null) {
                                    echo '</tbody></table><br>';
                                }
                                $current_order_id = $row['order_id'];
                                echo "<h4 class='p-2 rounded text-light d-flex justify-content-between align-items-center'>
                                        <span>Order ID: <span class='font-weight-bold'>{$row['order_id']}</span></span>
                                        <a href='receipts.php?order_id=" . urlencode($row['order_id']) . "' 
                                           class='btn btn-sm mb-0' style='background-color:#ff69b4; color:white;'>Print Receipt</a>
                                      </h4>";
                                echo "<p class='ml-2 mb-2'><strong>Cashier:</strong> " . 
                                     htmlspecialchars($row['staff_name'] ?? 'Unknown') . 
                                     " (" . htmlspecialchars($row['staff_number'] ?? '-') . ")</p>";

                                echo '<table class="table align-items-center table-flush" style="background-color: #F7E6CA;">';
                                echo '<thead class="thead-light">';
                                echo '<tr><th>Product</th><th>Quantity</th><th>Unit Price</th><th>SubTotal Price</th><th>Date</th></tr>';
                                echo '</thead><tbody>';
                            }

                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['prod_name']) . '</td>';
                            echo '<td>' . intval($row['quantity']) . '</td>';
                            echo '<td>P' . number_format($row['prod_price'], 2) . '</td>';
                            echo '<td>P' . number_format($row['total_price'], 2) . '</td>';
                            echo '<td>' . date('d/M/Y g:i', strtotime($row['created_at'])) . '</td>';
                            echo '</tr>';
                        }

                        if ($current_order_id !== null) {
                            echo '</tbody></table>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once('partials/_footer.php'); ?>
    </div>
</div>
<?php require_once('partials/_scripts.php'); ?>
</body>
</html>
