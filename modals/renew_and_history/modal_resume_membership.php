<?php
include './../connections/connections.php';

if (isset($_GET['customer_id'])) {
  $customer_id = $_GET['customer_id'];
  $sql = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="modal fade" id="membershipResumeModal" tabindex="-1" role="dialog" aria-labelledby="membershipResumeModal"
        aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="membershipResumeModal">
                Resume Subscription for
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
                  <input type="hidden" name="start_date_membership" value="<?php echo $row['start_date_membership']; ?>">
                  <input type="hidden" name="end_date_membership" value="<?php echo $row['end_date_membership']; ?>">


                  <!-- Start Date Membership -->
                  <div class="input-group mb-3" id="startDateWrapper">
                    <span class="input-group-text">
                      <i class="bi bi-calendar-event"></i>
                    </span>
                    <div class="form-floating flex-grow-1">
                      <input type="date" class="form-control" id="date_resumed" name="date_resumed" required>
                      <label for="date_resumed">
                        Resume Date <span class="text-danger">*</span>
                      </label>
                    </div>
                  </div>

                </div>
                <br>

                <input type="hidden" name="resume_membership" value="1">
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
    const membershipResumeModalEl = document.getElementById('membershipResumeModal');
    const membershipResumeModal = new bootstrap.Modal(membershipResumeModalEl);
    const form = membershipResumeModalEl.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      // Disable button and show spinner
      submitBtn.disabled = true;
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...`;

      const formData = $(form).serialize();

      $.ajax({
        type: 'POST',
        url: '/lakan/controllers/resume_membership_process.php',
        data: formData,
        success: function (response) {
          let res = response;

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
              return;
            }
          }

          if (res.success) {
            Toastify({
              text: res.message || "Membership resumed successfully.",
              duration: 3000,
              close: true,
              gravity: "top",
              position: "right",
              backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
            }).showToast();

            // ✅ Use backend returned new_end_date and original_start_date
            updateMembershipDatesLive({
              customer_id: form.customer_id.value,
              start_date_membership: res.original_start_date, // keep original
              end_date_membership: res.new_end_date // calculated by backend
            });

            showPauseButton(); // toggle buttons

            form.reset();
            membershipResumeModal.hide();
          } else {
            Toastify({
              text: res.message || "Failed to resume membership.",
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

    // Update dates live in table
    function updateMembershipDatesLive(data) {
      if (!data || !data.customer_id) return;

      function formatFullDate(dateString) {
        const date = new Date(dateString);
        if (isNaN(date)) return dateString;
        return date.toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
      }

      function setText(id, value, extraClass = '') {
        const el = document.getElementById(id);
        if (el) {
          el.textContent = value;
          if (extraClass) el.className = extraClass;
        }
      }

      setText(`start_date_${data.customer_id}`, data.start_date_membership ? formatFullDate(data.start_date_membership) : 'N/A', 'fw-bold');
      setText(`end_date_${data.customer_id}`, data.end_date_membership ? formatFullDate(data.end_date_membership) : 'Unassigned', 'fw-bold text-danger');
    }
  });
</script>