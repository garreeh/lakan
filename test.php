<?php
include './../connections/connections.php';

if (!isset($_GET['customer_id'])) {
  exit();
}

$customer_id = (int) $_GET['customer_id'];

/* =========================
   CUSTOMER MAIN DATA
========================= */
$sql = "SELECT *
        FROM customer
        LEFT JOIN membership_type 
          ON customer.membership_type_id = membership_type.membership_type_id
        WHERE customer.customer_id = $customer_id
        LIMIT 1";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
  echo "<div class='text-danger'>Customer not found</div>";
  exit();
}

$row = mysqli_fetch_assoc($result);

$remaining = (float) $row['remaining_balance'];
$remainingMonths = (int) $row['months_term_remaining'];
$monthly = ($remainingMonths > 0) ? $remaining / $remainingMonths : 0;

/* =========================
   OPTIMIZED HISTORY QUERY (JOIN ONLY)
========================= */
$history_sql = "
SELECT 
    mh.membership_history_id,
    mh.start_date,
    mh.end_date,
    dprh.payment_amount,
    dprh.created_at
FROM membership_history mh
LEFT JOIN downpayment_record_history dprh
    ON mh.membership_history_id = dprh.membership_history_id
    AND mh.customer_id = dprh.customer_id
WHERE mh.customer_id = $customer_id
ORDER BY mh.membership_history_id DESC, dprh.created_at ASC
";

$history_result = mysqli_query($conn, $history_sql);

/* =========================
   GROUP DATA
========================= */
$history = [];

if ($history_result) {
  while ($r = mysqli_fetch_assoc($history_result)) {

    $hid = $r['membership_history_id'];

    if (!isset($history[$hid])) {
      $history[$hid] = [
        'start_date' => $r['start_date'],
        'end_date' => $r['end_date'],
        'payments' => []
      ];
    }

    if ($r['payment_amount'] !== null) {
      $history[$hid]['payments'][] = [
        'amount' => (float) $r['payment_amount'],
        'date' => $r['created_at']
      ];
    }
  }
}
?>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="HistoryPaymentsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header">
        <h5 class="modal-title">
          Member ID: <?php echo $row['customer_id']; ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- BODY -->
      <div class="modal-body">

        <!-- ================= CURRENT STATUS ================= -->
        <div class="mb-3">
          <label class="form-label">Next Payment</label>

          <div class="input-group">
            <span class="input-group-text">
              <i class="bi bi-cash"></i>
            </span>

            <input type="text" class="form-control" value="<?php echo number_format($monthly, 2); ?>" readonly>
          </div>

          <hr>

          <small class="text-muted d-block">
            Remaining Balance: ₱ <?php echo number_format($remaining, 2); ?>
          </small>

          <small class="text-muted d-block">
            Remaining Terms:
            <?php echo $remainingMonths . ' Month' . ($remainingMonths > 1 ? 's' : ''); ?>
          </small>
        </div>

        <!-- ================= HISTORY ================= -->
        <h6 class="mb-3">
          <i class="bi bi-clock-history"></i> Payment History
        </h6>

        <?php if (!empty($history)): ?>

          <?php foreach ($history as $hid => $h): ?>

            <?php $total = 0; ?>

            <div class="border rounded p-3 mb-3">

              <div class="mb-2">
                <strong>Subscription #<?php echo $hid; ?></strong><br>

                <small class="text-muted">
                  <?php echo $h['start_date']; ?>
                  →
                  <?php echo $h['end_date']; ?>
                </small>
              </div>

              <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">

                  <thead class="table-light">
                    <tr>
                      <th>Date</th>
                      <th class="text-end">Amount</th>
                    </tr>
                  </thead>

                  <tbody>

                    <?php if (!empty($h['payments'])): ?>

                      <?php foreach ($h['payments'] as $p): ?>
                        <?php $total += $p['amount']; ?>

                        <tr>
                          <td><?php echo $p['date'] ?? '-'; ?></td>
                          <td class="text-end">
                            ₱ <?php echo number_format($p['amount'], 2); ?>
                          </td>
                        </tr>

                      <?php endforeach; ?>

                      <tr class="table-secondary fw-bold">
                        <td>Total</td>
                        <td class="text-end">
                          ₱ <?php echo number_format($total, 2); ?>
                        </td>
                      </tr>

                    <?php else: ?>

                      <tr>
                        <td colspan="2" class="text-center text-muted">
                          No payments found
                        </td>
                      </tr>

                    <?php endif; ?>

                  </tbody>

                </table>
              </div>
            </div>

          <?php endforeach; ?>

        <?php else: ?>

          <div class="text-center text-muted">
            No membership history found
          </div>

        <?php endif; ?>

      </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>