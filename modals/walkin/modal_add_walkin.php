<style>
  .auto-field {
    color: #6c757d !important;
  }
</style>
<div class="modal fade" id="addWalkInModal" tabindex="-1" role="dialog" aria-labelledby="addWalkInModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-l" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addWalkInModalLabel">Add Walk In</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-row">
            <!-- Walk-in Type -->
            <div class="form-floating mb-3">
              <select class="form-select" id="walk_in_type" name="walk_in_type" required>
                <option value="" disabled selected>Select Walk-in Type</option>
                <option value="Member" data-price="150">Member</option>
                <option value="Non Member" data-price="180">Non Member</option>
                <option value="Student" data-price="150">Student</option>
              </select>
              <label for="walk_in_type">Walk-In Type <span class="text-danger">*</span></label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control auto-field" id="walk_in_price" name="walk_in_price"
                value="Automatically filled based on selection" readonly required>
              <label for="walk_in_price">Walk-In Price</label>
            </div>

            <!-- Name of walk-in optional -->
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="walk_in_name" name="walk_in_name">
              <label for="walk_in_name">Walk-In Name (Optional)</label>
            </div>

          </div>
          <input type="hidden" name="add_walkin_rates" value="1">
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
  const walkinType = document.getElementById("walk_in_type");
  const walkinPrice = document.getElementById("walk_in_price");

  walkinType.addEventListener("change", function () {

    const selectedOption = this.options[this.selectedIndex];

    const type = selectedOption.value;
    const price = selectedOption.getAttribute("data-price");

    walkinPrice.value = price;

    // remove grey color when price appears
    walkinPrice.style.color = "#000";

    // values you can use
    console.log("Walk-in Type:", type);
    console.log("Walk-in Price:", price);

  });

  document.addEventListener("DOMContentLoaded", function () {
    // Initialize Bootstrap 5 modal object
    const addWalkInModalEl = document.getElementById('addWalkInModal');
    const addWalkInModal = new bootstrap.Modal(addWalkInModalEl);

    const form = addWalkInModalEl.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      // Disable button and show spinner
      submitBtn.disabled = true;
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...`;

      // Serialize form data using jQuery (or FormData)
      const formData = $(form).serialize();

      $.ajax({
        type: 'POST',
        url: '/lakan/controllers/add_walk_in_rates_process.php',
        data: formData,
        success: function (response) {
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
              addWalkInModal.hide();

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
        error: function (xhr, status, error) {
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
        complete: function () {
          // Re-enable button and reset text
          submitBtn.disabled = false;
          submitBtn.innerHTML = "Submit";
        }
      });

    });

  });
</script>