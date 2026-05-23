<?php
include './../connections/connections.php';

$customer_id = (int) $_GET['customer_id'];

$data = null;
$groupedPayments = [];

/* =========================
   GET CUSTOMER INFO
========================= */
$sql = "SELECT 
    customer.*,
    membership_type.membershiptype_price
FROM customer
LEFT JOIN membership_type 
    ON membership_type.membership_type_id = customer.membership_type_id
WHERE customer.customer_id = $customer_id
LIMIT 1";

$res = mysqli_query($conn, $sql);

if ($res && mysqli_num_rows($res) > 0) {
  $data = mysqli_fetch_assoc($res);
}

/* =========================
   GET CYCLES (WITH PRICE)
========================= */
$cycles = [];

/* CUSTOMER (LATEST) */
$res = mysqli_query($conn, "
  SELECT 
    c.start_date_membership AS start_date,
    c.payment_type,
    c.down_payment_amount,
    c.membership_type_id,
    mt.membershiptype_price
  FROM customer c
  LEFT JOIN membership_type mt 
    ON mt.membership_type_id = c.membership_type_id
  WHERE c.customer_id = $customer_id
");

while ($row = mysqli_fetch_assoc($res)) {
  $row['source'] = 'customer';
  $cycles[] = $row;
}

/* HISTORY (RENEWALS) */
$res = mysqli_query($conn, "
  SELECT 
    h.start_date,
    h.payment_type,
    h.down_payment_amount,
    h.membership_type_id,
    mt.membershiptype_price
  FROM membership_history h
  LEFT JOIN membership_type mt 
    ON mt.membership_type_id = h.membership_type_id
  WHERE h.customer_id = $customer_id
");

while ($row = mysqli_fetch_assoc($res)) {
  $row['source'] = 'history';
  $cycles[] = $row;
}

/* =========================
   SORT BY DATE
========================= */
usort($cycles, function ($a, $b) {
  return strtotime($a['start_date']) <=> strtotime($b['start_date']);
});

/* =========================
   GET ALL PAYMENTS
========================= */
$payments = [];

$res = mysqli_query($conn, "
  SELECT created_at, payment_amount
  FROM downpayment_record_customer
  WHERE customer_id = $customer_id
");

while ($row = mysqli_fetch_assoc($res)) {
  $payments[] = $row;
}

/* =========================
   BUILD GROUPS
========================= */
foreach ($cycles as $i => $cycle) {

  $start = $cycle['start_date'];
  $next = $cycles[$i + 1]['start_date'] ?? null;

  $key = "cycle_" . $i;

  $groupedPayments[$key] = [
    'start_date' => $start,
    'items' => []
  ];

  /* =========================
     FIXED LOGIC HERE
  ========================= */
  $dpAmount = (float) $cycle['down_payment_amount'];

  // FULL PAYMENT only if NO downpayment
  $isFullPayment = ($dpAmount <= 0);

  if ($isFullPayment) {

    $groupedPayments[$key]['items'][] = [
      'date' => $start,
      'amount' => (float) $cycle['membershiptype_price']
    ];

  } else {

    // DOWNPAYMENT (INITIAL)
    $groupedPayments[$key]['items'][] = [
      'date' => $start,
      'amount' => $dpAmount
    ];
  }

  /* =========================
     ADD ACTUAL PAYMENTS
  ========================= */
  foreach ($payments as $p) {

    $d = $p['created_at'];

    if (
      strtotime($d) >= strtotime($start) &&
      (!$next || strtotime($d) < strtotime($next))
    ) {
      $groupedPayments[$key]['items'][] = [
        'date' => $d,
        'amount' => (float) $p['payment_amount']
      ];
    }
  }

  /* =========================
     SORT ITEMS
  ========================= */
  usort($groupedPayments[$key]['items'], function ($a, $b) {
    return strtotime($a['date']) <=> strtotime($b['date']);
  });
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Member Details | Lakan</title>
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
          <h1>Member Details</h1>
          <br>

          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/lakan/views/dashboard_module.php">Home</a></li>
              <li class="breadcrumb-item active">Member Details</li>
            </ol>
          </nav>

        </div>


        <?php if (isset($data)): ?>

          <section class="section profile">
            <div class="row">
              <div class="col-xl-4">

                <div class="card shadow-sm border-0">
                  <br>
                  <div class="card-body text-center">

                    <?php
                    // Profile image
                    $profileSrc = !empty($data['profile_pic']) ? $data['profile_pic'] : '';
                    ?>

                    <!-- Profile Image -->
                    <div class="d-flex justify-content-center mb-3">
                      <?php if ($profileSrc): ?>
                        <img id="profile_pic_<?php echo $data['customer_id']; ?>" src="<?php echo $profileSrc; ?>"
                          alt="Profile" class="rounded-circle border border-light shadow-sm"
                          style="width:120px; height:120px; object-fit:cover;">
                      <?php else: ?>
                        <div
                          class="rounded-circle bg-light d-flex align-items-center justify-content-center border border-light shadow-sm"
                          style="width:120px; height:120px;">
                          <span class="text-muted fs-2">&#128100;</span> <!-- user icon -->
                        </div>
                      <?php endif; ?>
                    </div>

                    <!-- Full Name -->
                    <h5 class="card-title mb-3" id="cus_fullname_<?php echo $data['customer_id']; ?>">
                      <?php
                      echo htmlspecialchars(
                        $data['first_name'] .
                        (!empty($data['middle_name']) ? ' ' . $data['middle_name'] : '') .
                        ' ' . $data['last_name']
                      );
                      ?>
                    </h5>

                    <div class="text-center mb-2">
                      <?php
                      date_default_timezone_set('Asia/Manila');

                      $today = date('Y-m-d');

                      if (!empty($data['membership_type_id']) && $data['membership_type_id'] == 4) {

                        echo '<span class="badge fw-bold" style="background-color: #a8d8f0; color: #000;">VIP</span>';

                      } else {

                        $start = !empty($data['start_date_membership']) ? date('Y-m-d', strtotime($data['start_date_membership'])) : null;
                        $end = !empty($data['end_date_membership']) ? date('Y-m-d', strtotime($data['end_date_membership'])) : null;

                        if ($start && $end && $today < $start) {

                          // 🟡 UPCOMING
                          $status = 'Upcoming';
                          $bgColor = '#fff3cd';
                          $textColor = '#856404';

                        } elseif ($start && $end && $start <= $today && $end >= $today) {

                          // 🟢 ACTIVE
                          $status = 'Active';
                          $bgColor = '#d4edda';
                          $textColor = '#155724';

                        } else {

                          // 🔴 EXPIRED
                          $status = 'Expired';
                          $bgColor = '#f8d7da';
                          $textColor = '#721c24';
                        }

                        echo '<span class="badge fw-bold" style="background-color: ' . $bgColor . '; color: ' . $textColor . ';">' . $status . '</span>';
                      }
                      ?>
                    </div>

                    <!-- Dates Section -->
                    <div class="d-flex justify-content-center gap-4 mb-3">
                      <div class="text-center">
                        <small class="text-secondary">Start Date</small>
                        <div class="fw-bold" id="start_date_<?php echo $data['customer_id']; ?>">
                          <?php
                          // Check if empty or default 0000-00-00
                          $start = $data['start_date_membership'];
                          echo (!empty($start) && $start !== '0000-00-00' && $start !== '0000-00-00 00:00:00')
                            ? date('F j, Y', strtotime($start))
                            : '-';
                          ?>
                        </div>
                      </div>

                      <div class="text-center">
                        <small class="text-secondary">End Date</small>
                        <div class="fw-bold text-danger" id="end_date_<?php echo $data['customer_id']; ?>">
                          <?php
                          $end = $data['end_date_membership'];
                          echo (!empty($end) && $end !== '0000-00-00' && $end !== '0000-00-00 00:00:00')
                            ? date('F j, Y', strtotime($end))
                            : '-';
                          ?>
                        </div>
                      </div>
                    </div>




                    <div class="row g-2 mt-3">
                      <!-- Renew Membership -->
                      <div class="col-4">
                        <a href="#" class="btn btn-sm btn-success shadow-lg w-100" data-bs-toggle="modal"
                          data-bs-target="#renewMembershipModal">
                          <i class="bi bi-arrow-repeat me-1"></i>
                          <span class="d-none d-md-inline">Renew</span>
                        </a>
                      </div>

                      <!-- Membership History -->
                      <div class="col-4">
                        <a href="#" class="btn btn-sm btn-primary shadow-lg w-100" data-bs-toggle="modal"
                          data-bs-target="#membershipHistoryModal">
                          <i class="bi bi-clock-history me-1"></i>
                          <span class="d-none d-md-inline">History</span>
                        </a>
                      </div>

                      <!-- Pause -->
                      <div class="col-4">
                        <a href="#" id="pauseBtn"
                          class="btn btn-sm btn-warning shadow-lg w-100 <?php echo ($data['is_paused'] == 1) ? 'd-none' : ''; ?>"
                          data-bs-toggle="modal" data-bs-target="#membershipPauseModal">
                          <i class="bi bi-pause-circle me-1"></i>
                          <span class="d-none d-md-inline">Pause</span>
                        </a>

                        <!-- Resume -->
                        <a href="#" id="resumeBtn"
                          class="btn btn-sm btn-info shadow-lg w-100 <?php echo ($data['is_paused'] == 1) ? '' : 'd-none'; ?>"
                          data-bs-toggle="modal" data-bs-target="#membershipResumeModal">
                          <i class="bi bi-play-circle me-1"></i>
                          <span class="d-none d-md-inline">Resume</span>
                        </a>
                      </div>


                      <?php
                      date_default_timezone_set('Asia/Manila');

                      $endDate = !empty($data['end_date_membership']) ? strtotime($data['end_date_membership']) : null;
                      $today = strtotime(date('Y-m-d'));
                      ?>

                      <!-- Modify Subscription -->
                      <?php if ($endDate && $endDate >= $today): ?>

                        <div class="col-12">
                          <a href="#" class="btn btn-sm btn-dark shadow-lg w-100" data-bs-toggle="modal"
                            data-bs-target="#modifySubscriptionModal">
                            <i class="bi bi-pencil-square me-1"></i>
                            Manage Subscription
                          </a>
                        </div>

                      <?php endif; ?>
                    </div>


                  </div>
                </div>
                <?php include './../modals/renew_and_history/modal_renew_membership.php' ?>
                <?php include './../modals/renew_and_history/modal_history_membership.php' ?>
                <?php include './../modals/renew_and_history/modal_pause_membership.php' ?>
                <?php include './../modals/renew_and_history/modal_resume_membership.php' ?>
                <?php include './../modals/membership_type/modal_manage_subscription_membership.php' ?>




              </div>

              <div class="col-xl-8">

                <div class="card">
                  <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                      <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Personal
                          Info</button>
                      </li>

                      <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Payment
                          Details</button>
                      </li>

                      <!-- <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                      </li>

                      <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                      </li> -->

                    </ul>

                    <div class="tab-content pt-2">
                      <!-- Personal Details Tab Below -->
                      <?php include './../modals/members/modal_add_body_fats.php' ?>
                      <?php include './../modals/members/modal_add_weight.php' ?>
                      <?php include './../modals/members/modal_edit_members.php' ?>
                      <?php include 'member_tabs/personal_details.php'; ?>
                      <?php include 'member_tabs/payment_details.php'; ?>

                      <!-- Payment Details Tab Below -->
                      <?php include './../modals/members/modal_add_payments.php' ?>
                      <?php include './../modals/members/modal_payment_history.php' ?>


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

  <!-- COPY THESE WHOLE CODE WHEN IMPORT SELECT -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
    integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
    integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

</body>

</html>

<script>
  // Hide Pause Button
  function showResumeButton() {
    const pauseBtn = document.getElementById('pauseBtn');
    const resumeBtn = document.getElementById('resumeBtn');

    if (pauseBtn) pauseBtn.classList.add('d-none');
    if (resumeBtn) resumeBtn.classList.remove('d-none');
  }

  function showPauseButton() {
    const pauseBtn = document.getElementById('pauseBtn');
    const resumeBtn = document.getElementById('resumeBtn');

    if (pauseBtn) pauseBtn.classList.remove('d-none');
    if (resumeBtn) resumeBtn.classList.add('d-none');
  }
  // For Selectize
  $(document).ready(function () {
    $('select').selectize({
      sortField: 'text'
    });
  });

  $('.toggle-sidebar-btn').click(function () {
    $('#users_table').css('width', '100%');
    // console.log(table) //This is for testing only
  });

  //Table for Supplier
  $(document).ready(function () {
    var users_table = $('#users_table').DataTable({
      "pagingType": "numbers",
      "processing": true,
      "serverSide": true,
      "ajax": "./../controllers/tables/users_table.php",
      "order": [
        [0, "desc"]
      ] // <-- DESCENDING order by first column
    });
    window.reloadDataTable = function () {
      users_table.ajax.reload();
    };
  });

  //Bridge for Modal Backend to Frontend
  $(document).ready(function () {
    // Function to handle click event on datatable rows
    $('#users_table').on('click', 'tr td:nth-child(8) .fetchDataUser', function () {
      var user_id = $(this).closest('tr').find('td').first().text(); // Get the user_id from the clicked row
      console.log('Button clicked, User ID: ' + user_id);

      $.ajax({
        url: './../modals/customer/modal_edit_user.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          user_id: user_id
        },
        success: function (response) {
          $('#modalContainerSupplier').html(response);
          $('#fetchDataUserModal').modal('show');
          console.log("Modal content loaded for User ID: " + user_id);
        },
        error: function (xhr, status, error) {
          console.error("Error: " + xhr.responseText);
        }
      });
    });
  });

  $(document).ready(function () {
    // Function to handle click event on datatable rows
    $('#users_table').on('click', 'tr td:nth-child(8) .fetchDataUserDelete', function () {
      var user_id = $(this).closest('tr').find('td').first().text(); // Get the user_id from the clicked row
      console.log('Button clicked, User ID: ' + user_id);

      $.ajax({
        url: './../modals/customer/modal_delete_user.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          user_id: user_id
        },
        success: function (response) {
          $('#modalContainerSupplier').html(response);
          $('#deleteDataUserModal').modal('show');
          console.log("Modal content loaded for User ID: " + user_id);
        },
        error: function (xhr, status, error) {
          console.error("Error: " + xhr.responseText);
        }
      });
    });
  });

  //Bridge for Modal Backend to Frontend
  $(document).ready(function () {
    // Function to handle click event on datatable rows
    $('#users_table').on('click', 'tr td:nth-child(4) .fetchDataPassword', function () {
      var user_id = $(this).closest('tr').find('td').first().text(); // Get the user_id from the clicked row
      console.log('Button clicked, User ID: ' + user_id);

      $.ajax({
        url: './../modals/customer/modal_view_password_client.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          user_id: user_id
        },
        success: function (response) {
          $('#modalContainerSupplier').html(response);
          $('#fetchDataUserModal').modal('show');
          console.log("Modal content loaded for User ID: " + user_id);
        },
        error: function (xhr, status, error) {
          console.error("Error: " + xhr.responseText);
        }
      });
    });
  });
</script>