<!-- =========================
     MODAL UI
========================= -->
<div class="modal fade" id="HistoryPaymentsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          Payment History (Per Subscription) for Member ID: <?php echo $data['customer_id'] ?? '-'; ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <?php if (!empty($groupedPayments)): ?>

          <?php foreach ($groupedPayments as $group): ?>

            <div class="mt-4 mb-2 fw-bold text-primary">
              Subscription Start:
              <?php echo date("Y-m-d", strtotime($group['start_date'])); ?>
            </div>

            <div class="table-responsive">
              <table class="table table-sm table-bordered">

                <thead class="table-light">
                  <tr>
                    <th>Date</th>
                    <th class="text-end">Amount</th>
                  </tr>
                </thead>

                <tbody>

                  <?php $subTotal = 0; ?>

                  <?php if (!empty($group['items'])): ?>

                    <?php foreach ($group['items'] as $p): ?>
                      <?php $subTotal += $p['amount']; ?>

                      <tr>
                        <td><?php echo date("Y-m-d", strtotime($p['date'])); ?></td>
                        <td class="text-end">
                          ₱ <?php echo number_format($p['amount'], 2); ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>

                  <?php else: ?>

                    <tr>
                      <td colspan="2" class="text-center text-muted">
                        No payments in this subscription
                      </td>
                    </tr>

                  <?php endif; ?>

                  <tr class="table-secondary fw-bold">
                    <td>Total</td>
                    <td class="text-end">
                      ₱ <?php echo number_format($subTotal, 2); ?>
                    </td>
                  </tr>

                </tbody>

              </table>
            </div>

          <?php endforeach; ?>

        <?php else: ?>

          <div class="text-center text-muted">
            No payment records found
          </div>

        <?php endif; ?>

      </div>
    </div>
  </div>
</div>