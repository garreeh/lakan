<?php
include './../../connections/connections.php';

if (isset($_POST['department_id'])) {
  $department_id = $_POST['department_id'];
  $sql = "SELECT * FROM department WHERE department_id = '$department_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
?>
      <div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confiture Department ID: <?php echo $row['department_id']; ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="department_id" value="<?php echo $row['department_id']; ?>">
                <!-- Department Name -->
                <div class="input-group mb-3">
                  <span class="input-group-text">
                    <i class="bi bi-diagram-3"></i>
                  </span>
                  <div class="form-floating flex-grow-1">
                    <input type="text" class="form-control" id="department_name" name="department_name" placeholder="Department Name" value="<?php echo $row['department_name'] ?>" required>
                    <label for="department_name">
                      Department Name <span class="text-danger">*</span>
                    </label>
                  </div>
                </div>

                <!-- Department Description (Optional) -->
                <div class="input-group mb-3">
                  <span class="input-group-text">
                    <i class="bi bi-card-text"></i>
                  </span>
                  <div class="form-floating flex-grow-1">
                    <!-- Do not edit the lining of the textarea, the value of it will have newlines (Spaces) -->
                    <textarea class="form-control"
                      id="department_description"
                      name="department_description"
                      placeholder="Department Description"
                      style="height: 100px"><?php echo htmlspecialchars($row['department_description'] ?? ''); ?></textarea>

                    <label for="department_description">
                      Department Description <span class="text-muted">(Optional)</span>
                    </label>
                  </div>
                </div>

                <!-- Add a hidden input field to submit the form with the button click -->
                <input type="hidden" name="edit_department" value="1">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn btn-danger" data-bs-dismiss="modal">Close</button>
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
  // Function for connecting to backend real time.
  $(document).ready(function() {
    $('#editDepartmentModal form').submit(function(event) {
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
        url: '/lakan/controllers/edit_department_process.php',
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

            $('#editDepartmentModal').modal('hide');
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
            text: "Error occurred while editing supplier. Please try again later.",
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
    $('#department_table').DataTable().ajax.reload(null, false);
  }
</script>