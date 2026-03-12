<?php

// Define table and primary key
$table = 'walk_in';
$primaryKey = 'walk_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'walk_id',
    'dt' => 0,
    'field' => 'walk_id',
    'formatter' => function ($lab1, $row) {
      return $row['walk_id'];
    }
  ),

  array(
    'db' => 'walk_in_type',
    'dt' => 1,
    'field' => 'walk_in_type',
    'formatter' => function ($lab2, $row) {
      return $row['walk_in_type'];
    }
  ),

  array(
    'db' => 'walk_in_price',
    'dt' => 2,
    'field' => 'walk_in_price',
    'formatter' => function ($walkInPrice, $row) {
      return isset($walkInPrice) ? '₱ ' . number_format($walkInPrice, 2) : '-';
    }
  ),

  array(
    'db' => 'created_at',
    'dt' => 3,
    'field' => 'created_at',
    'formatter' => function ($val) {
      if (
        empty($val) ||
        $val === '0000-00-00' ||
        $val === '0000-00-00 00:00:00'
      ) {
        return '-';
      }
      return date('F j, Y', strtotime($val));
    }
  ),

  array(
    'db' => 'walk_in_name',
    'dt' => 4,
    'field' => 'walk_in_name',
    'formatter' => function ($lab2, $row) {
      return !empty($row['walk_in_name']) ? $row['walk_in_name'] : '-';
    }
  ),
);

// Database connection details
include './../../connections/ssp_connection.php';

// Include the SSP class
require('./../../assets/datatables/ssp.class_with_where.php');

// Define where clause if needed
$where = "walk_id";

// Fetch and encode data
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
