<?php
// Set timezone to Manila
date_default_timezone_set('Asia/Manila');

// Define table and primary key
$table = 'customer';
$primaryKey = 'customer_id';

// Define columns for DataTables
$columns = array(
  array(
    'db' => 'customer_id',
    'dt' => 0,
    'field' => 'customer_id',
    'formatter' => function ($lab1, $row) {
      return $row['customer_id'];
    }
  ),

  array(
    'db' => 'first_name',
    'dt' => 1,
    'field' => 'first_name',
    'formatter' => function ($lab2, $row) {
      return '<a 
                    href="../views/edit_details.php?module=inactive&customer_id=' . $row['customer_id'] . '" 
                    class="datatable-clickable"
                    title="View / Edit employee">
                    ' . htmlspecialchars($lab2) . '
                  </a>';
    }
  ),

  array(
    'db' => 'last_name',
    'dt' => 2,
    'field' => 'last_name',
    'formatter' => function ($lab3, $row) {
      return '<a href="../views/edit_details.php?module=inactive&customer_id=' . $row['customer_id'] . '">' . $lab3 . '</a>';
    }
  ),

  array(
    'db' => 'start_date_membership',
    'dt' => 3,
    'field' => 'start_date_membership',
    'formatter' => function ($lab5, $row) {
      $date = $row['start_date_membership'];
      if (!empty($date) && $date !== '0000-00-00' && $date !== '0000-00-00 00:00:00') {
        return date('F j, Y', strtotime($date));
      }
      return '-';
    }
  ),

  array(
    'db' => 'end_date_membership',
    'dt' => 4,
    'field' => 'end_date_membership',
    'formatter' => function ($lab5, $row) {
      $date = $row['end_date_membership'];
      if (!empty($date) && $date !== '0000-00-00' && $date !== '0000-00-00 00:00:00') {
        return date('F j, Y', strtotime($date));
      }
      return '-';
    }
  ),

  // Active/Inactive Badge
  array(
    'db' => 'start_date_membership',
    'dt' => 5,
    'field' => 'start_date_membership',
    'formatter' => function ($startDate, $row) {
      $today = date('Y-m-d'); // Manila timezone

      $isActive = ($row['start_date_membership'] <= $today && $row['end_date_membership'] >= $today);

      // Default styles
      $bgColor = '#adb5bd'; // gray
      $textColor = '#000';
      $statusText = 'Inactive';

      if ($isActive) {
        $bgColor = '#d4edda'; // green
        $textColor = '#155724';
        $statusText = 'Active';
      }

      return '
            <span style="
                display:inline-block;
                min-width:140px;
                height:30px;
                line-height:30px;
                text-align:center;
                border-radius:10px;
                background-color:' . $bgColor . ';
                color:' . $textColor . ';
                font-weight:600;
                font-size:13px;
            ">
                ' . $statusText . '
            </span>
        ';
    }
  ),

  array(
    'db' => 'customer_id',
    'dt' => 6,
    'field' => 'customer_id',
    'formatter' => function ($lab6, $row) {
      return '
                <div class="dropdown">
                    <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['customer_id'] . '" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['customer_id'] . '">
                        <a class="dropdown-item fetchDataEmployee" href="../views/edit_details.php?module=inactive&customer_id=' . $row['customer_id'] . '">View Details</a>
                        <a class="dropdown-item fetchDataEmployee" href="#">Deactivate</a>
                    </div>
                </div>';
    }
  ),
);

// Database connection details
include './../../connections/ssp_connection.php';

// Include the SSP class
require('./../../assets/datatables/ssp.class_with_where.php');

// Today's date in Manila

// WHERE clause for inactive customers excluding VIPs (membership_type_id = 4)
$now = date('Y-m-d H:i:s');

$where = "
membership_type_id != 4
AND (
    end_date_membership < '$now'
    OR start_date_membership IS NULL
    OR end_date_membership IS NULL
)
";

// Fetch and encode data
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
