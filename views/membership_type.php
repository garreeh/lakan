<?php
include './../connections/connections.php';
// include './connections/connections.php';


if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if ($_SESSION['is_password_reset'] == 0) {
  header("Location: /lakan/password_reset.php");
  exit();
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

  <title>Lakan | Membership Settings</title>
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
          <h1>Membership Type Settings</h1>
          <br>

          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/lakan/views/dashboard_module.php">Home</a></li>
              <li class="breadcrumb-item active">Membership Type</li>
            </ol>
          </nav>

        </div>

        <!-- End Page Title -->
        <section class="section dashboard">
          <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">

              <?php include './../modals/membership_type/modal_add_membership_type.php'; ?>
              <a href="#" class="btn btn-sm btn-success shadow-lg mb-4" data-bs-toggle="modal" data-bs-target="#addMembershipModal">
                <i class="bi bi-blockquote-right"></i> Add Membership Type
              </a>

              <!-- <a href="./../excels/supplier_export.php" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mb-4"><i class="bi bi-file-excel"></i> Generate Excel</a> -->

              <div class="row">
                <div class="col-xl-12 col-lg-12">
                  <div class="tab-pane fade show active" id="aa" role="tabpanel" aria-labelledby="aa-tab">

                    <div class="table-responsive">
                      <div id="modalContainerMembershipType"></div>

                      <table class="table custom-table table-hover" name="membership_type_table" id="membership_type_table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Membership Type Name</th>
                            <th>Price</th>
                            <th>Description</th>
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


</body>

</html>

<script>
  // CSS responsive width for table
  $('.toggle-sidebar-btn').click(function() {
    $('#membership_type_table').css('width', '100%');
    // console.log(table) //This is for testing only
  });

  // Table for Membership Type
  $(document).ready(function() {
    var membership_type_table = $('#membership_type_table').DataTable({
      "pagingType": "numbers",
      "processing": true,
      "serverSide": true,
      "ajax": "./../controllers/tables/membership_type_table.php",
      "order": [
        [0, "desc"]
      ] // <-- DESCENDING order by first column
    });

    window.reloadDataTable = function() {
      membership_type_table.ajax.reload();
    };

  });

  // Edit Membership Type
  $(document).ready(function() {
    // Function to handle click event on datatable rows
    $('#membership_type_table').on('click', 'tr td:nth-child(5) .fetchDataMembershipType', function() {
      // The event.preventDefault ignores to go top of the page.
      event.preventDefault();

      var membership_type_id = $(this).closest('tr').find('td').first().text(); // Get the membership_type_id from the clicked row
      console.log('Button clicked, User ID: ' + membership_type_id);

      $.ajax({
        url: './../modals/membership_type/modal_edit_membership_type.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          membership_type_id: membership_type_id
        },
        success: function(response) {
          $('#modalContainerMembershipType').html(response);
          $('#editMembershipTypeModal').modal('show');
          console.log("Modal content loaded for Membership Type ID: " + membership_type_id);
        },
        error: function(xhr, status, error) {
          console.error("Error: " + xhr.responseText);
        }
      });
    });
  });

  // Delete Membership Type
  $(document).ready(function() {
    // Function to handle click event on datatable rows
    $('#membership_type_table').on('click', 'tr td:nth-child(8) .fetchDataUserDelete', function() {
      var membership_type_id = $(this).closest('tr').find('td').first().text(); // Get the membership_type_id from the clicked row
      console.log('Button clicked, User ID: ' + membership_type_id);

      $.ajax({
        url: './../modals/users/modal_delete_user.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          membership_type_id: membership_type_id
        },
        success: function(response) {
          $('#modalContainerMembershipType').html(response);
          $('#deleteDataUserModal').modal('show');
          console.log("Modal content loaded for User ID: " + membership_type_id);
        },
        error: function(xhr, status, error) {
          console.error("Error: " + xhr.responseText);
        }
      });
    });
  });
</script>