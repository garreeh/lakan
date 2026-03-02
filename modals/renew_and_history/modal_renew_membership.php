<?php
include './../connections/connections.php';

// Query for Department
$sql = "SELECT * FROM membership_type";
$resultMembershipType = mysqli_query($conn, $sql);

$membership_type_names = [];
if ($resultMembershipType) {
  while ($row = mysqli_fetch_assoc($resultMembershipType)) {
    $membership_type_names[] = $row;
  }
}

if (isset($_GET['customer_id'])) {
  $customer_id = $_GET['customer_id'];
  $sql = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="modal fade" id="renewMembershipModal" tabindex="-1" role="dialog" aria-labelledby="renewMembershipModal"
        aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="renewMembershipModal">
                Renew Membership for
                <?php
                echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                ?>
              </h5>


              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <div class="form-row">

                  <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">

                  <!-- Start Date Membership -->
                  <div class="input-group mb-3" id="startDateWrapper">
                    <span class="input-group-text">
                      <i class="bi bi-calendar-event"></i>
                    </span>
                    <div class="form-floating flex-grow-1">
                      <input type="date" class="form-control" id="start_date_membership" name="start_date_membership"
                        placeholder="Start Date" required>
                      <label for="start_date_membership">
                        New Start Date <span class="text-danger">*</span>
                      </label>
                    </div>
                  </div>

                  <!-- Membership Type -->
                  <div class="input-group mb-3">
                    <!-- It has style because of the Selectize -->
                    <span class="input-group-text" style="height: 34px !important;">
                      <i class="bi bi-collection"></i>
                    </span>

                    <select class="form-control" id="membership_type_id" name="membership_type_id" required>
                      <option value="">Select New Membership Type <span class="text-danger">*</span></option>
                      <?php foreach ($membership_type_names as $membs): ?>
                        <option value="<?php echo htmlspecialchars($membs['membership_type_id']); ?>">
                          <?php echo htmlspecialchars($membs['membership_type_name']); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <!-- End Date Membership -->
                  <div class="input-group mb-3" id="endDateWrapper">
                    <span class="input-group-text">
                      <i class="bi bi-calendar-event-fill"></i>
                    </span>
                    <div class="form-floating flex-grow-1">
                      <input type="date" class="form-control" id="end_date_membership" name="end_date_membership"
                        placeholder="End Date" required>
                      <label for="end_date_membership">
                        New End Date <span class="text-danger">*</span>
                      </label>
                    </div>
                  </div>

                </div>
                <br>
                <br>
                <br>

                <input type="hidden" name="renew_membership" value="1">
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
      <?php
    }
  }
}
?>

<!-- Include JS QUERY For AJAX-->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- Include Toastify JS -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
  // Hide VIP, and Auto Compute for the End Date Subs
  document.addEventListener('DOMContentLoaded', function () {
    const startInput = document.getElementById('start_date_membership');
    const endInput = document.getElementById('end_date_membership');
    const discountInput = document.getElementById('discount'); // optional: fill discount automatically
    const membershipSelect = document.getElementById('membership_type_id');
    const startWrapper = document.getElementById('startDateWrapper');
    const endWrapper = document.getElementById('endDateWrapper');

    // Initialize Selectize if not already
    const selectize = $(membershipSelect).selectize()[0].selectize;

    function updateEndDate() {
      const startDate = startInput.value;

      let durationMonths = 0;
      let discountPercent = 0;

      if (selectize) {
        const selectedValue = selectize.getValue();

        if (selectedValue && selectize.options[selectedValue]) {
          const selectedText = selectize.options[selectedValue].text.trim().toUpperCase();

          // Hide/show Start and End date for VIP
          if (selectedText === 'VIP') {
            startWrapper.style.display = 'none';
            endWrapper.style.display = 'none';
            startInput.value = '';
            endInput.value = '';
            if (discountInput) discountInput.value = '';
            return;
          } else {
            startWrapper.style.display = 'flex';
            endWrapper.style.display = 'flex';
          }

          // Extract months (first number in text)
          const monthMatch = selectedText.match(/(\d+)\s*MONTH/);
          durationMonths = monthMatch ? parseInt(monthMatch[1]) : 0;

          // Extract discount (number inside parentheses with %)
          const discountMatch = selectedText.match(/\((\d+)%\)/);
          discountPercent = discountMatch ? parseInt(discountMatch[1]) : 0;

          // Auto-fill discount input if exists
          if (discountInput) {
            discountInput.value = discountPercent > 0 ? discountPercent : '';
          }
        }
      }

      if (!startDate || durationMonths <= 0) {
        endInput.value = '';
        return;
      }

      // Compute end date
      const start = new Date(startDate);
      const end = new Date(start);
      end.setMonth(end.getMonth() + durationMonths);

      const yyyy = end.getFullYear();
      const mm = String(end.getMonth() + 1).padStart(2, '0');
      const dd = String(end.getDate()).padStart(2, '0');
      endInput.value = `${yyyy}-${mm}-${dd}`;
    }

    // Trigger when start date changes
    startInput.addEventListener('change', updateEndDate);

    // Trigger when membership type changes
    selectize.on('change', updateEndDate);

    // Run once on page load in case VIP is already selected
    updateEndDate();
  });


  document.addEventListener("DOMContentLoaded", function () {
    // Initialize Bootstrap 5 modal object
    const renewMembershipModalEl = document.getElementById('renewMembershipModal');
    const renewMembershipModal = new bootstrap.Modal(renewMembershipModalEl);

    const form = renewMembershipModalEl.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      // Disable button and show spinner
      submitBtn.disabled = true;
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...`;

      // Serialize form data using jQuery
      const formData = $(form).serialize();

      $.ajax({
        type: 'POST',
        url: '/lakan/controllers/renew_membership_process.php',
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

              // Call the standalone update function
              updateMembershipDatesLive({
                customer_id: form.customer_id.value,
                start_date_membership: form.start_date_membership.value,
                end_date_membership: form.end_date_membership.value
              });

              // Reset form
              form.reset();

              // Close modal
              renewMembershipModal.hide();

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
            text: "Error occurred while adding data. Please try again later.",
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
          submitBtn.innerHTML = originalText;
        }
      });
    });
  });

  // Update Renewal Live
  function updateMembershipDatesLive(data) {
    if (!data || !data.customer_id) return;

    // Helper to format date as "February 1, 2026"
    function formatFullDate(dateString) {
      const date = new Date(dateString);
      if (isNaN(date)) return dateString;
      const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      };
      return date.toLocaleDateString(undefined, options);
    }

    // Helper to set text content safely and apply classes
    function setText(id, value, extraClass = '') {
      const el = document.getElementById(id);
      if (el) {
        el.textContent = value;
        if (extraClass) el.className = extraClass;
      }
    }

    // Update Start Date
    setText(
      `start_date_${data.customer_id}`,
      data.start_date_membership ? formatFullDate(data.start_date_membership) : 'N/A',
      'fw-bold'
    );

    // Update End Date
    setText(
      `end_date_${data.customer_id}`,
      data.end_date_membership ? formatFullDate(data.end_date_membership) : 'Unassigned',
      'fw-bold text-danger'
    );
  }
</script>