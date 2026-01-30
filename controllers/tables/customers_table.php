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
                href="../views/edit_details.php?module=active&customer_id=' . $row['customer_id'] . '" 
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
      return '<a href="../views/edit_details.php?module=active&customer_id=' . $row['customer_id'] . '">' . $lab3 . '</a>';
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



  // Active Status Column
  array(
    'db' => 'start_date_membership',
    'dt' => 5,
    'field' => 'start_date_membership',
    'formatter' => function ($startDate, $row) {

      $today = date('Y-m-d');

      // Defaults
      $statusText = 'Inactive';
      $bgColor = '#adb5bd'; // gray
      $textColor = '#000';

      // VIP → always active
      if ($row['membership_type_id'] == 4) {
        $statusText = 'VIP';
        $bgColor = '#cce5ff'; // blue
        $textColor = '#004085';

        // Upcoming (future start date)
      } elseif (!empty($row['start_date_membership']) && $row['start_date_membership'] > $today) {
        $statusText = 'Upcoming';
        $bgColor = '#fff3cd'; // yellow
        $textColor = '#856404';

        // Active (within date range)
      } elseif (
        !empty($row['start_date_membership']) &&
        !empty($row['end_date_membership']) &&
        $row['start_date_membership'] <= $today &&
        $row['end_date_membership'] >= $today
      ) {
        $statusText = 'Active';
        $bgColor = '#d4edda'; // green
        $textColor = '#155724';
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
                <a class="dropdown-item fetchDataEmployee" href="../views/edit_details.php?module=active&customer_id=' . $row['customer_id'] . '">View Details</a>
                <a class="dropdown-item fetchDataEmployee" href="#">Deactivate</a>
            </div>
        </div>';
    }
  ),

  array(
    'db' => 'membership_type_id',
    'dt' => 7,
    'field' => 'membership_type_id',
    'formatter' => function ($lab1, $row) {
      return $row['membership_type_id'];
    }
  ),
);

// Database connection details
include './../../connections/ssp_connection.php';

// Include the SSP class
require('./../../assets/datatables/ssp.class_with_where.php');

// Filter: Include all records; VIPs will be counted active anyway
$today = date('Y-m-d');

$where = "
(
    start_date_membership <= '$today'
    AND end_date_membership >= '$today'
)
OR start_date_membership > '$today'
OR membership_type_id = 4
";
// Fetch and encode data
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
