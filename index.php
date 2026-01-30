<?php
include './connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['lakan_user_id'])) {
  header("Location: /lakan/views/dashboard_module.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Lakan | Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.jpg" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <style>
    /* Custom styles for login only*/
    @media (min-width: 576px) {
      .form-control {
        margin: auto;
      }
    }
  </style>


</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">




            <div class="card mb-5">

              <div class="card-body">

                <div class="d-flex justify-content-center py-4">
                  <a href="index.html" class="">
                    <img src="assets/img/logo.jpg" alt="Logo" style="height: 150px;">
                  </a>
                </div>

                <form class="row g-3 user" id="loginForm">
                  <!-- Username / Email -->
                  <div class="col-12">
                    <div class="input-group has-validation">
                      <span class="input-group-text">
                        <i class="bi bi-person"></i>
                      </span>

                      <div class="form-floating flex-grow-1">
                        <input type="text" class="form-control" id="username_or_email" name="username_or_email" placeholder="Username or Email" required>
                        <label for="username_or_email">Username or Email</label>
                      </div>
                    </div>
                  </div>

                  <!-- Password with toggle -->
                  <div class="col-12">
                    <div class="input-group">
                      <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                      </span>

                      <div class="form-floating flex-grow-1">
                        <input type="password" class="form-control" id="lakan_password" name="lakan_password" placeholder="Password" required>
                        <label for="lakan_password">Password</label>
                      </div>

                      <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="bi bi-eye"></i>
                      </button>
                    </div>
                  </div>

                  <div class="col-12">
                    <hr>
                  </div>

                  <!-- Submit Button -->
                  <div class="col-12">
                    <button type="submit" id="loginBtn" class="btn btn-primary w-100">
                      <span id="btnText">Login</span>
                      <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                    </button>
                  </div>
                </form>


              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main>
  <!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Template Main JS File -->
  <!-- <script src="assets/js/main.js"></script> -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

</html>

<script>
  // Show toast
  function showToast(message) {
    Toastify({
      text: message,
      duration: 3000,
      close: true,
      gravity: "top",
      position: "right",
      backgroundColor: "red",
    }).showToast();
  }

  // Toggle password
  $('#togglePassword').on('click', function() {
    const input = $('#lakan_password');
    const type = input.attr('type') === 'password' ? 'text' : 'password';
    input.attr('type', type);
    $(this).html(type === 'password' ?
      '<i class="bi bi-eye"></i>' :
      '<i class="bi bi-eye-slash"></i>');
  });

  // Submit form (AJAX)
  $('#loginForm').on('submit', function(e) {
    e.preventDefault();

    const btn = $('#loginBtn');
    $('#btnText').text('Logging in...');
    $('#btnSpinner').removeClass('d-none');
    btn.prop('disabled', true);

    $.ajax({
      url: './controllers/login_process.php',
      type: 'POST',
      data: {
        username_or_email: $('#username_or_email').val(),
        lakan_password: $('#lakan_password').val()
      },
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          window.location.href = '/lakan/views/dashboard_module.php';
        } else {
          showToast(response.message);
        }
      },

      error: function() {
        showToast('Server error. Please try again.');
      },
      complete: function() {
        $('#btnText').text('Login');
        $('#btnSpinner').addClass('d-none');
        btn.prop('disabled', false);
      }
    });
  });
</script>