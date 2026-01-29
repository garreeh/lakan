<?php include './../connections/connections.php' ?>

<?php

if (isset($_SESSION['lakan_user_id'])) {
  $lakan_user_id = $_SESSION['lakan_user_id'];
  $query = "SELECT lakan_firstname, lakan_lastname FROM users WHERE lakan_user_id = $lakan_user_id";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lakan_firstname = $row["lakan_firstname"];
    $lakan_lastname = $row["lakan_lastname"];

    $full_name = $lakan_firstname . " " . $lakan_lastname;
  } else {
    $full_name = "Unknown"; // If no employee found
  }
} else {
  $full_name = "Unknown"; // If employee ID or username is not set in the session
}
?>

<!-- Start Profile Nav -->
<li class="nav-item dropdown pe-3">

  <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
    <img src="./../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $full_name; ?></span>
  </a>

  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

    <li>
      <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
        <i class="bi bi-person"></i>
        <span>My Profile</span>
      </a>
    </li>
    <li>
      <hr class="dropdown-divider">
    </li>

    <li>
      <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
        <i class="bi bi-gear"></i>
        <span>Account Settings</span>
      </a>
    </li>
    <li>
      <hr class="dropdown-divider">
    </li>

    <li>
      <a class="dropdown-item d-flex align-items-center" href="./../controllers/logout_process.php">
        <i class="bi bi-box-arrow-right"></i>
        <span>Sign Out</span>
      </a>
    </li>


  </ul><!-- End Profile Dropdown Items -->
</li>
<!-- End Profile Nav -->