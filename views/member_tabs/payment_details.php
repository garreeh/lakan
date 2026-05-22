<div class="tab-pane fade show payment-details profile-overview" id="profile-settings">

  <div class="card shadow-sm border-0">

    <!-- HEADER -->
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
      <div class="d-none d-md-block">
        <h5 class="mb-0">Payment Receipt</h5>
        <small class="text-muted">Latest Payment Overview</small>
      </div>

      <div class="btn-group">
        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentsModal">
          <i class="bi bi-plus"></i> Update Payment
        </a>

        <a href="#" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
          data-bs-target="#HistoryPaymentsModal">
          <i class="bi bi-clock-history"></i> History
        </a>
      </div>
    </div>

    <div class="card-body">

      <?php
      $totalPrice = (float) $data['membershiptype_price'];
      $paymentType = $data['payment_type'];
      $down = (float) $data['down_payment_amount'];
      $remaining = (float) $data['remaining_balance'];
      $months = (int) $data['months_term_remaining'];
      $monthly = ($months > 0) ? $remaining / $months : 0;
      ?>

      <br>

      <!-- CUSTOMER TYPE -->
      <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
        <span class="text-muted">Type</span>
        <strong><?php echo !empty($paymentType) ? htmlspecialchars($paymentType) : '-'; ?></strong>
      </div>

      <!-- TOTAL -->
      <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
        <span class="text-muted">Total</span>
        <strong id="ui_total">₱ <?php echo number_format($totalPrice, 2); ?></strong>
      </div>

      <?php if ($paymentType === 'Downpayment'): ?>

        <!-- DOWN PAYMENT -->
        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
          <span class="text-muted">DP</span>
          <strong id="ui_down" class="text-success">
            ₱ <?php echo number_format($down, 2); ?>
          </strong>
        </div>

        <!-- BALANCE -->
        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
          <span class="text-muted">Balance</span>
          <strong id="remaining_balance_<?php echo $customer_id; ?>" class="text-danger">
            ₱ <?php echo number_format($remaining, 2); ?>
          </strong>
        </div>

        <!-- MONTHLY -->
        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
          <span class="text-muted">Monthly</span>
          <strong id="monthly_payment_<?php echo $customer_id; ?>">
            ₱ <?php echo number_format($monthly, 2); ?>
          </strong>
        </div>

        <!-- REMAINING TERMS -->
        <div class="d-flex justify-content-between pb-2 mb-2">
          <span class="text-muted">Remaining Terms</span>
          <strong id="months_term_remaining_<?php echo $customer_id; ?>">
            <?php echo $months > 0 ? $months . ' Month' . ($months > 1 ? 's' : '') : '-'; ?>
          </strong>
        </div>

      <?php endif; ?>

      <!-- FOOTER NOTE -->
      <div class="mt-3 p-3 bg-light rounded text-center">
        <small class="text-muted">
          This is an official payment summary receipt
        </small>
      </div>

    </div>
  </div>

</div>