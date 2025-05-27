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
    }

    /* Fix table layout */
    #attendanceTable {
      table-layout: fixed;
      width: 100%;
    }

    #attendanceTable thead th {
      /* Prevent text wrapping and keep consistent widths */
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    #attendanceTable tbody {
      /* Min height to avoid layout jumps */
      min-height: 200px;
      display: block;
      max-height: 400px;
      overflow-y: auto;
      width: 100%;
    }

    /* tbody rows displayed as block for scrolling */
    #attendanceTable tbody tr {
      display: table;
      width: 100%;
      table-layout: fixed;
    }

    /* Fix thead as block for header */
    #attendanceTable thead {
      display: table;
      width: 100%;
      table-layout: fixed;
    }

    /* Style no record row */
    .no-records {
      text-align: center;
      font-style: italic;
      color: #666;
    }
  </style>

  <!-- Sidenav -->
  <?php require_once('partials/_sidebar.php'); ?>

  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php require_once('partials/_topnav.php'); ?>

    <!-- Header -->
    <div style="background-image: url(assets/img/theme/bjes.png); background-size: cover;" class="header pb-8 pt-5 pt-md-9">
      <span class="mask bg-gradient-dark opacity-5"></span>
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Staff Working Hours Report</h6>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background-color: #F7E6CA;">
              <h3 class="mb-0">All Staff Attendance Logs</h3>
              <select id="timeFilter" class="form-control w-auto">
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="this_week">This Week</option>
                <option value="this_month" selected>This Month</option>
                <option value="all_time">All Time</option>
              </select>
            </div>
            <div class="table-responsive" style="background-color: #F7E6CA;">
              <table class="table align-items-center table-flush" id="attendanceTable">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" style="width: 20%;">Staff Name</th>
                    <th scope="col" style="width: 20%;">Date</th>
                    <th scope="col" style="width: 20%;">Time In</th>
                    <th scope="col" style="width: 20%;">Time Out</th>
                    <th scope="col" style="width: 20%;">Total Hours</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Data will be loaded here via AJAX -->
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

  <script>
    async function loadAttendanceData(filter = 'this_month') {
      try {
        const response = await fetch(`fetch_attendance_data.php?filter=${filter}`);
        const data = await response.json();

        const tbody = document.querySelector('#attendanceTable tbody');
        tbody.innerHTML = '';

        if (data.length === 0) {
          tbody.innerHTML = `<tr class="no-records"><td colspan="5">No records found.</td></tr>`;
          return;
        }

        data.forEach(record => {
          const tr = document.createElement('tr');

          tr.innerHTML = `
            <td>${record.staff_name}</td>
            <td>${record.log_date}</td>
            <td>${record.time_in ? record.time_in : '-'}</td>
            <td>${record.time_out ? record.time_out : '-'}</td>
            <td>${record.total_hours ? record.total_hours : '-'}</td>
          `;

          tbody.appendChild(tr);
        });
      } catch (error) {
        console.error('Error loading attendance data:', error);
      }
    }

    document.getElementById('timeFilter').addEventListener('change', function () {
      loadAttendanceData(this.value);
    });

    // Initial load
    window.addEventListener('DOMContentLoaded', () => {
      loadAttendanceData(document.getElementById('timeFilter').value);
    });
  </script>
</body>

</html>
