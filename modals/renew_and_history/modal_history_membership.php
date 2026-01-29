<?php
include './../connections/connections.php';

if (isset($_GET['customer_id'])) {
  $customer_id = $_GET['customer_id'];

  // Fetch membership history, latest first
  $sql = "SELECT customer.first_name, customer.last_name, membership_history.membership_type_id, membership_type.membership_type_name, membership_history.start_date, membership_history.end_date FROM customer
          LEFT JOIN membership_history ON membership_history.customer_id = customer.customer_id
          LEFT JOIN membership_type ON membership_type.membership_type_id = membership_history.membership_type_id
          WHERE membership_history.customer_id = '$customer_id' ORDER BY start_date DESC";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
?>
    <div class="modal fade" id="membershipHistoryModal" tabindex="-1" aria-labelledby="membershipHistoryModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="membershipHistoryModalLabel">
              Membership History:
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="list-group">
              <?php
              while ($row = mysqli_fetch_assoc($result)) {
                $start = !empty($row['start_date']) ? date('F j, Y', strtotime($row['start_date'])) : 'N/A';
                $end   = !empty($row['end_date']) ? date('F j, Y', strtotime($row['end_date'])) : 'N/A';
              ?>
                <div class="list-group-item list-group-item-action mb-2 shadow-sm rounded">
                  <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($row['membership_type_name']); ?></h6>
                    <small class="text-muted"><?php echo $start . ' - ' . $end; ?></small>
                  </div>
                  <?php if (!empty($row['membership_type_description'])): ?>
                    <p class="mb-0 text-secondary"><?php echo htmlspecialchars($row['membership_type_description']); ?></p>
                  <?php endif; ?>
                </div>
              <?php } ?>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
<?php
  } else {
    echo '<div class="alert alert-warning">No membership history found for this customer.</div>';
  }
}
?>