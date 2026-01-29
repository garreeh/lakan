<?php
include './../../connections/connections.php';

if (isset($_POST['lakan_user_id'])) {
  $lakan_user_id = $_POST['lakan_user_id'];

  $sql = "SELECT * FROM users WHERE lakan_user_id = '$lakan_user_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
?>
      <div class="modal fade" id="editUsersModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title">
                Edit User: <?php echo htmlspecialchars($row['lakan_username']); ?>
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              <form method="post">
                <input type="hidden" name="lakan_user_id" value="<?php echo $row['lakan_user_id']; ?>">

                <div class="row g-3">

                  <div class="col-md-4">
                    <div class="form-floating">
                      <input type="text" class="form-control" name="lakan_firstname"
                        value="<?php echo htmlspecialchars($row['lakan_firstname']); ?>" required>
                      <label>First Name</label>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-floating">
                      <input type="text" class="form-control" name="lakan_middlename"
                        value="<?php echo htmlspecialchars($row['lakan_middlename']); ?>">
                      <label>Middle Name</label>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-floating">
                      <input type="text" class="form-control" name="lakan_lastname"
                        value="<?php echo htmlspecialchars($row['lakan_lastname']); ?>" required>
                      <label>Last Name</label>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="text" class="form-control" name="lakan_username"
                        value="<?php echo htmlspecialchars($row['lakan_username']); ?>" required>
                      <label>Username</label>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="email" class="form-control" name="lakan_email"
                        value="<?php echo htmlspecialchars($row['lakan_email']); ?>" required>
                      <label>Email</label>
                    </div>
                  </div>

                  <!-- Password Field with Toggle -->
                  <div class="col-md-12">
                    <div class="input-group">
                      <div class="form-floating flex-grow-1">
                        <input type="password" class="form-control"
                          id="edit_lakan_password"
                          name="lakan_password"
                          placeholder="New Password">
                        <label>New Password (leave blank to keep current)</label>
                      </div>
                      <span class="input-group-text" style="cursor:pointer"
                        onclick="togglePasswordEdit()">
                        <i class="bi bi-eye" id="editPasswordIcon"></i>
                      </span>
                    </div>
                  </div>

                </div>

                <input type="hidden" name="edit_users" value="1">

                <div class="modal-footer mt-3">
                  <button type="submit" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

              </form>
            </div>

          </div>
        </div>
      </div>

<?php
    }
  }
}
?>



<script>
  function togglePasswordEdit() {
    const input = document.getElementById('edit_lakan_password');
    const icon = document.getElementById('editPasswordIcon');

    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('bi-eye');
      icon.classList.add('bi-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.remove('bi-eye-slash');
      icon.classList.add('bi-eye');
    }
  }

  document.getElementById('editUsersModal').addEventListener('shown.bs.modal', function() {
    const priceInput = document.getElementById('membershiptype_price_edit');
    if (priceInput) {
      priceInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
      });
    }
  });

  // Function for connecting to backend real time.
  $(document).ready(function() {
    $('#editUsersModal form').submit(function(event) {
      event.preventDefault();

      var $form = $(this);
      var $submitButton = $form.find('button[type="submit"]');

      // Store original button HTML (important for restoring)
      var originalHtml = $submitButton.html();

      // Set button to Saving + Spinner
      $submitButton
        .prop('disabled', true)
        .html(`
          <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
          Saving...
        `);

      var formData = $form.serialize();

      $.ajax({
        type: 'POST',
        url: '/lakan/controllers/edit_user_process.php',
        data: formData,
        success: function(response) {
          response = JSON.parse(response);

          if (response.success) {
            Toastify({
              text: response.message,
              duration: 2000,
              close: true,
              backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
            }).showToast();

            $('#editUsersModal').modal('hide');
            reloadDataTable();
          } else {
            Toastify({
              text: response.message,
              duration: 2000,
              close: true,
              backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
            }).showToast();
          }
        },
        error: function(xhr) {
          console.error(xhr.responseText);
          Toastify({
            text: "Error occurred while editing Membership Type. Please try again later.",
            duration: 2000,
            close: true,
            backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
          }).showToast();
        },
        complete: function() {
          // Restore button state
          $submitButton
            .prop('disabled', false)
            .html(originalHtml);
        }
      });
    });
  });

  // Table Function 
  function reloadDataTable() {
    $('#users_table').DataTable().ajax.reload(null, false);
  }
</script>