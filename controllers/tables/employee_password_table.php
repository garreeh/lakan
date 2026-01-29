<?php

$table = 'employee_info';

$primaryKey = 'employee_id';

$columns = array(
    array(
        'db'   => 'employee_info.employee_id',
        'dt'   => 0,
        'field' => 'employee_id',
        'formatter' => function ($lab1, $row) {

            return $row['employee_id'];
        }
    ),

    array(
        'db'  => 'first_name',
        'dt'  => 1,
        'field' => 'first_name',
        'formatter' => function ($lab2, $row) {

            return $row['first_name'];
        }
    ),
    array(
        'db'  => 'last_name',
        'dt'  => 2,
        'field' => 'last_name',
        'formatter' => function ($lab3, $row) {

            return $row['last_name'];
        }
    ),

    array(
        'db'  => 'users.lakan_username',
        'dt'  => 3,
        'field' => 'lakan_username',
        'formatter' => function ($lab4, $row) {

            return $row['lakan_username'];
        }
    ),

    array(
        'db' => 'users.lakan_password',
        'dt' => 4,
        'field' => 'lakan_password',
        'formatter' => function ($lab5, $row) {
            $lakan_password = $row['lakan_password'];

            // $color = '#FFFFE0'; // Light Yellow
            $color = '#FFCCCB'; // Light Red

            // Set dimensions
            $width = '120px'; // Adjust the value as needed
            $height = '30px'; // Adjust the value as needed

            // Set border-radius
            $border_radius = '10px'; // Adjust the value as needed

            // Return the HTML with the specified styles
            return '<span style="display: inline-block; background-color: ' . $color . '; width: ' . $width . '; height: ' . $height . '; border-radius: ' . $border_radius . '; text-align: center; line-height: ' . $height . ';">' . $lakan_password . '</span>';
        }
    ),

);

$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'pendragonhr',
    'host' => 'localhost'
);


// $sql_details = array(
//     'user' => 'vetAID',
//     'pass' => 'greatcoal51',
//     'db'   => 'vetaid',
//     'host' => 'localhost'
// );

require('./../../assets/datatables/ssp.class.php');

// $where = "users.employee_id > 0 AND NOT EXISTS (
//     SELECT 1 FROM users 
//     WHERE users.employee_id = employee_info.employee_id
//     AND users.user_type_id = 1
// )";

$where = "user_type_id = 4 AND employment_status = 'Active'";

$joinQuery = "FROM $table LEFT JOIN users ON $table.employee_id = users.employee_id";


echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns,  $joinQuery, $where)
);
