<?php
include './../connections/connections.php';

// Query for Membership Type
$sql = "SELECT * FROM membership_type";
$resultMembershipType = mysqli_query($conn, $sql);

$membership_type_names = [];

if ($resultMembershipType) {
  while ($row = mysqli_fetch_assoc($resultMembershipType)) {
    $membership_type_names[] = $row;
  }
}

if (isset($_GET['customer_id'])) {
  $customer_id = mysqli_real_escape_string($conn, $_GET['customer_id']);

  // GET CUSTOMER DETAILS
  $sql = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="modal fade" id="modifySubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="modifySubscriptionModal"
        aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modifySubscriptionModal">
                Manage Membership for
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

                    <select class="form-control" id="membership_type_id_modify" name="membership_type_id" required>

                      <option value=""> Select New Membership Type * </option>

                      <?php foreach ($membership_type_names as $membs): ?>

                        <option value="<?php echo htmlspecialchars($membs['membership_type_id']); ?>"
                          <?php echo ($row['membership_type_id'] == $membs['membership_type_id']) ? 'selected' : ''; ?>>

                          <?php echo htmlspecialchars($membs['membership_type_name']); ?>

                        </option>

                      <?php endforeach; ?>

                    </select>
                  </div>

                  <!-- Start Date -->
                  <div class="input-group mb-3" id="startDateWrapper_modify">
                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                    <div class="form-floating flex-grow-1">
                      <input type="date" class="form-control" id="start_date_membership_modify" name="start_date_membership"
                        value="<?php echo (!empty($row['start_date_membership'])) ? date('Y-m-d', strtotime($row['start_date_membership'])) : ''; ?>">
                      <label for="start_date_membership">
                        Start Date Subscription <span class="text-danger">*</span>
                      </label>
                    </div>
                  </div>

                  <!-- End Date -->
                  <div class="input-group mb-3" id="endDateWrapper_modify">
                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                    <div class="form-floating flex-grow-1">
                      <input type="date" class="form-control" id="end_date_membership_modify" name="end_date_membership"
                        value="<?php echo (!empty($row['end_date_membership'])) ? date('Y-m-d', strtotime($row['end_date_membership'])) : ''; ?>"
                        readonly>
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
                    <select class="form-control" id="payment_type_modify" name="payment_type" required>
                      <option value="">Select Payment Type *</option>
                      <option value="Full Payment" <?php echo ($row['payment_type'] == 'Full Payment') ? 'selected' : ''; ?>>
                        Full Payment
                      </option>
                      <option value="Downpayment" <?php echo ($row['payment_type'] == 'Downpayment') ? 'selected' : ''; ?>>
                        Down Payment
                      </option>
                    </select>
                  </div>

                  <!-- Down Payment Amount -->
                  <div class="input-group mb-3" id="downPaymentWrapperModify" style="display:none;">
                    <span class="input-group-text">
                      <i class="bi bi-cash-stack"></i>
                    </span>

                    <div class="form-floating flex-grow-1">
                      <!-- DISPLAY VALUE -->
                      <input type="text" class="form-control" id="down_payment_amount_modify" name="down_payment_amount" inputmode="numeric" autocomplete="off" placeholder=""
                            value="<?php echo !empty($row['down_payment_amount']) ? number_format($row['down_payment_amount']) : ''; ?>">

                      <label for="down_payment_amount_modify">
                        Down Payment Amount <span class="text-danger">*</span>
                      </label>
                    </div>

                    <!-- RAW VALUE (THIS GETS SUBMITTED) -->
                    <input type="hidden" id="down_payment_amount_raw_modify" name="down_payment_amount">
                  </div>

                  <!-- Payment Terms -->
                  <div class="input-group mb-3" id="paymentTermsWrapperModify" style="display:none;">
                    <span class="input-group-text" style="height: 34px !important;">
                      <i class="bi bi-calendar"></i>
                    </span>

                    <select class="form-control" id="payment_terms_modify" name="payment_terms">
                      <option value="">Select Payment Terms *</option>
                      <option value="1 Month" <?php echo ($row['payment_terms'] == '1 Month') ? 'selected' : ''; ?>>
                        1 Month
                      </option>
                      <option value="2 Months" <?php echo ($row['payment_terms'] == '2 Months') ? 'selected' : ''; ?>>
                        2 Months
                      </option>
                      <option value="3 Months" <?php echo ($row['payment_terms'] == '3 Months') ? 'selected' : ''; ?>>
                        3 Months
                      </option>
                    </select>
                  </div>


                </div>
                <br>
                <br>
                <br>

                <input type="hidden" name="manage_subscription" value="1">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Toastify JS -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
  // Hide VIP, and Auto Compute for the End Date Subs
  document.addEventListener('DOMContentLoaded', function () {
    const startInputModify = document.getElementById('start_date_membership_modify');
    const endInputModify = document.getElementById('end_date_membership_modify');

    const discountInputModify = document.getElementById('discount');

    const membershipSelectModify = document.getElementById('membership_type_id_modify');
    const paymentTypeSelectModify = document.getElementById('payment_type_modify');

    const paymentTermsInputModify = document.getElementById('payment_terms_modify');
    const downPaymentInputModify = document.getElementById('down_payment_amount_modify');

    const paymentTypeWrapperModify = paymentTypeSelectModify.closest('.input-group');
    const downPaymentWrapperModify = document.getElementById('downPaymentWrapperModify');
    const paymentTermsWrapperModify = document.getElementById('paymentTermsWrapperModify');

    const startWrapperModify = document.getElementById('startDateWrapper_modify');
    const endWrapperModify = document.getElementById('endDateWrapper_modify');

    // Selectize
    const membershipSelectizeModify = $(membershipSelectModify).selectize()[0].selectize;
    const paymentTypeSelectizeModify = $(paymentTypeSelectModify).selectize()[0].selectize;

    // Reset Payment Field
    function resetPaymentFields() {
      paymentTypeSelectizeModify.clear();
      downPaymentInputModify.value = '';
      paymentTermsInputModify.value = '';

      downPaymentWrapperModify.style.display = 'none';
      paymentTermsWrapperModify.style.display = 'none';
    }

    function handleMembershipRequirement() {
      const membershipValue = membershipSelectizeModify.getValue();

      if (!membershipValue) {
        paymentTypeSelectizeModify.disable();
        resetPaymentFields();
      } else {
        paymentTypeSelectizeModify.enable();
      }
    }
    // Working as of 05/23/2026 
    function updateEndDate() {
      // console.log("🔥 updateEndDate CALLED");

      const startDate = startInputModify.value;
      // console.log("📅 startDate:", startDate);

      let durationMonths = 0;
      let discountPercent = 0;

      const selectedValue = membershipSelectizeModify.getValue();
      // console.log("📦 selectedValue:", selectedValue);

      if (selectedValue && membershipSelectizeModify.options[selectedValue]) {

        const selectedText =
          membershipSelectizeModify.options[selectedValue].text.trim().toUpperCase();

          // console.log("🏷 selectedText:", selectedText);

        // VIP
        if (selectedText === 'VIP') {
          // console.log("⚠ VIP detected");

          startWrapperModify.style.display = 'none';
          endWrapperModify.style.display = 'none';

          startInputModify.value = '';
          endInputModify.value = '';

          if (discountInputModify) discountInputModify.value = '';

          paymentTypeWrapperModify.style.display = 'none';
          paymentTypeSelectModify.removeAttribute('required');

          paymentTypeSelectizeModify.disable();

          resetPaymentFields();

          // console.log("🧹 VIP cleanup done");
          return;

        } else {

          // console.log("✅ Non-VIP membership");

          startWrapperModify.style.display = 'flex';
          endWrapperModify.style.display = 'flex';

          paymentTypeWrapperModify.style.display = 'flex';
          paymentTypeSelectModify.setAttribute('required', 'required');

          handleMembershipRequirement();
        }

        // Extract months
        const monthMatch = selectedText.match(/(\d+)\s*MONTH/);
        durationMonths = monthMatch ? parseInt(monthMatch[1]) : 0;

        // console.log("📆 durationMonths:", durationMonths);

        // Extract discount
        const discountMatch = selectedText.match(/\((\d+)%\)/);
        discountPercent = discountMatch ? parseInt(discountMatch[1]) : 0;

        // console.log("💰 discountPercent:", discountPercent);

        if (discountInputModify) {
          discountInputModify.value = discountPercent > 0 ? discountPercent : '';
        }
      }

      if (!startDate || durationMonths <= 0) {
        // console.log("❌ BLOCKED: missing startDate or durationMonths");
        endInputModify.value = '';
        return;
      }

      const start = new Date(startDate);
      const end = new Date(start);
      end.setMonth(end.getMonth() + durationMonths);

      // console.log("🧠 computed date object:", end);

      const yyyy = end.getFullYear();
      const mm = String(end.getMonth() + 1).padStart(2, '0');
      const dd = String(end.getDate()).padStart(2, '0');

      const finalDate = `${yyyy}-${mm}-${dd}`;

      // console.log("📌 FINAL end date:", finalDate);

      endInputModify.value = finalDate;
    }

    startInputModify.addEventListener('change', function () {
      // console.log("📅 startInputModify CHANGED:", this.value);
      updateEndDate();
    });

    membershipSelectizeModify.on('change', function () {
      // console.log("📦 membership changed");
      updateEndDate();
      handleMembershipRequirement();
    });

    updateEndDate();

    // Choose if Downpayment or Fullpayment
    function handlePaymentType() {
      const type = paymentTypeSelectizeModify.getValue();

      if (type === 'Downpayment') {
        downPaymentWrapperModify.style.display = 'flex';
        paymentTermsWrapperModify.style.display = 'flex';
      } else {
        downPaymentWrapperModify.style.display = 'none';
        paymentTermsWrapperModify.style.display = 'none';

        downPaymentInputModify.value = '';
        paymentTermsInputModify.value = '';
      }
    }

    paymentTypeSelectizeModify.on('change', handlePaymentType);

    handleMembershipRequirement();
    handlePaymentType();
  });


  document.addEventListener("DOMContentLoaded", function () {
    // Initialize Bootstrap 5 modal object
    const renewMembershipModalEl = document.getElementById('modifySubscriptionModal');
    const modifySubscriptionModal = new bootstrap.Modal(renewMembershipModalEl);

    const form = renewMembershipModalEl.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      // Disable button and show spinner
      submitBtn.disabled = true;
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...`;

      // Serialize form data_modify using jQuery
      const formData = $(form).serialize();

      $.ajax({
        type: 'POST',
        url: '/lakan/controllers/manage_subscription_process.php',
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
              updateMembershipDatesLiveModify({
                customer_id: form.customer_id.value,
                start_date_membership: form.start_date_membership.value,
                end_date_membership: form.end_date_membership.value
              });

              // Reset form
              form.reset();

              // Close modal
              modifySubscriptionModal.hide();

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
  function updateMembershipDatesLiveModify(data_modify) {
    if (!data_modify || !data_modify.customer_id) return;

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
      `start_date_${data_modify.customer_id}`,
      data_modify.start_date_membership ? formatFullDate(data_modify.start_date_membership) : 'N/A',
      'fw-bold'
    );

    // Update End Date
    setText(
      `end_date_${data_modify.customer_id}`,
      data_modify.end_date_membership ? formatFullDate(data_modify.end_date_membership) : 'Unassigned',
      'fw-bold text-danger'
    );
  }

  const downPaymentInputModify = document.getElementById('down_payment_amount_modify');
  const downPaymentRawModify = document.getElementById('down_payment_amount_raw_modify');

  // Add commas for discount raw display front-end
  function formatNumber(value) {
    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  // Remove commas for discount backend db when saving
  function unformatNumber(value) {
    return value.replace(/,/g, '');
  }


  // Avoid inputting letters, only numbers
  downPaymentInputModify.addEventListener('input', function (e) {
    let value = e.target.value;

    // Remove everything except numbers
    value = value.replace(/[^0-9]/g, '');

    // Save RAW value (no commas)
    downPaymentRawModify.value = value;

    // Format for display
    e.target.value = value ? formatNumber(value) : '';
  });

</script>