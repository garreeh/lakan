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
      <div class="modal fade" id="addBodyFatsModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Body Fats Member ID:
                <?php echo $row['customer_id']; ?>
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">
                <div class="mb-3">
                  <label class="form-label text-secondary fw-bold">Previous Body Fats</label>
                  <ul class="list-group list-group-flush" data-customer-id="<?php echo $customer_id; ?>">
                    <?php if (!empty($body_fats_history)): ?>

                      <?php foreach ($body_fats_history as $bf): ?>
                        <?php
                        $bodyFatValue = is_numeric($bf['bodyfats_desc']) ? floatval($bf['bodyfats_desc']) : null;

                        // Default color
                        $colorClass = 'text-primary fw-bold';

                        if ($bodyFatValue !== null) {
                          if ($bodyFatValue < 18) { // Low
                            $colorClass = 'fw-bold'; // default blue
                            $style = 'color:#6EC6FF'; // light blue
                          } elseif ($bodyFatValue <= 25) { // Healthy
                            $style = 'color:#5CD65C'; // light green
                          } elseif ($bodyFatValue <= 30) { // Borderline
                            $style = 'color:#FFD966'; // light yellow
                          } else { // High
                            $style = 'color:#FF9999'; // light red
                          }
                        } else {
                          $style = ''; // fallback
                        }
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                          <span class="fw-bold" style="<?php echo $style; ?>">
                            <?php echo is_numeric($bf['bodyfats_desc']) ? $bf['bodyfats_desc'] . ' %' : htmlspecialchars($bf['bodyfats_desc']); ?>
                          </span>
                          <span class="text-secondary small">
                            <?php
                            $date = new DateTime($bf['date_saved_bodyfats']);
                            echo $date->format('M j, Y');
                            ?>
                          </span>
                        </li>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <li class="list-group-item text-center text-secondary">No history for weight</li>
                    <?php endif; ?>
                  </ul>
                </div>

                <hr>

                <!-- 1st Column: Body Fats -->
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label for="bodyfats_desc" class="form-label text-secondary">
                        Add Latest Body Fats <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <!-- Icon on the left -->
                        <span class="input-group-text bg-light">
                          <i class="bi bi-speedometer2"></i>
                        </span>
                        <input type="text" class="form-control" id="bodyfats_desc" name="bodyfats_desc"
                          placeholder="Enter Latest Body Fats" required>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 2nd Column: Date -->
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label class="form-label text-secondary">
                        Date <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <!-- Calendar icon -->
                        <span class="input-group-text bg-light">
                          <i class="bi bi-calendar-date"></i>
                        </span>
                        <input type="text" class="form-control" id="date_saved_bodyfats" name="date_saved_bodyfats" value="<?php
                        date_default_timezone_set('Asia/Manila');
                        echo date('M j, Y'); // e.g., Jan 2, 1999
                        ?>" readonly>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Add a hidden input field to submit the form with the button click -->
                <input type="hidden" name="add_latest_body_fats" value="1">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
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
        // Reusable function to update any body fats list
        function updateBodyFatsList(container, bodyFats) {
          if (!container) return;
          container.innerHTML = '';

          bodyFats.forEach(bf => {
            let bodyFatValue = isNaN(parseFloat(bf.bodyfats_desc)) ? null : parseFloat(bf.bodyfats_desc);

            let style = '';
            if (bodyFatValue !== null) {
              if (bodyFatValue < 18) style = 'color:#6EC6FF; font-weight:bold;';
              else if (bodyFatValue <= 25) style = 'color:#5CD65C; font-weight:bold;';
              else if (bodyFatValue <= 30) style = 'color:#FFD966; font-weight:bold;';
              else style = 'color:#FF9999; font-weight:bold;';
            }

            const date = new Date(bf.date_saved_bodyfats);
            const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center py-1 px-2';
            li.innerHTML = `
        <span style="${style}">
          ${bodyFatValue !== null ? bodyFatValue + ' %' : bf.bodyfats_desc}
        </span>
        <span class="text-secondary small">${formattedDate}</span>
      `;
            container.appendChild(li);
          });
        }


        // Update latest body fat display for a specific customer
        function updateClientBodyFats(body_fat_data) {
          const el = document.getElementById(`bodyfats_desc_${body_fat_data.customer_id}`);
          if (el) {
            const span = el.querySelector('span');
            if (span) {
              span.textContent = body_fat_data.bodyfats_desc + ' %';
            }
          }
        }

        $(document).ready(function () {
          $('#addBodyFatsModal form').submit(function (event) {
            event.preventDefault();

            var $form = $(this);
            var $submitButton = $form.find('button[type="submit"]');
            var originalHtml = $submitButton.html();

            $submitButton.prop('disabled', true).html(`
          <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
          Saving...
      `);

            var formData = new FormData(this);

            $.ajax({
              type: 'POST',
              url: '/lakan/controllers/add_bodyfats_process.php',
              data: formData,
              processData: false,
              contentType: false,
              dataType: 'json',
              success: function (response) {
                if (response.success) {
                  Toastify({
                    text: response.message,
                    duration: 2000,
                    close: true,
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
                  }).showToast();

                  $('#addBodyFatsModal').modal('hide');

                  const customerId = response.body_fats_history[0].customer_id;

                  // 1️⃣ Update latest body fat display
                  updateClientBodyFats(response.body_fats_history[response.body_fats_history.length - 1]);

                  // 2️⃣ Update add-body-fats modal list (use data-customer-id)
                  const addModalList = document.querySelector(`#addBodyFatsModal .list-group.list-group-flush[data-customer-id="${customerId}"]`);
                  updateBodyFatsList(addModalList, response.body_fats_history);

                  // 3️⃣ Update history modal list
                  const historyList = document.getElementById(`body_fats_history_${customerId}`);
                  updateBodyFatsList(historyList, response.body_fats_history);

                  $('#addBodyFatsModal').find('#bodyfats_desc').val('');

                } else {
                  Toastify({
                    text: response.message,
                    duration: 2000,
                    close: true,
                    backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
                  }).showToast();
                }
              },
              error: function (xhr, status, error) {
                console.error("AJAX error:", error);
                Toastify({
                  text: "An error occurred while updating. Check console.",
                  duration: 2000,
                  close: true,
                  backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
                }).showToast();
              },
              complete: function () {
                $submitButton.prop('disabled', false).html(originalHtml);
              }
            });
          });
        });


      </script>

      <?php
    }
  }
}
?>