<?php
include './../connections/connections.php';

if (isset($_GET['customer_id'])) {
  $customer_id = $_GET['customer_id'];
  $sql = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="modal fade" id="membershipPauseModal" tabindex="-1" role="dialog" aria-labelledby="membershipPauseModal"
        aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="membershipPauseModal">
                Pause Subscription for
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
                      <input type="date" class="form-control" id="date_paused" name="date_paused" required>
                      <label for="date_paused">
                        Pause Date <span class="text-danger">*</span>
                      </label>
                    </div>
                  </div>

                </div>
                <br>

                <input type="hidden" name="pause_membership" value="1">
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

  document.addEventListener("DOMContentLoaded", function () {
    // Initialize Bootstrap 5 modal object
    const membershipPauseModalEl = document.getElementById('membershipPauseModal');
    const membershipPauseModal = new bootstrap.Modal(membershipPauseModalEl);

    const form = membershipPauseModalEl.querySelector('form');
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
        url: '/lakan/controllers/pause_membership_process.php',
        data: formData,

        success: function (response) {

          let res = response;

          // ✅ If response is string, try to parse JSON safely
          if (typeof response === 'string') {
            try {
              res = JSON.parse(response);
            } catch (e) {
              console.error("Raw response:", response);

              Toastify({
                text: "Invalid response from server.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
              }).showToast();

              return; // stop execution
            }
          }

          // ✅ Now res is safe JSON
          if (res.success) {

            Toastify({
              text: res.message || "Membership paused successfully.",
              duration: 3000,
              close: true,
              gravity: "top",
              position: "right",
              backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
            }).showToast();

            // ✅ Call update function (removed end_date_membership because it doesn't exist)
            // updateMembershipDatesLive({
            //   customer_id: form.customer_id.value,
            //   date_paused: form.date_paused.value
            // });

            showResumeButton();

            // Reset form
            form.reset();

            // Close modal
            membershipPauseModal.hide();

          } else {

            Toastify({
              text: res.message || "Failed to pause membership.",
              duration: 3000,
              close: true,
              gravity: "top",
              position: "right",
              backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
            }).showToast();

          }
        },

        error: function (xhr, status, error) {
          console.error("XHR:", xhr.responseText);

          Toastify({
            text: "Error occurred while saving. Please try again.",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
          }).showToast();
        },

        complete: function () {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        }
      });

    });
  });

  // Update Renewal Live
  // function updateMembershipDatesLive(data) {
  //   if (!data || !data.customer_id) return;

  //   // Helper to format date as "February 1, 2026"
  //   function formatFullDate(dateString) {
  //     const date = new Date(dateString);
  //     if (isNaN(date)) return dateString;
  //     const options = {
  //       year: 'numeric',
  //       month: 'long',
  //       day: 'numeric'
  //     };
  //     return date.toLocaleDateString(undefined, options);
  //   }

  //   // Helper to set text content safely and apply classes
  //   function setText(id, value, extraClass = '') {
  //     const el = document.getElementById(id);
  //     if (el) {
  //       el.textContent = value;
  //       if (extraClass) el.className = extraClass;
  //     }
  //   }

  //   // Update Start Date
  //   setText(
  //     `start_date_${data.customer_id}`,
  //     data.date_paused ? formatFullDate(data.date_paused) : 'N/A',
  //     'fw-bold'
  //   );

  //   // Update End Date
  //   setText(
  //     `end_date_${data.customer_id}`,
  //     data.end_date_membership ? formatFullDate(data.end_date_membership) : 'Unassigned',
  //     'fw-bold text-danger'
  //   );
  // }


</script>