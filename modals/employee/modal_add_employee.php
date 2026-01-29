<?php

// Query for Department
$sql = "SELECT * FROM department";
$resultDepartment = mysqli_query($conn, $sql);

$department_names = [];
if ($resultDepartment) {
  while ($row = mysqli_fetch_assoc($resultDepartment)) {
    $department_names[] = $row;
  }
}

?>

<style>
</style>

<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-l" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEmployeeModalLabel">Create New Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-row">
            <!-- Employee Number -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-list-ol"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="text" class="form-control" id="employee_number" name="employee_number" placeholder="Employee Code" required>
                <label for="employee_number">Employee Code <span class="text-danger">*</span></label>
              </div>
            </div>

            <!-- Last Name -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="text" class="form-control" id="emp_lastname" name="emp_lastname" placeholder="Last Name" required>
                <label for="emp_lastname">Last Name <span class="text-danger">*</span></label>
              </div>
            </div>

            <!-- First Name -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="text" class="form-control" id="emp_firstname" name="emp_firstname" placeholder="First Name" required>
                <label for="emp_firstname">First Name <span class="text-danger">*</span></label>
              </div>
            </div>

            <!-- Middle Name -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="text" class="form-control" id="emp_middlename" name="emp_middlename" placeholder="Middle Name">
                <label for="emp_middlename">Middle Name</label>
              </div>
            </div>

            <!-- Department -->
            <div class="input-group mb-3">

              <!-- It has style because of the Selectize -->
              <span class="input-group-text" style="height: 34px !important;">
                <i class="bi bi-building"></i>
              </span>

              <select class="form-control" id="department_id" name="department_id" required>
                <option value="">Select Department <span class="text-danger">*</span></option>

                <?php foreach ($department_names as $dept): ?>
                  <option value="<?php echo htmlspecialchars($dept['department_id']); ?>">
                    <?php echo htmlspecialchars($dept['department_name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Birthdate -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="date" class="form-control" id="birth_date" name="birth_date" placeholder="Date Hired" required>
                <label for="birth_date">Birth Date <span class="text-danger">*</span></label>
              </div>
            </div>

            <!-- Date Hired -->
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="date" class="form-control" id="date_hired" name="date_hired" placeholder="Date Hired" required>
                <label for="date_hired">Date Hired <span class="text-danger">*</span></label>
              </div>
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
  document.addEventListener("DOMContentLoaded", function() {

    // Initialize Bootstrap 5 modal object
    const addEmployeeModalEl = document.getElementById('addEmployeeModal');
    const addEmployeeModal = new bootstrap.Modal(addEmployeeModalEl);

    const form = addEmployeeModalEl.querySelector('form');
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
        url: '/lakan/controllers/add_employee_process.php',
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
              addEmployeeModal.hide();

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