<div class="tab-pane fade show active profile-overview" id="profile-overview">
  <!-- <h5 class="card-title">About</h5>
  <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> -->

  <h5 class="card-title d-flex justify-content-between align-items-center">
    Overview
    <a href="#" class="btn btn-sm btn-primary shadow-lg" data-bs-toggle="modal" data-bs-target="#updateMemberDetails">
      <i class="bi bi-pencil"></i> Update
    </a>
  </h5>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Birth Date</div>
    <div class="col-lg-9 col-md-8" id="birth_date_<?php echo $customer_id; ?>">
      <?php
      echo !empty($data['birth_date'])
        ? date('F d, Y', strtotime($data['birth_date']))
        : '';
      ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Age</div>
    <div class="col-lg-9 col-md-8" id="age_<?php echo $customer_id; ?>">
      <?php echo $data['age'] ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Email</div>
    <div class="col-lg-9 col-md-8" id="email_<?php echo $customer_id; ?>">
      <?php echo !empty($data['email']) ? htmlspecialchars($data['email']) : '-'; ?>
    </div>
  </div>


  <!-- <div class="row">
    <div class="col-lg-3 col-md-4 label">Address</div>
    <div class="col-lg-9 col-md-8" id="emp_address_<?php echo $customer_id; ?>">
      </?php
      $addressParts = array_filter([
        $data['barangay'],
        $data['city'],
        $data['province'],
        $data['region'],
        $data['zipcode']
      ]);

      echo htmlspecialchars(implode(', ', $addressParts));
      ?>
    </div>
  </div> -->

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Gender</div>
    <div class="col-lg-9 col-md-8" id="gender_<?php echo $customer_id; ?>">
      <?php echo $data['gender'] ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Contact No.</div>
    <div class="col-lg-9 col-md-8" id="mobile_number_<?php echo $customer_id; ?>">
      <?php echo !empty($data['contact_no']) ? htmlspecialchars($data['contact_no']) : '-'; ?>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Emergency Contact Name</div>
    <div class="col-lg-9 col-md-8" id="emergency_contact_name_<?php echo $customer_id; ?>">
      <?php echo !empty($data['emergency_contact_name']) ? htmlspecialchars($data['emergency_contact_name']) : '-'; ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-4 label">Emergency Contact #</div>
    <div class="col-lg-9 col-md-8" id="emergency_contact_no_<?php echo $customer_id; ?>">
      <?php echo !empty($data['emergency_contact_no']) ? htmlspecialchars($data['emergency_contact_no']) : '-'; ?>
    </div>
  </div>


</div>