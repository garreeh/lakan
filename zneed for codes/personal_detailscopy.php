<div class="tab-pane fade show active profile-overview" id="profile-overview">
  <h5 class="card-title">About</h5>
  <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>

  <h5 class="card-title">Profile Details</h5>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Employee Code</div>
    <div class="col-lg-9 col-md-8" id="employee_number_<?php echo $lakan_user_id; ?>">
      <?php echo $employee['employee_number'] ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Full Name</div>
    <div class="col-lg-9 col-md-8" id="cus_fullname_<?php echo $lakan_user_id; ?>">
      <?php
      echo htmlspecialchars(
        $employee['lakan_firstname'] .
          (!empty($employee['lakan_middleaname']) ? ' ' . $employee['lakan_middleaname'] : '') .
          ' ' . $employee['lakan_lastname']
      );
      ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Department</div>
    <div class="col-lg-9 col-md-8" id="end_date_<?php echo $lakan_user_id; ?>">
      <?php echo $employee['department_name'] ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Country</div>
    <div class="col-lg-9 col-md-8">USA</div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Address</div>
    <div class="col-lg-9 col-md-8">A108 Adam Street, New York, NY 535022</div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Phone</div>
    <div class="col-lg-9 col-md-8">(436) 486-3538 x29071</div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Email</div>
    <div class="col-lg-9 col-md-8">k.anderson@example.com</div>
  </div>

</div>