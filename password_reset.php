<?php
include './connections/connections.php';

include './controllers/login_validation.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>HRIS | Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
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

            <div class="d-flex justify-content-center py-4">
              <a href="index.html" class="logo d-flex align-items-center w-auto">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">HRIS</span>
              </a>
            </div>

            <div class="card mb-5 w-50">
              <div class="card-body">

                <div class="pt-3 pb-3">
                  <h5 class="card-title text-center pb-0 fs-4">
                    Set Up Your Account
                  </h5>
                  <p class="text-center text-muted small">
                    Create your username and password to continue
                  </p>
                </div>

                <form class="row g-3 user" id="setLoginForm">

                  <input type="hidden" id="lakan_user_id" value="<?php echo isset($_GET['lakan_user_id']) ? intval($_GET['lakan_user_id']) : 0; ?>">

                  <!-- Username -->
                  <div class="col-12">
                    <div class="input-group has-validation">
                      <span class="input-group-text">
                        <i class="bi bi-person"></i>
                      </span>

                      <div class="form-floating">
                        <input
                          type="text"
                          class="form-control"
                          id="username"
                          name="username"
                          placeholder="Username"
                          required>
                        <label for="username">Username</label>
                      </div>
                    </div>
                  </div>

                  <!-- New Password -->
                  <div class="col-12">
                    <div class="input-group">
                      <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                      </span>

                      <div class="form-floating flex-grow-1">
                        <input
                          type="password"
                          class="form-control"
                          id="lakan_password"
                          name="lakan_password"
                          placeholder="New Password"
                          required>
                        <label for="lakan_password">New Password</label>
                      </div>

                      <button
                        class="btn btn-outline-secondary"
                        type="button"
                        id="toggleNewPassword"
                        title="Show / Hide Password">
                        <i class="bi bi-eye"></i>
                      </button>
                    </div>
                  </div>

                  <!-- Confirm Password -->
                  <div class="col-12">
                    <div class="input-group">
                      <span class="input-group-text">
                        <i class="bi bi-lock-fill"></i>
                      </span>

                      <div class="form-floating flex-grow-1">
                        <input
                          type="password"
                          class="form-control"
                          id="emp_pass_confirm"
                          name="emp_pass_confirm"
                          placeholder="Confirm Password"
                          required>
                        <label for="emp_pass_confirm">Confirm Password</label>
                      </div>

                      <button
                        class="btn btn-outline-secondary"
                        type="button"
                        id="toggleConfirmPassword"
                        title="Show / Hide Password">
                        <i class="bi bi-eye"></i>
                      </button>
                    </div>

                    <br>

                    <!-- Match Message -->
                    <small id="passwordMatchMsg" class="ms-1"></small>
                  </div>


                  <hr>

                  <!-- Login Button -->
                  <button
                    type="submit"
                    id="setLoginBtn"
                    class="btn btn-primary w-100">
                    <span id="btnText">Save & Continue</span>
                    <span
                      id="btnSpinner"
                      class="spinner-border spinner-border-sm ms-2 d-none"
                      role="status"></span>
                  </button>



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
  const newPassword = document.getElementById('lakan_password');
  const confirmPassword = document.getElementById('emp_pass_confirm');
  const matchMsg = document.getElementById('passwordMatchMsg');
  const submitBtn = document.getElementById('setLoginBtn');

  // Real-time password match checker
  function checkPasswordMatch() {
    if (!confirmPassword.value) {
      matchMsg.textContent = '';
      submitBtn.disabled = true;
      return;
    }

    if (newPassword.value === confirmPassword.value) {
      matchMsg.textContent = '✔ Passwords match';
      matchMsg.className = 'text-success';
      submitBtn.disabled = false;
    } else {
      matchMsg.textContent = '✖ Passwords do not match';
      matchMsg.className = 'text-danger';
      submitBtn.disabled = true;
    }
  }

  newPassword.addEventListener('input', checkPasswordMatch);
  confirmPassword.addEventListener('input', checkPasswordMatch);

  // Toggle New Password
  document.getElementById('toggleNewPassword').addEventListener('click', function() {
    const type = newPassword.type === 'password' ? 'text' : 'password';
    newPassword.type = type;
    this.innerHTML = type === 'password' ?
      '<i class="bi bi-eye"></i>' :
      '<i class="bi bi-eye-slash"></i>';
  });

  // Toggle Confirm Password
  document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    const type = confirmPassword.type === 'password' ? 'text' : 'password';
    confirmPassword.type = type;
    this.innerHTML = type === 'password' ?
      '<i class="bi bi-eye"></i>' :
      '<i class="bi bi-eye-slash"></i>';
  });

  // Disable submit button on load
  submitBtn.disabled = true;

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

  // Submit Login Form (AJAX)
  $('#setLoginForm').on('submit', function(e) {
    e.preventDefault();

    const btn = $('#setLoginBtn');
    $('#btnText').text('Saving...');
    $('#btnSpinner').removeClass('d-none');
    btn.prop('disabled', true);

    $.ajax({
      url: './controllers/save_password_login_process.php',
      type: 'POST',
      data: {
        lakan_user_id: $('#lakan_user_id').val(),
        username: $('#username').val(),
        lakan_password: $('#lakan_password').val()
      },
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          // Change button text and keep it disabled
          // $('#btnText').text('Redirecting please wait...');
          $('#btnText').text('Great! Logging you in now...');
          btn.prop('disabled', true);

          setTimeout(function() {
            window.location.href = '/lakan/views/dashboard_module.php';
          }, 2000); // 2 seconds delay
        } else {
          showToast(response.message);
          // Re-enable button if failed
          btn.prop('disabled', false);
        }
      },
      error: function() {
        showToast('Server error. Please try again.');
        btn.prop('disabled', false);
      },
      complete: function() {
        $('#btnSpinner').addClass('d-none');
        // Do not change btnText here if success — we already changed it
        if (!response.success) {
          $('#btnText').text('Save & Continue');
        }
      }
    });
  });
</script>