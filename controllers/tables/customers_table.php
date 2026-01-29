<?php

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
              href="../views/edit_employee.php?module=employees&customer_id=' . $row['customer_id'] . '" 
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
      return '<a href="../views/edit_employee.php?module=employees&customer_id=' . $row['customer_id'] . '">' . $lab3 . '</a>';
    }
  ),

  // array(
  //   'db' => 'employment_status',
  //   'dt' => 3,
  //   'field' => 'employment_status',
  //   'formatter' => function ($value, $row) {

  //     $status = strtolower(trim($row['employment_status']));

  //     // Default styles
  //     $bgColor = '#adb5bd'; // gray
  //     $textColor = '#000';

  //     if ($status === 'active') {
  //       $bgColor = '#d4edda'; // green
  //       $textColor = '#155724';
  //     } elseif ($status === 'terminated') {
  //       $bgColor = '#f8d7da'; // red
  //       $textColor = '#721c24';
  //     } elseif ($status === 'resigned') {
  //       $bgColor = '#fff3cd'; // warning yellow
  //       $textColor = '#856404';
  //     }

  //     return '
  //           <span style="
  //               display:inline-block;
  //               min-width:140px;
  //               height:30px;
  //               line-height:30px;
  //               text-align:center;
  //               border-radius:10px;
  //               background-color:' . $bgColor . ';
  //               color:' . $textColor . ';
  //               font-weight:600;
  //               font-size:13px;
  //           ">
  //               ' . htmlspecialchars($row['employment_status']) . '
  //           </span>
  //       ';
  //   }
  // ),

  array(
    'db' => 'start_date_membership',
    'dt' => 3,
    'field' => 'start_date_membership',
    'formatter' => function ($lab5, $row) {
      // Format date to 'F j, Y' (e.g., January 3, 2024)
      return date('F j, Y', strtotime($row['start_date_membership']));
    }
  ),

  array(
    'db' => 'end_date_membership',
    'dt' => 4,
    'field' => 'end_date_membership',
    'formatter' => function ($lab5, $row) {
      // Format date to 'F j, Y' (e.g., January 3, 2024)
      return date('F j, Y', strtotime($row['end_date_membership']));
    }
  ),

  array(
    'db' => 'customer_id',
    'dt' => 5,
    'field' => 'customer_id',
    'formatter' => function ($lab6, $row) {
      return '
                <div class="dropdown">
                    <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['customer_id'] . '" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['customer_id'] . '">
                        <a class="dropdown-item fetchDataEmployee" href="#">View Details</a>
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

// Define where clause if needed
$where = "account_status = 'Active'";

// Fetch and encode data
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
