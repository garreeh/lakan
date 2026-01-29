<?php

// Query for Department
$sql = "SELECT * FROM membership_type";
$resultMembershipType = mysqli_query($conn, $sql);

$membership_type_names = [];
if ($resultMembershipType) {
  while ($row = mysqli_fetch_assoc($resultMembershipType)) {
    $membership_type_names[] = $row;
  }
}

?>

<style>
</style>

<div class="modal fade" id="addMembersModal" tabindex="-1" role="dialog" aria-labelledby="addMembersModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-l" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMembersModalLabel">Create New Members</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-row">

            <!-- Last Name -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                <label for="last_name">Last Name <span class="text-danger">*</span></label>
              </div>
            </div>

            <!-- First Name -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                <label for="first_name">First Name <span class="text-danger">*</span></label>
              </div>
            </div>

            <!-- Middle Name -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name">
                <label for="middle_name">Middle Name</label>
              </div>
            </div>

            <!-- Birthdate -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="date" class="form-control" id="birth_date" name="birth_date" placeholder="Birth Hired" required>
                <label for="birth_date">Birth Date <span class="text-danger">*</span></label>
              </div>
            </div>

            <!-- Age -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="text" class="form-control" id="age" name="age" placeholder="Age" readonly>
                <label for="age">Age</label>
              </div>
            </div>

            <!-- Start Date -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="date" class="form-control" id="start_date_membership" name="start_date_membership" placeholder="Start Hired" required>
                <label for="start_date_membership">Start Date Subscription<span class="text-danger">*</span></label>
              </div>
            </div>

            <!-- End Date -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="date" class="form-control" id="end_date_membership" name="end_date_membership" placeholder="End Date" required>
                <label for="end_date_membership">End Date Subscription<span class="text-danger">*</span></label>
              </div>
            </div>

            <!-- Gender -->
            <div class="input-group mb-3">
              <span class="input-group-text" style="height: 34px !important;">
                <i class="bi bi-gender-ambiguous"></i>
              </span>
              <select class="form-control" id="gender" name="gender" required>
                <option value="" selected disabled>Choose Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>


            <!-- Membership Type -->
            <div class="input-group mb-3">
              <!-- It has style because of the Selectize -->
              <span class="input-group-text" style="height: 34px !important;">
                <i class="bi bi-collection"></i>
              </span>

              <select class="form-control" id="membership_type_id" name="membership_type_id" required>
                <option value="">Select Membership Type <span class="text-danger">*</span></option>
                <?php foreach ($membership_type_names as $membs): ?>
                  <option value="<?php echo htmlspecialchars($membs['membership_type_id']); ?>">
                    <?php echo htmlspecialchars($membs['membership_type_name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

          </div>
          <input type="hidden" name="add_employee" value="1">
          <!-- Modal Footer Buttons -->
          <div class="modal-footer">
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
  // Age Computation
  document.addEventListener('DOMContentLoaded', function() {
    const birthInput = document.getElementById('birth_date');
    const ageInput = document.getElementById('age');

    birthInput.addEventListener('change', function() {
      const birthDate = new Date(this.value);
      if (!isNaN(birthDate)) {
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();

        // Adjust if birthday hasn't occurred yet this year
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
          age--;
        }

        ageInput.value = age;
      } else {
        ageInput.value = '';
      }
    });
  });

  // Bridge Communication for backend
  document.addEventListener("DOMContentLoaded", function() {

    // Initialize Bootstrap 5 modal object
    const addMembersModalEl = document.getElementById('addMembersModal');
    const addMembersModal = new bootstrap.Modal(addMembersModalEl);

    const form = addMembersModalEl.querySelector('form');
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
        url: '/lakan/controllers/add_customer_process.php',
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
              addMembersModal.hide();

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