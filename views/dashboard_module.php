<?php
include './../connections/connections.php';
// include './connections/connections.php';


if (session_status() == PHP_SESSION_NONE) {
  session_start();
}



// if (!isset($_SESSION['user_type_id']) || $_SESSION['user_type_id'] != 1) {
//   header("Location: /lakan/views/users/user_dashboard.php");
//   exit();
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php include './../includes/links.php'; ?>

</head>

<body>
  <div id="wrapper">
    <!-- ======= Header ======= -->
    <?php include './../includes/header.php'; ?>
    <!-- End Header -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- ======= Sidebar ======= -->
      <?php include './../includes/navigation.php'; ?>
      <!-- End Sidebar-->

      <div id="content">

        <div class="pagetitle">
          <h1>Dashboard</h1>
        </div>

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <div id="clockAndDate" class="h1 mb-0 font-weight-bold text-gray-800"></div>
        </div>
        <!-- End Page Title -->

        <section class="section dashboard">
          <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
              <div class="row">
                <?php include './../controllers/customer_counts.php'; ?>
                <!-- Active -->
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card info-card sales-card">

                    <div class="card-body">
                      <h5 class="card-title">Active Members</h5>

                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-person-check"></i>
                        </div>
                        <div class="ps-3">
                          <h6><?php echo $activeCount; ?></h6>
                          <span class="text-success small fw-bold">Currently Active</span>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

                <!-- Expired -->
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card info-card sales-card">

                    <div class="card-body">
                      <h5 class="card-title">Expired Subscriptions</h5>

                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-person-x"></i>
                        </div>
                        <div class="ps-3">
                          <h6><?php echo $expiredCount; ?></h6>
                          <span class="text-danger small fw-bold">Needs Renewal</span>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

                <!-- End Revenue Card -->

                <!-- Customers Card -->
                <!-- <div class="col-xl-3 col-md-6 mb-4">

                  <div class="card info-card customers-card">

                    <div class="filter">
                      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                          <h6>Filter</h6>
                        </li>

                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                      </ul>
                    </div>

                    <div class="card-body">
                      <h5 class="card-title">Customers <span>| This Year</span></h5>

                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                          <h6>1244</h6>
                          <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                        </div>
                      </div>

                    </div>
                  </div>

                </div> -->
                <!-- End Customers Card -->

                <!-- Customers Card -->
                <!-- <div class="col-xl-3 col-md-6 mb-4">

                  <div class="card info-card customers-card">

                    <div class="filter">
                      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                          <h6>Filter</h6>
                        </li>

                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                      </ul>
                    </div>

                    <div class="card-body">
                      <h5 class="card-title">Customers <span>| This Year</span></h5>

                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                          <h6>1244</h6>
                          <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                        </div>
                      </div>

                    </div>
                  </div>

                </div> -->
                <!-- End Customers Card -->

              </div>
            </div><!-- End Left side columns -->

          </div>
        </section>

      </div>
    </div>
  </div>

  <!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Template Main JS File -->
  <script src="./../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="./../assets/vendor/quill/quill.min.js"></script>
  <script src="./../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="./../assets/vendor/php-email-form/validate.js"></script>
  <script src="./../assets/js/main.js"></script>

  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</body>

</html>

<!-- Running Clock Script -->
<script>
  function updateClockAndDate() {
    var now = new Date();
    var hours = now.getHours();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12; // Convert 24-hour time to 12-hour time
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var month = monthNames[now.getMonth()];
    var day = now.getDate();
    var year = now.getFullYear();

    // Format the time (add leading zero if needed)
    var formattedTime = hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds + " " + ampm;

    // Format the date
    var formattedDate = month + " " + day + ", " + year;

    // Update the clock and date elements
    document.getElementById("clockAndDate").innerText = formattedTime + " | " + formattedDate;

    // Update the clock and date every second
    setTimeout(updateClockAndDate, 1000);
  }

  // Initial call to start the clock and date
  updateClockAndDate();
</script>