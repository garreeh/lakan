<?php

// Define table and primary key
$table = 'users';
$primaryKey = 'emp_id';
// Define columns for DataTables
$columns = array(
    array(
        'db' => 'emp_id',
        'dt' => 0,
        'field' => 'emp_id',
        'formatter' => function ($lab1, $row) {
            return $row['emp_id'];
        }
    ),

    array(
        'db' => 'employee_number',
        'dt' => 1,
        'field' => 'employee_number',
        'formatter' => function ($lab2, $row) {
            // return $row['emp_firstname'];
            return '<a href="../views/edit_employee.php?module=employees&emp_id=' . $row['emp_id'] . '">' . $lab2 . '</a>';
        }
    ),

    array(
        'db' => 'emp_firstname',
        'dt' => 2,
        'field' => 'emp_firstname',
        'formatter' => function ($lab2, $row) {
            // return $row['emp_firstname'];
            return '<a href="../views/edit_employee.php?module=employees&emp_id=' . $row['emp_id'] . '">' . $lab2 . '</a>';
        }
    ),

    array(
        'db' => 'emp_lastname',
        'dt' => 3,
        'field' => 'emp_lastname',
        'formatter' => function ($lab3, $row) {
            return '<a href="../views/edit_employee.php?module=employees&emp_id=' . $row['emp_id'] . '">' . $lab3 . '</a>';
        }
    ),

    array(
        'db' => 'employment_status',
        'dt' => 4,
        'field' => 'employment_status',
        'formatter' => function ($value, $row) {

            $status = strtolower(trim($row['employment_status']));

            // Default styles
            $bgColor = '#adb5bd'; // gray
            $textColor = '#000';

            if ($status === 'active') {
                $bgColor = '#d4edda'; // green
                $textColor = '#155724';
            } elseif ($status === 'terminated') {
                $bgColor = '#f8d7da'; // red
                $textColor = '#721c24';
            } elseif ($status === 'resigned') {
                $bgColor = '#fff3cd'; // warning yellow
                $textColor = '#856404';
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
                ' . htmlspecialchars($row['employment_status']) . '
            </span>
        ';
        }
    ),

    array(
        'db' => 'date_hired',
        'dt' => 5,
        'field' => 'date_hired',
        'formatter' => function ($lab5, $row) {
            // Format date to 'F j, Y' (e.g., January 3, 2024)
            return date('F j, Y', strtotime($row['date_hired']));
        }
    ),

    array(
        'db' => 'emp_id',
        'dt' => 6,
        'field' => 'emp_id',
        'formatter' => function ($lab6, $row) {
            return '
                <div class="dropdown">
                    <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['emp_id'] . '" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['emp_id'] . '">
                        <a class="dropdown-item fetchDataEmployee" href="#">Activate</a>
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
$where = "employment_status != 'Active'";

// Fetch and encode data
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
