<div class="tab-pane fade show active profile-overview" id="profile-overview">
  <!-- <h5 class="card-title">About</h5>
  <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> -->

  <h5 class="card-title d-flex justify-content-between align-items-center">
    Overview
    <a href="#" class="btn btn-sm btn-primary shadow-lg" data-bs-toggle="modal" data-bs-target="#updateEmployeeDetails">
      <i class="bi bi-pencil"></i> Update
    </a>
  </h5>


  <div class="row">
    <div class="col-lg-3 col-md-4 label">Employee Code</div>
    <div class="col-lg-9 col-md-8" id="employee_number_<?php echo $emp_id; ?>">
      <?php echo $employee['employee_number'] ?>
    </div>
  </div>

  <!-- <div class="row">
    <div class="col-lg-3 col-md-4 label">Position</div>
    <div class="col-lg-9 col-md-8" id="position_name_<?php echo $emp_id; ?>">
      <?php echo $employee['position_name'] ?>
    </div>
  </div> -->

  <!-- <div class="row">
    <div class="col-lg-3 col-md-4 label">Full Name</div>
    <div class="col-lg-9 col-md-8" id="emp_fullname_<?php echo $emp_id; ?>">
      <?php
      echo htmlspecialchars(
        $employee['emp_firstname'] .
          (!empty($employee['emp_middlename']) ? ' ' . $employee['emp_middlename'] : '') .
          ' ' . $employee['emp_lastname']
      );
      ?>
    </div>
  </div> -->

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Birth Date</div>
    <div class="col-lg-9 col-md-8" id="birth_date_<?php echo $emp_id; ?>">
      <?php
      echo !empty($employee['birth_date'])
        ? date('F d, Y', strtotime($employee['birth_date']))
        : '';
      ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Age</div>
    <div class="col-lg-9 col-md-8" id="age_<?php echo $emp_id; ?>">
      <?php echo $employee['age'] ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Email</div>

    <div class="col-lg-9 col-md-8" id="emp_email_<?php echo $emp_id; ?>">
      <?php echo $employee['emp_email'] ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Address</div>
    <div class="col-lg-9 col-md-8" id="emp_address_<?php echo $emp_id; ?>">
      <?php
      $addressParts = array_filter([
        $employee['barangay'],
        $employee['city'],
        $employee['province'],
        $employee['region'],
        $employee['zipcode']
      ]);

      echo htmlspecialchars(implode(', ', $addressParts));
      ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Religion</div>
    <div class="col-lg-9 col-md-8" id="religion_<?php echo $emp_id; ?>">
      <?php echo $employee['religion'] ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Civil Status</div>
    <div class="col-lg-9 col-md-8" id="civil_status_<?php echo $emp_id; ?>">
      <?php echo $employee['civil_status'] ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Gender</div>
    <div class="col-lg-9 col-md-8" id="gender_<?php echo $emp_id; ?>">
      <?php echo $employee['gender'] ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Blood Type</div>
    <div class="col-lg-9 col-md-8" id="blood_type_<?php echo $emp_id; ?>">
      <?php echo $employee['blood_type'] ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Contact No.</div>
    <div class="col-lg-9 col-md-8" id="mobile_number_<?php echo $emp_id; ?>">
      <?php echo $employee['mobile_number'] ?>
    </div>
  </div>
</div>