<?php
include './../connections/connections.php';

$sql = "SELECT * FROM department";
$resultDepartment = mysqli_query($conn, $sql);

$department_names = [];
if ($resultDepartment) {
  while ($row = mysqli_fetch_assoc($resultDepartment)) {
    $department_names[] = $row;
  }
}

if (isset($_GET['emp_id'])) {
  $emp_id = $_GET['emp_id'];
  $sql = "SELECT * FROM users WHERE emp_id = $emp_id";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
?>

      <div class="col-md-4">
        <!-- Department -->
        <div class="input-group mb-3">

          <!-- It has style because of the Selectize -->
          <span class="input-group-text" style="height: 34px !important;">
            <i class="bi bi-building"></i>
          </span>

          <select class="form-control" id="department_id" name="department_id" required>
            <option value="">Select Department <span class="text-danger">*</span></option>

            <?php foreach ($department_names as $dept): ?>
              <option value="<?php echo $dept['department_id']; ?>" <?php echo ($dept['department_id'] == $row['department_id']) ? 'selected' : ''; ?>>

                <?php echo htmlspecialchars($dept['department_name']); ?>
              </option>
            <?php endforeach; ?>

          </select>
        </div>
      </div>

<?php
    }
  }
}
?>