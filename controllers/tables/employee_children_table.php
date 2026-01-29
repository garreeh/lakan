<?php
session_start();

$table = 'children';

$primaryKey = 'children_id';

$columns = array(
    array(
        'db'   => 'name_of_children',
        'dt'   => 0,
        'field' => 'name_of_children',
        'formatter' => function ($lab1, $row) {

            return $row['name_of_children'];
        }
    ),

    array(
        'db'   => 'children_sex',
        'dt'   => 1,
        'field' => 'children_sex',
        'formatter' => function ($lab1, $row) {

            return $row['children_sex'];
        }
    ),

    array(
        'db'   => 'children_dateofbirth',
        'dt'   => 2,
        'field' => 'children_dateofbirth',
        'formatter' => function ($lab1, $row) {

            return $row['children_dateofbirth'];
        }
    ),

);

$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'pendragonhr',
    'host' => 'localhost'
);

$employee_id = $_SESSION['employee_id'];

// $sql_details = array(
//     'user' => 'vetAID',
//     'pass' => 'greatcoal51',
//     'db'   => 'vetaid',
//     'host' => 'localhost'
// );

require('./../../assets/datatables/ssp.class.php');

$where = "children.employee_id = $employee_id";

$joinQuery = "FROM $table LEFT JOIN users ON $table.employee_id = users.employee_id";


echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where)
);
