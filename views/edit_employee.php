<?php
include './../connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if ($_SESSION['is_password_reset'] == 0) {
  header("Location: /lakan/password_reset.php");
  exit();
}

if (!isset($_SESSION['emp_id'])) {
  header("Location: /lakan/index.php");
  exit;
}

$employee = null; // Initialize
if (isset($_GET['emp_id'])) {
  $emp_id = (int) $_GET['emp_id']; // cast to integer
  $sql = "SELECT * FROM users
          LEFT JOIN position ON position.position_id = users.position_id
          LEFT JOIN department ON department.department_id = users.department_id
          WHERE emp_id = $emp_id";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $employee = mysqli_fetch_assoc($result);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Employee List</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta charset="UTF-8">

  <?php include './../includes/links.php'; ?>

  <!-- Toast -->
  <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
    integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

</head>

<!-- Custom Style for specific page -->
<style>
  .profile-picture {
    transition: transform 0.2s, box-shadow 0.2s;
    /* better spacing inside */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    background-color: #fff;
  }

  .profile-picture:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
  }

  /* Profile Image */
  .profile-image {
    width: 150px;
    height: 140px;

    object-fit: cover;
    border: 2px solid #01165e;
    /* accent color */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .profile-image:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
  }
</style>

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
          <h1>Employee List</h1>
          <br>

          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/lakan/views/dashboard_module.php">Home</a></li>
              <li class="breadcrumb-item active">Employee List</li>
            </ol>
          </nav>

        </div>


        <?php if (isset($employee)): ?>

          <section class="section profile">
            <div class="row">
              <div class="col-xl-4">

                <div class="card">
                  <div class="card-body profile-picture pt-4">

                    <?php
                    // Determine profile image (file path)
                    if (!empty($employee['profile_pic'])) {
                      $profileSrc = $employee['profile_pic']; // ex: ../uploads/profile_picture/emp_1_12345.jpg
                    } else {
                      $profileSrc = './../assets/img/profile-img.jpg';
                    }
                    ?>

                    <!-- Profile Image -->
                    <div class="text-center mb-4">
                      <img id="profile_pic_<?php echo $employee['emp_id']; ?>"
                        src="<?php echo $profileSrc; ?>"
                        alt="Profile"
                        class="rounded-circle profile-image">
                    </div>


                    <!-- Employee Details in Two Columns (Bootstrap) -->
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-5 label">Full Name</div>
                      <div class="col-lg-8 col-md-7 text-end" id="emp_fullname_<?php echo $employee['emp_id']; ?>">
                        <strong>
                          <?php
                          echo htmlspecialchars(
                            $employee['emp_firstname'] .
                              (!empty($employee['emp_middlename']) ? ' ' . $employee['emp_middlename'] : '') .
                              ' ' . $employee['emp_lastname']
                          );
                          ?>
                        </strong>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-5 label">Position</div>
                      <div class="col-lg-8 col-md-7 text-end" id="position_name_<?php echo $employee['emp_id']; ?>">
                        <strong>
                          <?php echo !empty($employee['position_name']) ? htmlspecialchars($employee['position_name']) : 'N/A'; ?>
                        </strong>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-5 label">Department</div>
                      <div class="col-lg-8 col-md-7 text-end" id="department_name_<?php echo $employee['emp_id']; ?>">
                        <strong>
                          <?php echo !empty($employee['department_name']) ? htmlspecialchars($employee['department_name']) : 'Unassigned'; ?>
                        </strong>
                      </div>
                    </div>

                  </div>
                </div>




              </div>

              <div class="col-xl-8">

                <div class="card">
                  <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                      <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Personal Details</button>
                      </li>

                      <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                      </li>

                      <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                      </li>

                      <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                      </li>

                    </ul>

                    <div class="tab-content pt-2">
                      <?php include './../modals/employee/modal_edit_employee.php' ?>
                      <?php include 'employee_tabs/personal_details.php'; ?>

                      <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                        <!-- Profile Edit Form -->
                        <form>
                          <div class="row mb-3">
                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                            <div class="col-md-8 col-lg-9">
                              <img src="./../assets/img/profile-img.jpg" alt="Profile">
                              <div class="pt-2">
                                <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="fullName" type="text" class="form-control" id="fullName" value="Kevin Anderson">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                            <div class="col-md-8 col-lg-9">
                              <textarea name="about" class="form-control" id="about" style="height: 100px">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</textarea>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="company" type="text" class="form-control" id="company" value="Lueilwitz, Wisoky and Leuschke">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="job" type="text" class="form-control" id="Job" value="Web Designer">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="country" type="text" class="form-control" id="Country" value="USA">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="address" type="text" class="form-control" id="Address" value="A108 Adam Street, New York, NY 535022">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="phone" type="text" class="form-control" id="Phone" value="(436) 486-3538 x29071">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="email" type="email" class="form-control" id="Email" value="k.anderson@example.com">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="twitter" type="text" class="form-control" id="Twitter" value="https://twitter.com/#">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="facebook" type="text" class="form-control" id="Facebook" value="https://facebook.com/#">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="instagram" type="text" class="form-control" id="Instagram" value="https://instagram.com/#">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="linkedin" type="text" class="form-control" id="Linkedin" value="https://linkedin.com/#">
                            </div>
                          </div>

                          <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                          </div>
                        </form><!-- End Profile Edit Form -->

                      </div>

                      <div class="tab-pane fade pt-3" id="profile-settings">

                        <!-- Settings Form -->
                        <form>

                          <div class="row mb-3">
                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                            <div class="col-md-8 col-lg-9">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="changesMade" checked>
                                <label class="form-check-label" for="changesMade">
                                  Changes made to your account
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="newProducts" checked>
                                <label class="form-check-label" for="newProducts">
                                  Information on new products and services
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="proOffers">
                                <label class="form-check-label" for="proOffers">
                                  Marketing and promo offers
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                                <label class="form-check-label" for="securityNotify">
                                  Security alerts
                                </label>
                              </div>
                            </div>
                          </div>

                          <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                          </div>
                        </form><!-- End settings Form -->

                      </div>

                      <div class="tab-pane fade pt-3" id="profile-change-password">
                        <!-- Change Password Form -->
                        <form>

                          <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="password" type="password" class="form-control" id="currentPassword">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="newpassword" type="password" class="form-control" id="newPassword">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                            </div>
                          </div>

                          <div class="text-center">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                          </div>
                        </form><!-- End Change Password Form -->

                      </div>
                    </div>
                    <!-- End Bordered Tabs -->
                  </div>
                </div>

              </div>
            </div>
          </section>
        <?php else: ?>
          <p>No Employee details found.</p>
        <?php endif; ?>
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
  // For Selectize
  $(document).ready(function() {
    $('select').selectize({
      sortField: 'text'
    });
  });

  $('.toggle-sidebar-btn').click(function() {
    $('#users_table').css('width', '100%');
    // console.log(table) //This is for testing only
  });

  //Table for Supplier
  $(document).ready(function() {
    var users_table = $('#users_table').DataTable({
      "pagingType": "numbers",
      "processing": true,
      "serverSide": true,
      "ajax": "./../controllers/tables/users_table.php",
      "order": [
        [0, "desc"]
      ] // <-- DESCENDING order by first column
    });

    window.reloadDataTable = function() {
      users_table.ajax.reload();
    };

  });

  //Bridge for Modal Backend to Frontend
  $(document).ready(function() {
    // Function to handle click event on datatable rows
    $('#users_table').on('click', 'tr td:nth-child(8) .fetchDataUser', function() {
      var user_id = $(this).closest('tr').find('td').first().text(); // Get the user_id from the clicked row
      console.log('Button clicked, User ID: ' + user_id);

      $.ajax({
        url: './../modals/users/modal_edit_user.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          user_id: user_id
        },
        success: function(response) {
          $('#modalContainerSupplier').html(response);
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
    $('#users_table').on('click', 'tr td:nth-child(8) .fetchDataUserDelete', function() {
      var user_id = $(this).closest('tr').find('td').first().text(); // Get the user_id from the clicked row
      console.log('Button clicked, User ID: ' + user_id);

      $.ajax({
        url: './../modals/users/modal_delete_user.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          user_id: user_id
        },
        success: function(response) {
          $('#modalContainerSupplier').html(response);
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
    $('#users_table').on('click', 'tr td:nth-child(4) .fetchDataPassword', function() {
      var user_id = $(this).closest('tr').find('td').first().text(); // Get the user_id from the clicked row
      console.log('Button clicked, User ID: ' + user_id);

      $.ajax({
        url: './../modals/customer/modal_view_password_client.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          user_id: user_id
        },
        success: function(response) {
          $('#modalContainerSupplier').html(response);
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