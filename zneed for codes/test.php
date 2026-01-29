<div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-l" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDepartmentModalLabel">Create Department</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-row">
            <!-- Department Name -->
            <div class="input-group mb-3">
              <span class="input-group-text">
                <i class="bi bi-diagram-3"></i>
              </span>
              <div class="form-floating flex-grow-1">
                <input type="text" class="form-control" id="department_name" name="department_name" placeholder="Department Name" required>
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
              <div class="form-floating mb-3">
                <textarea class="form-control"
                  id="department_description"
                  name="department_description"
                  placeholder="Department Description"
                  style="height: 120px"></textarea>

                <label for="department_description">
                  Department Description <span class="text-muted">(Optional)</span>
                </label>
              </div>
            </div>

          </div>
          <input type="hidden" name="add_department" value="1">
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
  document.addEventListener('DOMContentLoaded', function() {

    // FORCE ENABLE (prevents read-only issue)
    const textarea = document.getElementById('department_description');
    textarea.disabled = false;
    textarea.readOnly = false;

    tinymce.init({
      selector: '#department_description',
      height: 200,
      menubar: false,
      plugins: 'lists link',
      toolbar: 'undo redo | bold italic underline | bullist numlist | link',
      branding: false,
      readonly: false
    });

  });

  document.addEventListener("DOMContentLoaded", function() {

    // Initialize Bootstrap 5 modal object
    const addDepartmentModalEl = document.getElementById('addDepartmentModal');
    const addDepartmentModal = new bootstrap.Modal(addDepartmentModalEl);

    const form = addDepartmentModalEl.querySelector('form');
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
        url: '/lakan/controllers/add_department_process.php',
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
              addDepartmentModal.hide();

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



<!-- WITH TINYMCE INLINE EDITOR ALSO THIS IS A MODAL -->