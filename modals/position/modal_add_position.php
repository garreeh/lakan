<div class="modal fade" id="addPositionModal" tabindex="-1" role="dialog" aria-labelledby="addPositionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-l" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPositionModalLabel">Create Position</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-row">
            <!-- Position Name -->
            <div class="input-group mb-3">
              <span class="input-group-text">
                <i class="bi bi-diagram-3"></i>
              </span>
              <div class="form-floating flex-grow-1">
                <input type="text" class="form-control" id="position_name" name="position_name" placeholder="Position Name" required>
                <label for="position_name">
                  Position Name <span class="text-danger">*</span>
                </label>
              </div>
            </div>

            <!-- Position Description (Optional) -->
            <div class="input-group mb-3">
              <span class="input-group-text">
                <i class="bi bi-card-text"></i>
              </span>
              <div class="form-floating flex-grow-1">
                <textarea class="form-control" id="position_description" name="position_description" placeholder="Position Description" style="height: 100px"></textarea>
                <label for="position_description">
                  Position Description <span class="text-muted">(Optional)</span>
                </label>
              </div>
            </div>

          </div>
          <input type="hidden" name="add_position" value="1">
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
    const addPositionModalEl = document.getElementById('addPositionModal');
    const addPositionModal = new bootstrap.Modal(addPositionModalEl);

    const form = addPositionModalEl.querySelector('form');
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
        url: '/lakan/controllers/add_position_process.php',
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
              addPositionModal.hide();

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