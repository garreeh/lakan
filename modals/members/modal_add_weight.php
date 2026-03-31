<?php
include './../connections/connections.php';



if (isset($_GET['customer_id'])) {
  $customer_id = $_GET['customer_id'];

  $sql_weight = "SELECT * FROM weight_history 
                  WHERE customer_id = $customer_id 
                  ORDER BY date_saved_weight ASC"; // oldest first
  $resultWeightQuery = mysqli_query($conn, $sql_weight);

  $weight_history = [];
  if ($resultWeightQuery) {
    while ($row = mysqli_fetch_assoc($resultWeightQuery)) {
      $weight_history[] = $row;
    }
  }

  $sql = "SELECT * FROM customer
          WHERE customer_id = $customer_id";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="modal fade" id="addWeightModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Weight Member ID:
                <?php echo $row['customer_id']; ?>
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">
                <div class="mb-3">
                  <label class="form-label text-secondary fw-bold">Previous Weight</label>
                  <ul class="list-group list-group-flush" data-customer-id="<?php echo $customer_id; ?>">
                    <?php if (!empty($weight_history)): ?>
                      <?php foreach ($weight_history as $w): ?>
                        <?php
                        $weightValue = is_numeric($w['weight_desc']) ? floatval($w['weight_desc']) : null;

                        if ($weightValue !== null) {
                          if ($weightValue < 18) {
                            $style = 'color:#6EC6FF; font-weight:bold;'; // light blue
                          } elseif ($weightValue <= 25) {
                            $style = 'color:#5CD65C; font-weight:bold;'; // light green
                          } elseif ($weightValue <= 30) {
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
                            <?php echo is_numeric($w['weight_desc']) ? $w['weight_desc'] . ' KG' : htmlspecialchars($w['weight_desc']); ?>
                          </span>
                          <span class="text-secondary small">
                            <?php
                            $date = new DateTime($w['date_saved_weight']);
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

                <!-- 1st Column: Weight -->
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label for="weight_desc" class="form-label text-secondary">
                        Add Latest Weight <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <!-- Icon on the left -->
                        <span class="input-group-text bg-light">
                          <i class="bi bi-speedometer2"></i>
                        </span>
                        <input type="text" class="form-control" id="weight_desc" name="weight_desc"
                          placeholder="Enter Latest Weight" required>
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
                        <input type="text" class="form-control" id="date_saved_weight" name="date_saved_weight" value="<?php
                        date_default_timezone_set('Asia/Manila');
                        echo date('M j, Y'); // e.g., Jan 2, 1999
                        ?>" readonly>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Add a hidden input field to submit the form with the button click -->
                <input type="hidden" name="add_weight" value="1">

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
        function updateWeightList(container, bodyWeight) {
          if (!container) return;
          container.innerHTML = '';

          bodyWeight.forEach(w => {
            let weightValue = isNaN(parseFloat(w.weight_desc)) ? null : parseFloat(w.weight_desc);

            let style = '';
            if (weightValue !== null) {
              if (weightValue < 18) style = 'color:#6EC6FF; font-weight:bold;';
              else if (weightValue <= 25) style = 'color:#5CD65C; font-weight:bold;';
              else if (weightValue <= 30) style = 'color:#FFD966; font-weight:bold;';
              else style = 'color:#FF9999; font-weight:bold;';
            }

            const date = new Date(w.date_saved_weight);
            const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center py-1 px-2';
            li.innerHTML = `
        <span style="${style}">
          ${weightValue !== null ? weightValue + '  kg' : w.weight_desc}
        </span>
        <span class="text-secondary small">${formattedDate}</span>
      `;
            container.appendChild(li);
          });
        }

        // Update latest body fat display for a specific customer
        function updateClientWeight(weight_data) {
          const el = document.getElementById(`weight_desc_${weight_data.customer_id}`);
          if (el) {
            const span = el.querySelector('span');
            if (span) {
              span.textContent = weight_data.weight_desc + '  kg';
            }
          }
        }

        $(document).ready(function () {
          $('#addWeightModal form').submit(function (event) {
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
              url: '/lakan/controllers/add_weight_process.php',
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

                  $('#addWeightModal').modal('hide');

                  const customerId = response.weight_history[0].customer_id;

                  // 1️⃣ Update latest body fat display
                  updateClientWeight(response.weight_history[response.weight_history.length - 1]);

                  // 2️⃣ Update add-body-fats modal list (use data-customer-id)
                  const addWeightModalList = document.querySelector(`#addWeightModal .list-group.list-group-flush[data-customer-id="${customerId}"]`);
                  updateWeightList(addWeightModalList, response.weight_history);

                  // 3️⃣ Update history modal list
                  const historyWeightList = document.getElementById(`weight_history_${customerId}`);
                  updateWeightList(historyWeightList, response.weight_history);

                  $('#addWeightModal').find('#weight_desc').val('');

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