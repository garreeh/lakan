<?php
include './../connections/connections.php';

$sql = "SELECT * FROM membership_type";
$resultMembershipType = mysqli_query($conn, $sql);

$membership_type_names = [];
if ($resultMembershipType) {
  while ($row = mysqli_fetch_assoc($resultMembershipType)) {
    $membership_type_names[] = $row;
  }
}

if (isset($_GET['customer_id'])) {
  $customer_id = $_GET['customer_id'];
  $sql = "SELECT * FROM customer
          WHERE customer_id = $customer_id";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
?>
      <div class="modal fade" id="updateMemberDetails" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Configure Member ID: <?php echo $row['customer_id']; ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">

                <!-- Profile Picture -->
                <div class="mb-4 d-flex flex-column align-items-center">
                  <?php
                  $profileImg = !empty($row['profile_pic'])
                    ? $row['profile_pic']
                    : './assets/img/profile-img.jpg';
                  ?>

                  <img id="profilePreview"
                    src="<?= $profileImg ?>"
                    class="rounded-circle mb-2"
                    style="width:150px;height:150px;object-fit:cover;border:3px solid #ddd;">

                  <!-- Keep old image -->

                  <div class="mt-2" style="width:50%;">
                    <input type="file"
                      id="profile_pic"
                      name="profile_pic"
                      accept="image/*"
                      class="form-control"
                      onchange="previewProfilePic(this)">
                    <small class=" text-muted">Upload profile picture (jpg, png, max 20MB)</small>
                  </div>
                </div>

                <div class="d-flex align-items-center my-4">
                  <h6 class="text-uppercase text-secondary mb-0 me-3">
                    <i class="bi bi-person-fill me-2"></i> <!-- Icon added -->
                    Personal Details
                  </h6>
                  <hr class="flex-grow-1">
                </div>

                <!-- 1st Clm -->
                <div class="row">
                  <!-- First Name -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="first_name" class="form-label text-secondary">
                        First Name <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" value="<?php echo $row['first_name'] ?>" required>
                      </div>
                    </div>
                  </div>
                  <!-- Middle Name -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="middle_name" class="form-label text-secondary">
                        Middle Name
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" value="<?php echo $row['middle_name'] ?>">
                      </div>
                    </div>
                  </div>
                  <!-- Last Name -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="last_name" class="form-label text-secondary">
                        Last Name <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo $row['last_name'] ?>" required>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 3rd Clm -->
                <div class="row justify-content-between align-items-center">

                  <!-- Age -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="birth_date" class="form-label text-secondary">
                        Birth Date <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input type="date" class="form-control" id="birth_date_edit" name="birth_date" value="<?php echo date('Y-m-d', strtotime($row['birth_date'])); ?>" required>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="age" class="form-label text-secondary">
                        Age <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="age_edit" name="age" placeholder="Enter Age" value="<?php echo $row['age'] ?>" required readonly>
                      </div>
                    </div>
                  </div>

                  <!-- Gender -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="gender" class="form-label text-secondary">
                        Gender <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <select class="form-control" id="gender" name="gender" required>
                          <option value="">Select Gender</option>

                          <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>
                            Male
                          </option>

                          <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>
                            Female
                          </option>

                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center my-4">
                  <h6 class="text-uppercase text-secondary mb-0 me-3">
                    <i class="bi bi-envelope-fill me-2"></i> <!-- Icon added -->
                    Contact Details
                  </h6>
                  <hr class="flex-grow-1">
                </div>


                <!-- 6th Clm -->
                <div class="row">
                  <!-- Mobile Number -->
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="contact_no" class="form-label text-secondary">
                        Mobile #
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Enter Mobile #" value="<?php echo $row['contact_no'] ?>">
                      </div>
                    </div>
                  </div>
                  <!-- Telephone # -->
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="email" class="form-label text-secondary">
                        Email
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Telephone #" value="<?php echo $row['email'] ?>">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 7th Clm -->
                <div class="row">
                  <!-- Emergency Contact Name -->
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="emergency_contact_name" class="form-label text-secondary">
                        Emergency Contact Name
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" placeholder="Enter Emergency Contact Person" value="<?php echo $row['emergency_contact_name'] ?>">
                      </div>
                    </div>
                  </div>

                  <!-- Emergency Contact # -->
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="emergency_contact_no" class="form-label text-secondary">
                        Emergency Contact #
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="emergency_contact_no" name="emergency_contact_no" placeholder="Enter Emergency Contact Person" value="<?php echo $row['emergency_contact_no'] ?>">
                      </div>
                    </div>
                  </div>

                </div>

                <br>
                <div class="mt-3">
                  <small class="text-danger">
                    * All fields marked with a red asterisk are required
                  </small>
                </div>

                <!-- Add a hidden input field to submit the form with the button click -->
                <input type="hidden" name="edit_member_details" value="1">

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
        function previewProfilePic(input) {
          const file = input.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              document.getElementById('profilePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
          }
        }

        document.addEventListener('DOMContentLoaded', function() {
          const birthInput = document.getElementById('birth_date_edit');
          const ageInput = document.getElementById('age_edit');

          function calculateAge() {
            const birthDate = new Date(birthInput.value);
            if (!isNaN(birthDate)) {
              const today = new Date();
              let age = today.getFullYear() - birthDate.getFullYear();
              const m = today.getMonth() - birthDate.getMonth();

              // If birthday hasn’t occurred yet this year
              if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
              }

              ageInput.value = age;
            } else {
              ageInput.value = '';
            }
          }

          // Run whenever birth date changes
          birthInput.addEventListener('input', calculateAge);

          // Run immediately if there’s already a value
          calculateAge();
        });


        // Function for connecting to backend real time.
        $(document).ready(function() {
          $('#updateMemberDetails form').submit(function(event) {
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
              url: '/lakan/controllers/edit_member_details_process.php',
              data: formData,
              processData: false,
              contentType: false,
              dataType: 'json',
              success: function(response) {
                // console.log("Response object:", response);
                if (response.success) {
                  Toastify({
                    text: response.message,
                    duration: 2000,
                    close: true,
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
                  }).showToast();

                  $('#updateMemberDetails').modal('hide');

                  // Update members_data details in the frontend
                  updateClientDetails(response.members_data);

                  // Optional: update profile picture preview if exists
                  if (response.members_data.profile_pic) {
                    $('#profileImage').attr('src', 'data:image/jpeg;base64,' + response.members_data.profile_pic);
                  }
                } else {
                  Toastify({
                    text: response.message,
                    duration: 2000,
                    close: true,
                    backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
                  }).showToast();
                }
              },
              error: function(xhr, status, error) {
                console.error("AJAX error:", error);
                Toastify({
                  text: "An error occurred while updating. Check console.",
                  duration: 2000,
                  close: true,
                  backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
                }).showToast();
              },
              complete: function() {
                $submitButton.prop('disabled', false).html(originalHtml);
              }
            });
          });
        });

        // Function for real time update in the frontend.
        function updateClientDetails(members_data) {
          // Format birth_date with leading zero for day
          let formattedDate = '';
          if (members_data.birth_date) {
            const dateParts = new Date(members_data.birth_date);
            const day = String(dateParts.getDate()).padStart(2, '0'); // leading zero
            const month = dateParts.toLocaleString('en-US', {
              month: 'long'
            });
            const year = dateParts.getFullYear();
            formattedDate = `${month} ${day}, ${year}`;
          }

          // setText helper
          function setText(id, value) {
            const el = document.getElementById(id);
            el && (el.textContent = value);
          }

          // setText hepler but bold
          function setTextBold(id, value) {
            const el = document.getElementById(id);
            if (el) el.innerHTML = `<strong>${value}</strong>`;
          }

          // Update all fields
          setText(
            `cus_fullname_${members_data.customer_id}`,
            members_data.first_name +
            (members_data.middle_name ? ' ' + members_data.middle_name : '') +
            ' ' +
            members_data.last_name
          );

          setText(`birth_date_${members_data.customer_id}`, formattedDate);
          setText(`email_${members_data.customer_id}`, members_data.email);
          setText(`age_${members_data.customer_id}`, members_data.age);
          setText(`gender_${members_data.customer_id}`, members_data.gender);
          setText(`mobile_number_${members_data.customer_id}`, members_data.contact_no);

          const profileImg = document.getElementById(`profile_pic_${members_data.customer_id}`);
          if (profileImg) {
            if (members_data.profile_pic) {
              profileImg.src = members_data.profile_pic;
            } else {
              profileImg.src = './../assets/img/profile-img.jpg';
            }
          }

        }
      </script>

<?php
    }
  }
}
?>