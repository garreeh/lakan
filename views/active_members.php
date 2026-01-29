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

  <title>Lakan | Members (Active)</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php include './../includes/links.php'; ?>

  <!-- Toast -->
  <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
    integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />



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
          <h1>Members (Active)</h1>
          <br>

          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/lakan/views/dashboard_module.php">Home</a>
              </li>
              <li class="breadcrumb-item active">Members (Active)</li>
            </ol>
          </nav>


        </div>

        <!-- End Page Title -->
        <section class="section dashboard">
          <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">

              <?php include './../modals/members/modal_add_members.php'; ?>
              <a href="#" class="btn btn-sm btn-success shadow-lg mb-4" data-bs-toggle="modal" data-bs-target="#addMembersModal">
                <i class="bi bi-person-add"></i> Add Members
              </a>

              <!-- <a href="./../excels/supplier_export.php" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mb-4"><i class="bi bi-file-excel"></i> Generate Excel</a> -->

              <div class="row">
                <div class="col-xl-12 col-lg-12">
                  <div class="tab-pane fade show active" id="aa" role="tabpanel" aria-labelledby="aa-tab">

                    <div class="table-responsive">
                      <div id="modalContainerCustomers"></div>

                      <table class="table custom-table table-hover" name="customers_table" id="customers_table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Subs Start Date</th>
                            <th>Subs End Date</th>
                            <th>Status</th>

                            <th>Manage</th>
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

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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

  <!-- COPY THESE WHOLE CODE WHEN IMPORT SELECT -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
    integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
    integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />




</body>

</html>

<script>
  $(document).ready(function() {
    $('select').selectize({
      sortField: 'text'
    });
  });

  $('.toggle-sidebar-btn').click(function() {
    $('#customers_table').css('width', '100%');
    // console.log(table) //This is for testing only
  });

  //Table for Supplier
  $(document).ready(function() {
    var customers_table = $('#customers_table').DataTable({
      "pagingType": "numbers",
      "processing": true,
      "serverSide": true,
      "ajax": "./../controllers/tables/customers_table.php",
      "order": [
        [0, "desc"]
      ] // <-- DESCENDING order by first column
    });

    window.reloadDataTable = function() {
      customers_table.ajax.reload();
    };

  });

  //Bridge for Modal Backend to Frontend
  $(document).ready(function() {
    // Function to handle click event on datatable rows
    $('#customers_table').on('click', 'tr td:nth-child(8) .fetchDataUser', function() {
      var user_id = $(this).closest('tr').find('td').first().text(); // Get the user_id from the clicked row
      console.log('Button clicked, User ID: ' + user_id);

      $.ajax({
        url: './../modals/users/modal_edit_user.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          user_id: user_id
        },
        success: function(response) {
          $('#modalContainerCustomers').html(response);
          $('#fetchDataUserModal').modal('show');
          console.log("Modal content loaded for User ID: " + user_id);
        },
        error: function(xhr, status, error) {
          console.error("Error: " + xhr.responseText);
        }
      });
    });
  });

  $(document).ready(function() {
    // Function to handle click event on datatable rows
    $('#customers_table').on('click', 'tr td:nth-child(8) .fetchDataUserDelete', function() {
      var user_id = $(this).closest('tr').find('td').first().text(); // Get the user_id from the clicked row
      console.log('Button clicked, User ID: ' + user_id);

      $.ajax({
        url: './../modals/users/modal_delete_user.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          user_id: user_id
        },
        success: function(response) {
          $('#modalContainerCustomers').html(response);
          $('#deleteDataUserModal').modal('show');
          console.log("Modal content loaded for User ID: " + user_id);
        },
        error: function(xhr, status, error) {
          console.error("Error: " + xhr.responseText);
        }
      });
    });
  });

  //Bridge for Modal Backend to Frontend
  $(document).ready(function() {
    // Function to handle click event on datatable rows
    $('#customers_table').on('click', 'tr td:nth-child(4) .fetchDataPassword', function() {
      var user_id = $(this).closest('tr').find('td').first().text(); // Get the user_id from the clicked row
      console.log('Button clicked, User ID: ' + user_id);

      $.ajax({
        url: './../modals/customer/modal_view_password_client.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          user_id: user_id
        },
        success: function(response) {
          $('#modalContainerCustomers').html(response);
          $('#fetchDataUserModal').modal('show');
          console.log("Modal content loaded for User ID: " + user_id);
        },
        error: function(xhr, status, error) {
          console.error("Error: " + xhr.responseText);
        }
      });
    });
  });
</script>