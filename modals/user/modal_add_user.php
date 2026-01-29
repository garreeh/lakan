<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Create User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body">
        <form method="post">
          <div class="row g-3">

            <!-- First Name -->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-person"></i>
                </span>
                <div class="form-floating flex-grow-1">
                  <input type="text" class="form-control" id="lakan_firstname" name="lakan_firstname" placeholder="First Name" required>
                  <label for="lakan_firstname">First Name <span class="text-danger">*</span></label>
                </div>
              </div>
            </div>

            <!-- Middle Name -->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-person"></i>
                </span>
                <div class="form-floating flex-grow-1">
                  <input type="text" class="form-control" id="lakan_middlename" name="lakan_middlename" placeholder="Middle Name">
                  <label for="lakan_middlename">Middle Name</label>
                </div>
              </div>
            </div>

            <!-- Last Name -->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-person"></i>
                </span>
                <div class="form-floating flex-grow-1">
                  <input type="text" class="form-control" id="lakan_lastname" name="lakan_lastname" placeholder="Last Name" required>
                  <label for="lakan_lastname">Last Name <span class="text-danger">*</span></label>
                </div>
              </div>
            </div>

            <!-- Username -->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-person-badge"></i>
                </span>
                <div class="form-floating flex-grow-1">
                  <input type="text" class="form-control" id="lakan_username" name="lakan_username" placeholder="Username" required>
                  <label for="lakan_username">Username <span class="text-danger">*</span></label>
                </div>
              </div>
            </div>

            <!-- Email -->
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-envelope"></i>
                </span>
                <div class="form-floating flex-grow-1">
                  <input type="email" class="form-control" id="lakan_email" name="lakan_email" placeholder="Email" required>
                  <label for="lakan_email">Email <span class="text-danger">*</span></label>
                </div>
              </div>
            </div>

            <!-- Password -->
            <div class="col-md-4">
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
                    placeholder="Password"
                    required>
                  <label for="lakan_password">
                    Password <span class="text-danger">*</span>
                  </label>
                </div>

                <!-- Eye Toggle -->
                <span class="input-group-text" style="cursor:pointer"
                  onclick="togglePassword()">
                  <i class="bi bi-eye" id="togglePasswordIcon"></i>
                </span>
              </div>
            </div>


          </div>

          <input type="hidden" name="add_users" value="1">

          <!-- Modal Footer -->
          <div class="modal-footer mt-4">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>


      </div>
    </div>
  </div>
</div>


<!-- Include JS QUERY For AJAX-->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- Include Toastify JS -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
  function togglePassword() {
    const password = document.getElementById('lakan_password');
    const icon = document.getElementById('togglePasswordIcon');

    if (password.type === 'password') {
      password.type = 'text';
      icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
      password.type = 'password';
      icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.getElementById('membershiptype_price');

    priceInput.addEventListener('input', function() {
      // Remove any non-digit characters
      this.value = this.value.replace(/[^0-9]/g, '');
    });
  });

  document.addEventListener("DOMContentLoaded", function() {
    // Initialize Bootstrap 5 modal object
    const addUserModalEl = document.getElementById('addUserModal');
    const addUserModal = new bootstrap.Modal(addUserModalEl);

    const form = addUserModalEl.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function(e) {
      e.preventDefault();

      // Disable button and show spinner
      submitBtn.disabled = true;
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...`;

      // Serialize form data using jQuery (or FormData)
      const formData = $(form).serialize();

      $.ajax({
        type: 'POST',
        url: '/lakan/controllers/add_user_process.php',
        data: formData,
        success: function(response) {
          try {
            response = JSON.parse(response);

            if (response.success) {
              Toastify({
                text: response.message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
              }).showToast();

              // Reset form
              form.reset();

              // Close modal (Bootstrap 5)
              addUserModal.hide();

              // Reload DataTable if you have one
              if (typeof window.reloadDataTable === 'function') {
                window.reloadDataTable();
              }
            } else {
              Toastify({
                text: response.message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
              }).showToast();
            }
          } catch (err) {
            console.error(err);
            Toastify({
              text: "Invalid response from server.",
              duration: 3000,
              close: true,
              gravity: "top",
              position: "right",
              backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
            }).showToast();
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          Toastify({
            text: "Error occurred while adding employee. Please try again later.",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
          }).showToast();
        },
        complete: function() {
          // Re-enable button and reset text
          submitBtn.disabled = false;
          submitBtn.innerHTML = "Submit";
        }
      });

    });

  });
</script>