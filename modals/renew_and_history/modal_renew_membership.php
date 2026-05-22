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

                  <!-- Membership Type -->
                  <div class="input-group mb-3">
                    <!-- It has style because of the Selectize -->
                    <span class="input-group-text" style="height: 34px !important;">
                      <i class="bi bi-collection"></i>
                    </span>

                    <select class="form-control" id="membership_type_id" name="membership_type_id" required readonly>
                      <option value="">Select New Membership Type <span class="text-danger">*</span></option>
                      <?php foreach ($membership_type_names as $membs): ?>
                        <option value="<?php echo htmlspecialchars($membs['membership_type_id']); ?>">
                          <?php echo htmlspecialchars($membs['membership_type_name']); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <!-- Start Date -->
                  <div class="input-group mb-3" id="startDateWrapper">
                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                    <div class="form-floating flex-grow-1">
                      <input type="date" class="form-control" id="start_date_membership" name="start_date_membership">
                      <label for="start_date_membership">
                        Start Date Subscription <span class="text-danger">*</span>
                      </label>
                    </div>
                  </div>

                  <!-- End Date -->
                  <div class="input-group mb-3" id="endDateWrapper">
                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                    <div class="form-floating flex-grow-1">
                      <input type="date" class="form-control" id="end_date_membership" name="end_date_membership" readonly>
                      <label for="end_date_membership">
                        End Date Subscription <span class="text-danger">*</span>
                      </label>
                    </div>
                  </div>

                  <!-- Payment Type -->
                  <div class="input-group mb-3">

                    <span class="input-group-text" style="height: 34px !important;">
                      <i class="bi bi-cash"></i>
                    </span>
                    <select class="form-control" id="payment_type" name="payment_type" required>
                      <option value="">Select Payment Type *</option>
                      <option value="Full Payment">Full Payment</option>
                      <option value="Downpayment">Down Payment</option>
                    </select>
                  </div>

                  <!-- Down Payment Amount -->
                  <div class="input-group mb-3" id="downPaymentWrapper" style="display:none;">
                    <span class="input-group-text">
                      <i class="bi bi-cash-stack"></i>
                    </span>

                    <div class="form-floating flex-grow-1">
                      <!-- DISPLAY VALUE -->
                      <input type="text" class="form-control" id="down_payment_amount" inputmode="numeric" autocomplete="off"
                        placeholder="">
                      <label for="down_payment_amount">Down Payment Amount <span class="text-danger">*</span></label>
                    </div>

                    <!-- RAW VALUE (THIS GETS SUBMITTED) -->
                    <input type="hidden" id="down_payment_amount_raw" name="down_payment_amount">
                  </div>

                  <!-- Payment Terms -->
                  <div class="input-group mb-3" id="paymentTermsWrapper" style="display:none;">
                    <span class="input-group-text" style="height: 34px !important;">
                      <i class="bi bi-calendar"></i>
                    </span>

                    <select class="form-control" id="payment_terms" name="payment_terms">
                      <option value="">Select Payment Terms *</option>
                      <option value="1 Month">1 Month</option>
                      <option value="2 Months">2 Months</option>
                      <option value="3 Months">3 Months</option>
                    </select>
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
    const discountInput = document.getElementById('discount');

    const membershipSelect = document.getElementById('membership_type_id');
    const paymentTypeSelect = document.getElementById('payment_type');

    const paymentTermsInput = document.getElementById('payment_terms');
    const downPaymentInput = document.getElementById('down_payment_amount');

    const paymentTypeWrapper = paymentTypeSelect.closest('.input-group');
    const downPaymentWrapper = document.getElementById('downPaymentWrapper');
    const paymentTermsWrapper = document.getElementById('paymentTermsWrapper');

    const startWrapper = document.getElementById('startDateWrapper');
    const endWrapper = document.getElementById('endDateWrapper');

    // Selectize
    const membershipSelectize = $(membershipSelect).selectize()[0].selectize;
    const paymentTypeSelectize = $(paymentTypeSelect).selectize()[0].selectize;

    // ===============================
    // RESET PAYMENT
    // ===============================
    function resetPaymentFields() {
      paymentTypeSelectize.clear();
      downPaymentInput.value = '';
      paymentTermsInput.value = '';

      downPaymentWrapper.style.display = 'none';
      paymentTermsWrapper.style.display = 'none';
    }

    // ===============================
    // MEMBERSHIP REQUIREMENT
    // ===============================
    function handleMembershipRequirement() {
      const membershipValue = membershipSelectize.getValue();

      if (!membershipValue) {
        paymentTypeSelectize.disable();
        resetPaymentFields();
      } else {
        paymentTypeSelectize.enable();
      }
    }

    // ===============================
    // GET MEMBERSHIP TEXT
    // ===============================
    // function getMembershipText() {
    //   const val = membershipSelectize.getValue();
    //   if (val && membershipSelectize.options[val]) {
    //     return membershipSelectize.options[val].text.trim();
    //   }
    //   return '';
    // }

    // ===============================
    // END DATE + VIP LOGIC
    // ===============================
    function updateEndDate() {
      const startDate = startInput.value;

      let durationMonths = 0;
      let discountPercent = 0;

      const selectedValue = membershipSelectize.getValue();

      if (selectedValue && membershipSelectize.options[selectedValue]) {
        const selectedText = membershipSelectize.options[selectedValue].text.trim().toUpperCase();

        // VIP
        if (selectedText === 'VIP') {
          startWrapper.style.display = 'none';
          endWrapper.style.display = 'none';

          startInput.value = '';
          endInput.value = '';
          if (discountInput) discountInput.value = '';

          paymentTypeWrapper.style.display = 'none';
          paymentTypeSelect.removeAttribute('required');

          paymentTypeSelectize.disable();
          resetPaymentFields();

          return;
        } else {
          startWrapper.style.display = 'flex';
          endWrapper.style.display = 'flex';

          paymentTypeWrapper.style.display = 'flex';
          paymentTypeSelect.setAttribute('required', 'required');

          handleMembershipRequirement();
        }

        // Extract months
        const monthMatch = selectedText.match(/(\d+)\s*MONTH/);
        durationMonths = monthMatch ? parseInt(monthMatch[1]) : 0;

        // Extract discount
        const discountMatch = selectedText.match(/\((\d+)%\)/);
        discountPercent = discountMatch ? parseInt(discountMatch[1]) : 0;

        if (discountInput) {
          discountInput.value = discountPercent > 0 ? discountPercent : '';
        }
      }

      if (!startDate || durationMonths <= 0) {
        endInput.value = '';
        return;
      }

      const start = new Date(startDate);
      const end = new Date(start);
      end.setMonth(end.getMonth() + durationMonths);

      const yyyy = end.getFullYear();
      const mm = String(end.getMonth() + 1).padStart(2, '0');
      const dd = String(end.getDate()).padStart(2, '0');

      endInput.value = `${yyyy}-${mm}-${dd}`;
    }

    // ===============================
    // PAYMENT TYPE LOGIC
    // ===============================
    function handlePaymentType() {
      const type = paymentTypeSelectize.getValue();

      if (type === 'Downpayment') {
        downPaymentWrapper.style.display = 'flex';
        paymentTermsWrapper.style.display = 'flex';

        // 🔥 AUTO-FILL PAYMENT TERMS FROM MEMBERSHIP
        // paymentTermsInput.value = getMembershipText();

      } else {
        downPaymentWrapper.style.display = 'none';
        paymentTermsWrapper.style.display = 'none';

        downPaymentInput.value = '';
        paymentTermsInput.value = '';
      }
    }

    // ===============================
    // EVENTS
    // ===============================
    startInput.addEventListener('change', updateEndDate);

    membershipSelectize.on('change', function () {
      updateEndDate();
      handleMembershipRequirement();

      // 🔥 Update payment terms if already in Downpayment PAY
      // if (paymentTypeSelectize.getValue() === 'Downpayment') {
      //   paymentTermsInput.value = getMembershipText();
      // }
    });

    paymentTypeSelectize.on('change', handlePaymentType);

    // ===============================
    // INITIAL STATE
    // ===============================
    handleMembershipRequirement();
    updateEndDate();
    handlePaymentType();
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

  const downPaymentInput = document.getElementById('down_payment_amount');
  const downPaymentRaw = document.getElementById('down_payment_amount_raw');

  // Add commas
  function formatNumber(value) {
    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  // Remove commas
  function unformatNumber(value) {
    return value.replace(/,/g, '');
  }

  downPaymentInput.addEventListener('input', function (e) {
    let value = e.target.value;

    // Remove everything except numbers
    value = value.replace(/[^0-9]/g, '');

    // Save RAW value (no commas)
    downPaymentRaw.value = value;

    // Format for display
    e.target.value = value ? formatNumber(value) : '';
  });
</script>