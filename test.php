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
      <div class="modal fade" id="modifySubscriptionModal" tabindex="-1" role="dialog"
        aria-labelledby="modifySubscriptionModal" aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <!-- Header -->
            <div class="modal-header bg-dark text-white">
              <h5 class="modal-title" id="modifySubscriptionModalLabel">
                <i class="bi bi-pencil-square me-2"></i>
                Manage Subscription
              </h5>

              <button type="button" class="btn-close btn-close-white" data_modify-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data_modify">
                <div class="form-row">

                  <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">

                  <!-- Membership Type -->
                  <div class="input-group mb-3">

                    <!-- It has style because of the Selectize -->
                    <span class="input-group-text" style="height: 34px !important;">
                      <i class="bi bi-collection"></i>
                    </span>

                    <select class="form-control" id="membership_type_id" name="membership_type_id" required>

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

                      <input type="date" class="form-control" id="start_date_membership" name="start_date_membership"
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

                      <input type="date" class="form-control" id="end_date_membership" name="end_date_membership"
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
                <div class="input-group mb-3" id="downPaymentWrapper_modify" style="display:none;">

                  <span class="input-group-text">
                    <i class="bi bi-cash-stack"></i>
                  </span>

                  <div class="form-floating flex-grow-1">

                    <input type="text" class="form-control" id="down_payment_amount_modify" inputmode="numeric" autocomplete="off" placeholder="">

                    <label for="down_payment_amount_modify"> Down Payment Amount <span class="text-danger">*</span> </label>

                  </div>

                  <input type="hidden" id="down_payment_amount_raw_modify" name="down_payment_amount">
                </div>

                <!-- Payment Terms -->
                <div class="input-group mb-3" id="paymentTermsWrapper_modify" style="display:none;">

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

                <input type="hidden" name="renew_membership" value="1">
                <!-- Modal Footer Buttons -->
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="button" class="btn btn-secondary" data_modify-bs-dismiss="modal">Close</button>
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
  const membershipSelectizeModify = $('#membership_type_id')[0].selectize;

  const startInputModify = document.getElementById('start_date_membership');
  const endInputModify = document.getElementById('end_date_membership');

  const startWrapperModify = document.getElementById('startDateWrapper_modify');
  const endWrapperModify = document.getElementById('endDateWrapper_modify');

  const paymentTypeWrapperModify = document.getElementById('paymentTermsWrapper_modify');
  const paymentTypeSelectModify = document.getElementById('payment_type_modify');

  const paymentTypeSelectizeModify = $('#payment_type_modify')[0]?.selectize;

  const discountInputModify = document.getElementById('discount_modify'); // if exists

  $(document).ready(function () {

    let paymentTypeModify = $('#payment_type_modify').val();

    if (paymentTypeModify === 'Downpayment') {
      $('#downPaymentWrapper_modify').show();
      $('#paymentTermsWrapper_modify').show();
    } else {
      $('#downPaymentWrapper_modify').hide();
      $('#paymentTermsWrapper_modify').hide();
    }

    $('#payment_type_modify').on('change', function () {

      let paymentTypeModify = $(this).val();

      if (paymentTypeModify === 'Downpayment') {

        $('#downPaymentWrapper_modify').show();
        $('#paymentTermsWrapper_modify').show();

      } else {

        $('#downPaymentWrapper_modify').hide();
        $('#paymentTermsWrapper_modify').hide();

        // RESET VALUES
        $('#down_payment_amount_modify').val('');
        $('#down_payment_amount_raw_modify').val('');
        $('#payment_terms_modify').val('');
      }

    });

  });

  $(document).ready(function () {

    const membershipSelectizeModify = $('#membership_type_id')[0].selectize;

    function calculateEndDateModify() {

      const startDateModify = $('#start_date_membership').val();
      let durationMonthsModify = 0;

      const selectedValueModify = membershipSelectizeModify.getValue();

      if (selectedValueModify && membershipSelectizeModify.options[selectedValueModify]) {

        const selectedTextModify =
          membershipSelectizeModify.options[selectedValueModify].text.trim().toUpperCase();

        if (selectedTextModify.includes('VIP')) {
          $('#end_date_membership').val('');
          return;
        }

        const monthMatchModify = selectedTextModify.match(/(\d+)\s*MONTH/);
        durationMonthsModify = monthMatchModify ? parseInt(monthMatchModify[1]) : 0;
      }

      if (!startDateModify || durationMonthsModify <= 0) {
        $('#end_date_membership').val('');
        return;
      }

      const startModify = new Date(startDateModify);
      const endModify = new Date(startModify);

      endModify.setMonth(endModify.getMonth() + durationMonthsModify);

      const yyyy = endModify.getFullYear();
      const mm = String(endModify.getMonth() + 1).padStart(2, '0');
      const dd = String(endModify.getDate()).padStart(2, '0');

      $('#end_date_membership').val(`${yyyy}-${mm}-${dd}`);
    }

    // ✅ THIS IS THE FIX YOU ARE MISSING
    $('#start_date_membership').on('change input', function () {
      calculateEndDateModify();
    });

    membershipSelectizeModify.on('change', function () {
      calculateEndDateModify();
    });

    // ✅ RUN ON LOAD (EDIT MODE FIX)
    setTimeout(() => {
      calculateEndDateModify();
    }, 300);

  });
    

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

    function resetPaymentFields() {
      paymentTypeSelectize.clear();
      downPaymentInput.value = '';
      paymentTermsInput.value = '';

      downPaymentWrapper.style.display = 'none';
      paymentTermsWrapper.style.display = 'none';
    }

    function handleMembershipRequirement() {
      const membershipValue = membershipSelectize.getValue();

      if (!membershipValue) {
        paymentTypeSelectize.disable();
        resetPaymentFields();
      } else {
        paymentTypeSelectize.enable();
      }
    }

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

    startInput.addEventListener('change', updateEndDate);

    membershipSelectize.on('change', function () {
      updateEndDate();
      handleMembershipRequirement();
    });

    paymentTypeSelectize.on('change', handlePaymentType);

    // ===============================
    // INITIAL STATE
    // ===============================
    handleMembershipRequirement();
    updateEndDate();
    handlePaymentType();
  });

  // API
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

      // Serialize form data_modify using jQuery
      const formData = $(form).serialize();

      $.ajax({
        type: 'POST',
        url: '/lakan/controllers/renew_membership_process.php',
        data_modify: formData,
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
            text: "Error occurred while adding data_modify. Please try again later.",
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

</script>