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

  <title>Lakan | Coaching Report</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php include './../includes/links.php'; ?>

  <!-- Toast -->
  <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


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
          <h1>Coaching Report</h1>
          <br>

          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/lakan/views/dashboard_module.php">Home</a></li>
              <li class="breadcrumb-item active">Coaching Report</li>
            </ol>
          </nav>

        </div>

        <div class="row">
          <!-- LEFT COLUMN: DATE INPUTS -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="date_from">Date From:</label>
              <input type="date" class="form-control" id="date_from" name="date_from">

              <div class="mb-2"></div>

              <label for="date_to">Date To:</label>
              <input type="date" class="form-control" id="date_to" name="date_to">

              <div class="mb-3"></div>

              <button class="btn btn-success shadow-sm w-100" id="searchCoachingReport" disabled>
                Search
              </button>
            </div>
          </div>

          <!-- RIGHT COLUMN: SELECTED VALUES DISPLAY -->
          <div class="col-md-6">
            <div class="border rounded p-3 bg-light h-100">
              <h6 class="fw-bold mb-3">Selected Dates</h6>

              <p class="mb-1">
                <strong>Date From:</strong>
                <span id="selectedDateFrom">-</span>
              </p>

              <p class="mb-0">
                <strong>Date To:</strong>
                <span id="selectedDateTo">-</span>
              </p>

              <hr>

              <div id="salesReportResults"></div>

            </div>
          </div>
        </div>

        <br>

        <!-- End Page Title -->
        <section class="section dashboard">
          <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
              <div class="row">
                <div class="col-xl-12 col-lg-12">
                  <div class="tab-pane fade show active" id="aa" role="tabpanel" aria-labelledby="aa-tab">

                    <div class="table-responsive">
                      <div id="modalContainerCoachingSales"></div>

                      <table class="table custom-table table-hover" name="coaching_report_table"
                        id="coaching_report_table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Client Name</th>
                            <th>Coaching Type</th>
                            <th>Coaching Price</th>
                            <th>Date</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Left side columns -->

          </div>
        </section>

      </div>
    </div>
  </div>

  <!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Template Main JS File -->
  <script src="./../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="./../assets/vendor/quill/quill.min.js"></script>
  <script src="./../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="./../assets/vendor/php-email-form/validate.js"></script>
  <script src="./../assets/js/main.js"></script>

  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Data tables -->
  <link rel="stylesheet" type="text/css" href="./../assets/datatables/datatables.min.css" />
  <script type="text/javascript" src="./../assets/datatables/datatables.min.js"></script>


</body>

</html>

<script>
  // CSS responsive width for table
  $('.toggle-sidebar-btn').click(function () {
    $('#coaching_report_table').css('width', '100%');
    // console.log(table) //This is for testing only
  });

  // Table for Membership Type
  $(document).ready(function () {

    /* MEMBERSHIP TYPE TABLE */
    var coaching_report_table = $('#coaching_report_table').DataTable({
      pagingType: "numbers",
      processing: true,
      serverSide: true,
      "ajax": {
        "url": "./../controllers/tables/coaching_report_table.php",
        "data": function (d) {
          d.date_from = $('#date_from').val();
          d.date_to = $('#date_to').val();
        }
      },
      order: [
        [3, "desc"] // default sort by start_date (4th column), descending
      ]
    });

    window.reloadDataTable = function () {
      coaching_report_table.ajax.reload();
    };

    /* ENABLE / DISABLE SEARCH BUTTON */
    function toggleSearchButton() {
      const dateFrom = $('#date_from').val();
      const dateTo = $('#date_to').val();

      $('#searchCoachingReport').prop('disabled', !(dateFrom && dateTo));
    }

    $('#date_from, #date_to').on('change', function () {
      toggleSearchButton();

      // Update selected date preview
      $('#selectedDateFrom').text($('#date_from').val() || '-');
      $('#selectedDateTo').text($('#date_to').val() || '-');
    });

    /* SEARCH BUTTON CLICK */
    $('#searchCoachingReport').on('click', function () {
      const btn = $(this);
      const date_from = $('#date_from').val();
      const date_to = $('#date_to').val();

      btn.text('Searching...').prop('disabled', true);

      // Reload datatable first
      coaching_report_table.ajax.reload(function () {

        $.ajax({
          type: 'POST',
          url: './../controllers/coaching_report_process.php',
          data: {
            searchCoachingReport: true,
            date_from: date_from,
            date_to: date_to
          },
          success: function (response) {
            try {
              const data = JSON.parse(response);
              console.log('Sales report:', data);

              const container = $('#salesReportResults');
              container.empty();

              if (data.success && data.data.length > 0) {
                // Use total_sales from PHP response
                const totalSales = data.total_sales;

                // Display total formatted
                container.html(`<p><strong>Total Sales:</strong> <span style="font-size: 28px; font-weight: bold; color: #28a745;">${totalSales}</span></p>`);
              } else {
                container.html('<p>No sales for selected dates.</p>');
              }

            } catch (e) {
              console.error('Invalid JSON response:', response);
            }

            btn.text('Search').prop('disabled', false);
          },

          error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
            btn.text('Search').prop('disabled', false);
          }
        });

      });
    });

  });
</script>