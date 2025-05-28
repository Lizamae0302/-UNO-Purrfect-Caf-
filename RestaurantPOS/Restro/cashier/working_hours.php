<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

$logged_in_staff_id = $_SESSION['staff_id'];

require_once('partials/_head.php');
?>

<body>
  <style>
    body {
      background-color: #b09081;
      font-family: "DynaPuff", system-ui;
    }
  </style>

  <!-- Sidenav -->
  <?php require_once('partials/_sidebar.php'); ?>

  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php require_once('partials/_topnav.php'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
    <!-- Header -->
    <div style="background-image: url(assets/img/theme/bjes.png); background-size: cover;" class="header pb-8 pt-5 pt-md-9">
      <span class="mask bg-gradient-dark opacity-5"></span>
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">My Working Hours</h6>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col">
          <div class="card shadow" style="background-color: #F7E6CA;">
            <div class="card-header border-0" style="background-color: #F7E6CA;">
              <h3 class="mb-0">Attendance Logs</h3>
            </div>
            <div class="table-responsive" style="background-color: #F7E6CA;">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Time In</th>
                    <th scope="col">Time Out</th>
                    <th scope="col">Total Hours</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "
                    SELECT log_date, time_in, time_out,
                      TIMEDIFF(time_out, time_in) AS total_hours
                    FROM rpos_staff_attendance
                    WHERE staff_id = ?
                    ORDER BY log_date DESC, time_in DESC
                  ";
                  $stmt = $mysqli->prepare($query);
                  $stmt->bind_param('i', $logged_in_staff_id);
                  $stmt->execute();
                  $result = $stmt->get_result();

                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . date('Y-m-d', strtotime($row['log_date'])) . "</td>";
                    echo "<td>" . ($row['time_in'] ? date('h:i A', strtotime($row['time_in'])) : '-') . "</td>";
                    echo "<td>" . ($row['time_out'] ? date('h:i A', strtotime($row['time_out'])) : '-') . "</td>";
                    echo "<td>" . ($row['total_hours'] ? $row['total_hours'] : '-') . "</td>";
                    echo "</tr>";
                  }

                  $stmt->close();
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <?php require_once('partials/_footer.php'); ?>
    </div>
  </div>

  <!-- Scripts -->
  <?php require_once('partials/_scripts.php'); ?>
</body>
</html>
