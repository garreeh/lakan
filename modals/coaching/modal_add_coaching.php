<style>
  .auto-field {
    color: #6c757d !important;
  }
</style>

<div class="modal fade" id="addCoachingModal" tabindex="-1" role="dialog" aria-labelledby="addCoachingModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-l" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCoachingModalLabel">Add Coaching Session</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-row">
            <!-- Walk-in Type -->
            <div class="form-floating mb-3">
              <select class="form-select" id="coaching_type" name="coaching_type" required>
                <option value="" disabled selected>Select Coaching Type</option>
                <option value="Platinum" data-price="35500">⚪ Platinum</option>
                <option value="Gold" data-price="24700">🟡 Gold</option>
                <option value="Silver" data-price="11200">⚙️ Silver</option>
                <option value="Bronze" data-price="5500">🟤 Bronze</option>
                <option value="Single Session" data-price="500">🔵 Single Session</option>
                <option value="Bronze (Promo)" data-price="3000">🟤 Bronze (Promo)</option>
                <option value="Platinum (Promo)" data-price="18000">⚪ Platinum (Promo)</option>
                <option value="Gold (Promo)" data-price="13000">🟡 Gold (Promo)</option>
                <option value="Silver (Promo)" data-price="6000">⚙️ Silver (Promo)</option>
              </select>
              <label for="coaching_type">Coaching Type <span class="text-danger">*</span></label>
            </div>

            <!-- Display price -->
            <div class="form-floating mb-3">
              <input type="text" class="form-control auto-field" id="coaching_price_display"
                value="Automatically filled based on selection" readonly>
              <label for="coaching_price_display">Coaching Price</label>
            </div>

            <!-- Raw price sent to backend -->
            <input type="hidden" id="coaching_price" name="coaching_price">

            <!-- Name of walk-in optional -->
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="client_fullname" name="client_fullname" placeholder=""
                required>
              <label for="client_fullname">Client Name</label>
            </div>

          </div>
          <input type="hidden" name="add_coaching_rates" value="1">
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
  const coachingType = document.getElementById("coaching_type");
  const coachingPriceDisplay = document.getElementById("coaching_price_display");
  const coachingPrice = document.getElementById("coaching_price");

  coachingType.addEventListener("change", function () {

    const selectedOption = this.options[this.selectedIndex];
    const price = selectedOption.getAttribute("data-price");

    // Format for display
    const formattedPrice = Number(price).toLocaleString('en-PH', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });

    // Show formatted price
    coachingPriceDisplay.value = "₱ " + formattedPrice;

    // Save raw value
    coachingPrice.value = price;

  });

  document.addEventListener("DOMContentLoaded", function () {
    // Initialize Bootstrap 5 modal object
    const addCoachingModalEl = document.getElementById('addCoachingModal');
    const addCoachingModal = new bootstrap.Modal(addCoachingModalEl);

    const form = addCoachingModalEl.querySelector('form');
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
        url: '/lakan/controllers/add_coaching_rates_process.php',
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
              addCoachingModal.hide();

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