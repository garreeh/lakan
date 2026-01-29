<?php
include './../connections/connections.php';

$sql = "SELECT * FROM position";
$resultPosition = mysqli_query($conn, $sql);

$position_names = [];
if ($resultPosition) {
  while ($row = mysqli_fetch_assoc($resultPosition)) {
    $position_names[] = $row;
  }
}

if (isset($_GET['emp_id'])) {
  $emp_id = $_GET['emp_id'];
  $sql = "SELECT * FROM users
          LEFT JOIN position ON position.position_id = users.position_id
          WHERE emp_id = $emp_id";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
?>
      <div class="modal fade" id="updateEmployeeDetails" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Configure Employee Code: <?php echo $row['employee_number']; ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="emp_id" value="<?php echo $row['emp_id']; ?>">

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
                  <!-- Employee Number -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="employee_number" class="form-label text-secondary">
                        Employee Code <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <!-- <span class="input-group-text">
                          <i class="bi bi-diagram-3"></i>
                        </span> -->
                        <input type="text" class="form-control" id="employee_number" name="employee_number" placeholder="Enter Employee Code" value="<?php echo $row['employee_number'] ?>" required>
                      </div>
                    </div>
                  </div>
                  <!-- Employee Email -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="emp_email" class="form-label text-secondary">
                        Employee Email <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="emp_email" name="emp_email" placeholder="Enter Employee Email" value="<?php echo $row['emp_email'] ?>" required>
                      </div>
                    </div>
                  </div>
                  <!-- Birth Date -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="birth_date" class="form-label text-secondary">
                        Birth Date <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?php echo date('Y-m-d', strtotime($row['birth_date'])); ?>" required>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 2nd Clm -->
                <div class="row">
                  <!-- First Name -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="emp_firstname" class="form-label text-secondary">
                        First Name <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="emp_firstname" name="emp_firstname" placeholder="Enter First Name" value="<?php echo $row['emp_firstname'] ?>" required>
                      </div>
                    </div>
                  </div>
                  <!-- Middle Name -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="emp_middlename" class="form-label text-secondary">
                        Middle Name
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="emp_middlename" name="emp_middlename" placeholder="Middle Name" value="<?php echo $row['emp_middlename'] ?>">
                      </div>
                    </div>
                  </div>
                  <!-- Last Name -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="emp_lastname" class="form-label text-secondary">
                        Last Name <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="emp_lastname" name="emp_lastname" placeholder="Last Name" value="<?php echo $row['emp_lastname'] ?>" required>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 3rd Clm -->
                <div class="row justify-content-between align-items-center">
                  <!-- Age -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="age" class="form-label text-secondary">
                        Age <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="age" name="age" placeholder="Enter Age" value="<?php echo $row['age'] ?>" required readonly>
                      </div>
                    </div>
                  </div>
                  <!-- Religion -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="religion" class="form-label text-secondary">
                        Religion <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="religion" name="religion" placeholder="Enter Religion" value="<?php echo $row['religion'] ?>" required>
                      </div>
                    </div>
                  </div>
                  <!-- Blood Type -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="blood_type" class="form-label text-secondary">
                        Blood Type <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="blood_type" name="blood_type" placeholder="Enter Blood Type" value="<?php echo $row['blood_type'] ?>" required>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 4th Clm -->
                <div class="row justify-content-between align-items-center">
                  <!-- Suffix -->
                  <div class="col-md-3">
                    <div class="mb-3">
                      <label for="suffix" class="form-label text-secondary">
                        Suffix / Title
                      </label>
                      <div class="input-group">
                        <select class="form-control" id="suffix" name="suffix">
                          <option value="" <?php echo (empty($row['suffix']) || trim($row['suffix']) === '') ? 'selected' : ''; ?>>
                            N/A
                          </option>

                          <option value="Jr." <?php echo ($row['suffix'] == 'Jr.') ? 'selected' : ''; ?>>
                            Jr.
                          </option>

                          <option value="Sr." <?php echo ($row['suffix'] == 'Sr.') ? 'selected' : ''; ?>>
                            Sr.
                          </option>

                          <option value="III" <?php echo ($row['suffix'] == 'III') ? 'selected' : ''; ?>>
                            III
                          </option>

                          <option value="IV" <?php echo ($row['suffix'] == 'IV') ? 'selected' : ''; ?>>
                            IV
                          </option>

                          <option value="Mr." <?php echo ($row['suffix'] == 'Mr.') ? 'selected' : ''; ?>>
                            Mr.
                          </option>

                          <option value="Ms." <?php echo ($row['suffix'] == 'Ms.') ? 'selected' : ''; ?>>
                            Ms.
                          </option>

                          <option value="Mrs." <?php echo ($row['suffix'] == 'Mrs.') ? 'selected' : ''; ?>>
                            Mrs.
                          </option>

                        </select>
                      </div>
                    </div>

                  </div>

                  <!-- Civil Status -->
                  <div class="col-md-3">
                    <div class="mb-3">
                      <label for="civil_status" class="form-label text-secondary">
                        Civil Status <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <select class="form-control" id="civil_status" name="civil_status" required>
                          <option value="">Select Civil Status</option>

                          <option value="Single" <?php echo ($row['civil_status'] == 'Single') ? 'selected' : ''; ?>>
                            Single
                          </option>

                          <option value="Married" <?php echo ($row['civil_status'] == 'Married') ? 'selected' : ''; ?>>
                            Married
                          </option>

                          <option value="Widowed" <?php echo ($row['civil_status'] == 'Widowed') ? 'selected' : ''; ?>>
                            Widowed
                          </option>

                          <option value="Separated" <?php echo ($row['civil_status'] == 'Separated') ? 'selected' : ''; ?>>
                            Separated
                          </option>

                          <option value="Divorced" <?php echo ($row['civil_status'] == 'Divorced') ? 'selected' : ''; ?>>
                            Divorced
                          </option>

                        </select>
                      </div>
                    </div>
                  </div>

                  <!-- Gender -->
                  <div class="col-md-3">
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

                  <!-- Position / Department -->
                  <div class="col-md-3">
                    <div class="mb-3">
                      <label for="position_id" class="form-label text-secondary">
                        Position <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <select class="form-control" id="position_id" name="position_id" required>
                          <option value="">Select Position</option>
                          <?php foreach ($position_names as $pos): ?>
                            <option value="<?php echo $pos['position_id']; ?>" <?php echo ($pos['position_id'] == $row['position_id']) ? 'selected' : ''; ?>>
                              <?php echo htmlspecialchars($pos['position_name']); ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center my-4">
                  <h6 class="text-uppercase text-secondary mb-0 me-3">
                    <i class="bi bi-geo-alt-fill me-2"></i> <!-- Icon added -->
                    Address Details
                  </h6>
                  <hr class="flex-grow-1">
                </div>



                <!-- Addresses -->
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label for="no_street" class="form-label text-secondary">
                        Street / No.
                      </label>
                      <div class="input-group">
                        <textarea
                          class="form-control"
                          id="no_street"
                          name="no_street"
                          placeholder="Enter Street / No"
                          rows="3"
                          required
                          style="resize:none;"><?= htmlspecialchars($row['no_street'] ?? '') ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <!-- Region -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="region" class="form-label text-secondary">
                        Region
                      </label>
                      <select id="region" name="region" placeholder="Select Region"></select>
                    </div>

                  </div>
                  <!-- Province -->
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="province" class="form-label text-secondary">
                        Province
                      </label>
                      <select id="province" name="province" placeholder="Select Province" disabled></select>
                    </div>
                  </div>
                  <!-- City/Municipality -->
                  <div class="col-md-4">
                    <div class="mb-3">

                      <label for="province" class="form-label text-secondary">
                        City/Municipality
                      </label>
                      <select id="city" name="city" placeholder="Select City/Municipality" disabled></select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <!-- Barangay -->
                  <div class="col-md-6">
                    <div class="mb-3">

                      <label for="barangay" class="form-label text-secondary">
                        Barangay
                      </label>
                      <select id="barangay" name="barangay" placeholder="Select Barangay" disabled></select>
                    </div>
                  </div>
                  <!-- Zip Code -->
                  <div class="col-md-6">
                    <div class="mb-3">

                      <label for="zipcode" class="form-label text-secondary">
                        Zip Code
                      </label>
                      <input type="text" id="zipcode" name="zipcode" class="form-control" placeholder="Zip Code" value="<?php echo $row['zipcode'] ?>">
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
                      <label for="mobile_number" class="form-label text-secondary">
                        Mobile #
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter Mobile #" value="<?php echo $row['mobile_number'] ?>" required>
                      </div>
                    </div>
                  </div>
                  <!-- Telephone # -->
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="tel_number" class="form-label text-secondary">
                        Telephone #
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="tel_number" name="tel_number" placeholder="Enter Telephone #" value="<?php echo $row['tel_number'] ?>">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 7th Clm -->
                <div class="row">
                  <!-- Emergency Contact Person -->
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="emergency_contact_person" class="form-label text-secondary">
                        Emergency Contact Person
                      </label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="emergency_contact_person" name="emergency_contact_person" placeholder="Enter Emergency Contact Person" value="<?php echo $row['emergency_contact_person'] ?>">
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
                <input type="hidden" name="edit_employee" value="1">

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
        // Function to calculate age based on birth date
        function calculateAge(birthDate) {
          const today = new Date();
          const birth = new Date(birthDate);
          let age = today.getFullYear() - birth.getFullYear();
          const m = today.getMonth() - birth.getMonth();
          if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) {
            age--;
          }
          return age;
        }

        const birthInput = document.getElementById('birth_date');
        const ageInput = document.getElementById('age');

        // Calculate age on page load if birth_date already has a value.
        if (birthInput.value) {
          ageInput.value = calculateAge(birthInput.value);
        }

        // Update age whenever birth_date changes.
        birthInput.addEventListener('change', function() {
          ageInput.value = calculateAge(this.value);
        });

        // Function for connecting to backend real time.
        $(document).ready(function() {
          $('#updateEmployeeDetails form').submit(function(event) {
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
              url: '/lakan/controllers/edit_employee_details_process.php',
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

                  $('#updateEmployeeDetails').modal('hide');

                  // Update employee details in the frontend
                  updateClientDetails(response.employee);

                  // Optional: update profile picture preview if exists
                  if (response.employee.profile_pic) {
                    $('#profileImage').attr('src', 'data:image/jpeg;base64,' + response.employee.profile_pic);
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
        function updateClientDetails(employee) {
          // Format birth_date with leading zero for day
          let formattedDate = '';
          if (employee.birth_date) {
            const dateParts = new Date(employee.birth_date);
            const day = String(dateParts.getDate()).padStart(2, '0'); // leading zero
            const month = dateParts.toLocaleString('en-US', {
              month: 'long'
            });
            const year = dateParts.getFullYear();
            formattedDate = `${month} ${day}, ${year}`;
          }

          // Format address
          const addressParts = [
            employee.barangay,
            employee.city,
            employee.province,
            employee.region,
            employee.zipcode
          ].filter(Boolean);

          const fullAddress = addressParts.join(', ');

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
          setText(`employee_number_${employee.emp_id}`, employee.employee_number);
          setTextBold(
            `emp_fullname_${employee.emp_id}`,
            employee.emp_firstname +
            (employee.emp_middlename ? ' ' + employee.emp_middlename : '') +
            ' ' +
            employee.emp_lastname
          );

          setText(`birth_date_${employee.emp_id}`, formattedDate);
          setText(`emp_address_${employee.emp_id}`, fullAddress);
          setText(`emp_email_${employee.emp_id}`, employee.emp_email);
          setText(`age_${employee.emp_id}`, employee.age);
          setText(`position_name_${employee.emp_id}`, employee.position_name);

          setText(`religion_${employee.emp_id}`, employee.religion);
          setText(`civil_status_${employee.emp_id}`, employee.civil_status);
          setText(`gender_${employee.emp_id}`, employee.gender);
          setText(`blood_type_${employee.emp_id}`, employee.blood_type);
          setTextBold(`position_name_${employee.emp_id}`, employee.position_name);
          setText(`mobile_number_${employee.emp_id}`, employee.mobile_number);


          const profileImg = document.getElementById(`profile_pic_${employee.emp_id}`);
          if (profileImg) {
            if (employee.profile_pic) {
              profileImg.src = employee.profile_pic;
            } else {
              profileImg.src = './../assets/img/profile-img.jpg';
            }
          }

        }

        // Saved data from the database to preselect
        const savedRegion = <?php echo json_encode($row['region']); ?>;
        const savedProvince = <?php echo json_encode($row['province']); ?>;
        const savedCity = <?php echo json_encode($row['city']); ?>;
        const savedBarangay = <?php echo json_encode($row['barangay']); ?>;

        // API For Address Region + Province + City/Municipality + Barangay + Zip Code(Zip Code Manually Input)
        $(document).ready(function() {

          let isInitializing = true;

          const regionSelect = $('#region').selectize({
            placeholder: 'Select Region'
          })[0].selectize;

          const provinceSelect = $('#province').selectize({
            placeholder: 'Select Province'
          })[0].selectize;

          const citySelect = $('#city').selectize({
            placeholder: 'Select City/Municipality'
          })[0].selectize;

          const barangaySelect = $('#barangay').selectize({
            placeholder: 'Select Barangay'
          })[0].selectize;

          provinceSelect.disable();
          citySelect.disable();
          barangaySelect.disable();

          fetch('https://psgc.cloud/api/v2/regions')
            .then(res => res.json())
            .then(result => {
              (result.data || []).forEach(r =>
                regionSelect.addOption({
                  value: r.name,
                  text: r.name
                })
              );

              if (savedRegion) {
                regionSelect.setValue(savedRegion, true);
                loadProvinces(savedRegion);
              }
            });

          function loadProvinces(region) {
            provinceSelect.clear();
            provinceSelect.clearOptions();
            provinceSelect.disable();

            citySelect.clear();
            citySelect.clearOptions();
            citySelect.disable();

            barangaySelect.clear();
            barangaySelect.clearOptions();
            barangaySelect.disable();

            fetch(`https://psgc.cloud/api/v2/regions/${encodeURIComponent(region)}/provinces`)
              .then(res => res.json())
              .then(result => {
                (result.data || []).forEach(p => {
                  // Decode escaped Unicode characters (like \u00f1)
                  const decodedName = decodeURIComponent(escape(p.name));

                  provinceSelect.addOption({
                    value: decodedName,
                    text: decodedName.normalize("NFC") // normalize accents / ñ
                  });
                });

                provinceSelect.enable();

                // Set saved province if initializing
                if (isInitializing && savedProvince) {
                  const decodedSaved = decodeURIComponent(escape(savedProvince));
                  provinceSelect.setValue(decodedSaved.normalize("NFC"), true);
                  loadCities(decodedSaved);
                }
              })
              .catch(err => console.error('Error loading provinces:', err));
          }

          function loadCities(province) {
            citySelect.clear();
            citySelect.clearOptions();
            citySelect.disable();

            barangaySelect.clear();
            barangaySelect.clearOptions();
            barangaySelect.disable();

            fetch(`https://psgc.cloud/api/v2/provinces/${encodeURIComponent(province)}/cities-municipalities`)
              .then(res => res.json())
              .then(result => {
                (result.data || []).forEach(c => {
                  // Decode any escaped unicode characters
                  const decodedName = decodeURIComponent(escape(c.name));

                  citySelect.addOption({
                    value: decodedName,
                    text: decodedName.normalize("NFC") // normalize accents / ñ
                  });
                });

                citySelect.enable();

                if (isInitializing && savedCity) {
                  const decodedSaved = decodeURIComponent(escape(savedCity));
                  citySelect.setValue(decodedSaved.normalize("NFC"), true);
                  loadBarangays(decodedSaved);
                }
              })
              .catch(err => console.error('Error loading cities:', err));
          }

          function loadBarangays(city) {
            barangaySelect.clear();
            barangaySelect.clearOptions();
            barangaySelect.disable();

            const region = regionSelect.getValue();
            const province = provinceSelect.getValue();

            fetch(`https://psgc.cloud/api/v2/regions/${encodeURIComponent(region)}/provinces/${encodeURIComponent(province)}/cities-municipalities/${encodeURIComponent(city)}/barangays`)
              .then(res => res.json())
              .then(result => {
                (result.data || []).forEach(b => {
                  // Decode escaped Unicode characters (like \u00f1)
                  const decodedName = decodeURIComponent(escape(b.name));

                  barangaySelect.addOption({
                    value: decodedName,
                    text: decodedName.normalize("NFC") // normalize accents / ñ
                  });
                });

                barangaySelect.enable();

                if (isInitializing && savedBarangay) {
                  const decodedSaved = decodeURIComponent(escape(savedBarangay));
                  barangaySelect.setValue(decodedSaved.normalize("NFC"), true);
                }

                isInitializing = false;
              })
              .catch(err => console.error('Error loading barangays:', err));
          }


          regionSelect.on('change', function(region) {
            if (!region) return;
            loadProvinces(region);
          });

          provinceSelect.on('change', function(province) {
            if (!province) return;
            loadCities(province);
          });

          citySelect.on('change', function(city) {
            if (!city) return;
            loadBarangays(city);
          });

        });
      </script>

<?php
    }
  }
}
?>