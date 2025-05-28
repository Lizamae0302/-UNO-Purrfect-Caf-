<?php
@include 'config.php';

$branch_id = intval($_GET['branch_id']);
$query = mysqli_query($conn, "SELECT service_name, price FROM branch_prices WHERE branch_id = $branch_id");

$results = [];
while ($row = mysqli_fetch_assoc($query)) {
  $results[] = $row;
}
echo json_encode($results);
?>
