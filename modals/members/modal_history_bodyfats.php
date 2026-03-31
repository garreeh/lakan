<?php
include './../connections/connections.php';



if (isset($_GET['customer_id'])) {
  $customer_id = $_GET['customer_id'];

  $sql_body_fats = "SELECT * FROM body_fats_history 
                  WHERE customer_id = $customer_id 
                  ORDER BY date_saved_bodyfats ASC"; // oldest first
  $resultBodyFatsQuery = mysqli_query($conn, $sql_body_fats);

  $body_fats_history = [];
  if ($resultBodyFatsQuery) {
    while ($row = mysqli_fetch_assoc($resultBodyFatsQuery)) {
      $body_fats_history[] = $row;
    }
  }

  $sql = "SELECT * FROM customer
          WHERE customer_id = $customer_id";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="modal fade" id="viewModalBodyFats" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Member ID:
                <?php echo $row['customer_id']; ?>
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">
                <div class="mb-3">
                  <label class="form-label text-secondary fw-bold">Previous Body Fats</label>
                  <ul class="list-group list-group-flush" id="body_fats_history_<?php echo $customer_id; ?>">
                    <?php if (!empty($body_fats_history)): ?>
                      <?php foreach ($body_fats_history as $bfh): ?>
                        <?php
                        $bodyFatValue = is_numeric($bfh['bodyfats_desc']) ? floatval($bfh['bodyfats_desc']) : null;

                        if ($bodyFatValue !== null) {
                          if ($bodyFatValue < 18) {
                            $style = 'color:#6EC6FF; font-weight:bold;'; // light blue
                          } elseif ($bodyFatValue <= 25) {
                            $style = 'color:#5CD65C; font-weight:bold;'; // light green
                          } elseif ($bodyFatValue <= 30) {
                            $style = 'color:#FFD966; font-weight:bold;'; // light yellow
                          } else {
                            $style = 'color:#FF9999; font-weight:bold;'; // light red
                          }
                        } else {
                          $style = ''; // fallback
                        }
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                          <span style="<?php echo $style; ?>">
                            <?php echo is_numeric($bfh['bodyfats_desc']) ? $bfh['bodyfats_desc'] . ' %' : htmlspecialchars($bfh['bodyfats_desc']); ?>
                          </span>
                          <span class="text-secondary small">
                            <?php
                            $date = new DateTime($bfh['date_saved_bodyfats']);
                            echo $date->format('M j, Y');
                            ?>
                          </span>
                        </li>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <li class="list-group-item text-center text-secondary">No history for body fats</li>
                    <?php endif; ?>
                  </ul>
                </div>

                <!-- Add a hidden input field to submit the form with the button click -->
                <input type="hidden" name="add_latest_body_fats" value="1">

                <div class="modal-footer">
                  <button type="button" class="btn btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Include jQuery -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <!-- Include Toastify JS -->
      <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

      <script>




      </script>

      <?php
    }
  }
}
?>