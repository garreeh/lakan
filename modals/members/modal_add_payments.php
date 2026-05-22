<?php
include './../connections/connections.php';

if (isset($_GET['customer_id'])) {

  $customer_id = (int) $_GET['customer_id'];

  $sql = "SELECT * FROM customer
          LEFT JOIN membership_type 
            ON customer.membership_type_id = membership_type.membership_type_id
          WHERE customer.customer_id = $customer_id";

  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {

      $remaining = (float) $row['remaining_balance'];
      $remainingMonths = (int) $row['months_term_remaining'];
      $monthly = ($remainingMonths > 0) ? $remaining / $remainingMonths : 0;
      ?>

      <!-- ================= MODAL ================= -->
      <div class="modal fade" id="addPaymentsModal" data-customer-id="<?php echo $row['customer_id']; ?>"
        data-remaining="<?php echo $remaining; ?>" data-months="<?php echo $remainingMonths; ?>" tabindex="-1">

        <div class="modal-dialog modal-l">
          <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
              <h5 class="modal-title">
                Configure Member ID: <?php echo $row['customer_id']; ?>
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

              <form id="paymentForm">

                <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">
                <input type="hidden" name="add_payment" value="1">

                <div class="mb-3">

                  <label class="form-label">Update Payment</label>

                  <div class="input-group">
                    <span class="input-group-text">
                      <i class="bi bi-cash"></i>
                    </span>

                    <input type="text" class="form-control" id="payment_amount" name="payment_amount"
                      value="<?php echo number_format($monthly, 2); ?>" readonly>
                  </div>

                  <hr>

                  <small class="text-muted d-block" id="ui_remaining_balance">
                    Remaining Balance: ₱ <?php echo number_format($remaining, 2); ?>
                  </small>

                  <small class="text-muted d-block" id="ui_remaining_months">
                    Remaining Terms:
                    <?php echo $remainingMonths . ' Month' . ($remainingMonths > 1 ? 's' : ''); ?>
                  </small>

                </div>

                <div class="modal-footer">
                  <button class="btn btn-primary" type="submit" id="submitBtn">Save</button>
                  <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Close</button>
                </div>

              </form>

            </div>
          </div>
        </div>
      </div>

      <!-- ================= SCRIPTS ================= -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

      <script>

        // ================= FORMAT =================
        function formatPeso(val) {
          return '₱ ' + parseFloat(val || 0)
            .toLocaleString(undefined, { minimumFractionDigits: 2 });
        }

        function formatMonths(m) {
          return m + ' Month' + (m > 1 ? 's' : '');
        }

        // ================= CENTRAL UPDATE =================
        function updateUI(data) {

          const id = data.customer_id;

          // PAGE ELEMENTS
          const remainingEl = document.getElementById(`remaining_balance_${id}`);
          if (remainingEl) {
            remainingEl.textContent = formatPeso(data.remaining_balance);
          }

          const monthsEl = document.getElementById(`months_term_remaining_${id}`);
          if (monthsEl) {
            monthsEl.textContent = formatMonths(data.months_term_remaining);
          }

          const monthlyEl = document.getElementById(`monthly_payment_${id}`);
          if (monthlyEl) {
            monthlyEl.textContent = formatPeso(data.monthly_payment);
          }

          // MODAL LIVE UPDATE
          document.getElementById('ui_remaining_balance').textContent =
            "Remaining Balance: " + formatPeso(data.remaining_balance);

          document.getElementById('ui_remaining_months').textContent =
            "Remaining Terms: " + formatMonths(data.months_term_remaining);

          document.getElementById('payment_amount').value =
            parseFloat(data.monthly_payment).toFixed(2);

          // 🔥 UPDATE MODAL CACHE (IMPORTANT FIX)
          const modal = document.getElementById('addPaymentsModal');
          modal.dataset.remaining = data.remaining_balance;
          modal.dataset.months = data.months_term_remaining;
        }

        // ================= SUBMIT =================
        $(document).ready(function () {

          $('#paymentForm').submit(function (e) {
            e.preventDefault();

            let btn = $('#submitBtn');
            let original = btn.html();

            btn.prop('disabled', true).html('Saving...');

            $.ajax({
              type: 'POST',
              url: '/lakan/controllers/add_payment_process.php',
              data: new FormData(this),
              processData: false,
              contentType: false,
              dataType: 'json',

              success: function (res) {

                if (res.success) {

                  Toastify({
                    text: res.message,
                    duration: 2000,
                    close: true,
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
                  }).showToast();

                  $('#addPaymentsModal').modal('hide');

                  updateUI(res);

                } else {

                  Toastify({
                    text: res.message,
                    duration: 2000,
                    close: true,
                    backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
                  }).showToast();
                }
              },

              complete: function () {
                btn.prop('disabled', false).html(original);
              }
            });
          });

          // ================= FIX MODAL REOPEN =================
          $('#addPaymentsModal').on('show.bs.modal', function () {

            const m = this;

            const remaining = parseFloat(m.dataset.remaining || 0);
            const months = parseInt(m.dataset.months || 0);

            const monthly = months > 0 ? remaining / months : 0;

            document.getElementById('ui_remaining_balance').textContent =
              "Remaining Balance: " + formatPeso(remaining);

            document.getElementById('ui_remaining_months').textContent =
              "Remaining Terms: " + formatMonths(months);

            document.getElementById('payment_amount').value =
              monthly.toFixed(2);
          });

        });

      </script>

      <?php
    }
  }
}
?>