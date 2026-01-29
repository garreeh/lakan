<div class="modal fade" id="addMembershipModal" tabindex="-1" role="dialog" aria-labelledby="addMembershipModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-l" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMembershipModalLabel">Create Membership Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-row">
            <!-- Membership Type Name -->
            <div class="input-group mb-3">
              <span class="input-group-text">
                <i class="bi bi-blockquote-left"></i>
              </span>
              <div class="form-floating flex-grow-1">
                <input type="text" class="form-control" id="membership_type_name" name="membership_type_name" placeholder=" Membership Type Name" required>
                <label for="membership_type_name">
                  Membership Type Name <span class="text-danger">*</span>
                </label>
              </div>
            </div>

            <!-- Membership Type Price -->
            <div class="input-group mb-3">
              <span class="input-group-text">
                <i class="bi bi-cash"></i>
              </span>
              <div class="form-floating flex-grow-1">
                <input type="text" class="form-control" id="membershiptype_price" name="membershiptype_price" placeholder="Membership Type Price" required>
                <label for="membershiptype_price">
                  Membership Type Price <span class="text-danger">*</span>
                </label>
              </div>
            </div>

            <!-- Membership Type Description (Optional) -->
            <div class="input-group mb-3">
              <span class="input-group-text">
                <i class="bi bi-card-text"></i>
              </span>
              <div class="form-floating flex-grow-1">
                <textarea class="form-control" id="membership_type_description" name="membership_type_description" placeholder="Membership Type Description" style="height: 100px"></textarea>
                <label for="membership_type_description">
                  Membership Type Description <span class="text-muted">(Optional)</span>
                </label>
              </div>
            </div>

          </div>
          <input type="hidden" name="add_membership_type" value="1">
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
    const priceInput = document.getElementById('membershiptype_price');

    priceInput.addEventListener('input', function() {
      // Remove any non-digit characters
      this.value = this.value.replace(/[^0-9]/g, '');
    });
  });

  document.addEventListener("DOMContentLoaded", function() {
    // Initialize Bootstrap 5 modal object
    const addMembershipModalEl = document.getElementById('addMembershipModal');
    const addMembershipModal = new bootstrap.Modal(addMembershipModalEl);

    const form = addMembershipModalEl.querySelector('form');
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
        url: '/lakan/controllers/add_membership_type_process.php',
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
              addMembershipModal.hide();

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