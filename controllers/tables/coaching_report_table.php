<?php

// Define table and primary key
$table = 'coaching_service';
$primaryKey = 'coaching_id';

// Define columns for DataTables
$columns = array(
  array(
    'db' => 'coaching_id',
    'dt' => 0,
    'field' => 'coaching_id',
    'formatter' => function ($lab1, $row) {
      return $row['coaching_id'];
    }
  ),

  array(
    'db' => 'client_fullname',
    'dt' => 1,
    'field' => 'client_fullname',
    'formatter' => function ($lab1, $row) {
      return $row['client_fullname'];
    }
  ),

  array(
    'db' => 'coaching_type',
    'dt' => 2,
    'field' => 'coaching_type',
    'formatter' => function ($type, $row) {

      // Define badge colors for each type
      $badgeColors = [
        'Platinum' => '#6c757d',          // Gray
        'Gold' => '#ffc107',              // Gold
        'Silver' => '#c0c0c0',            // Silver
        'Bronze' => '#cd7f32',            // Bronze
        'Single Session' => '#17a2b8',    // Blue
        'Platinum (Promo)' => '#6c757d',  // Dark Gray
        'Gold (Promo)' => '#e0a800',      // Dark Gold
        'Silver (Promo)' => '#a9a9a9',    // Darker Silver
      ];

      $color = isset($badgeColors[$type]) ? $badgeColors[$type] : '#000000';

      // Return a badge-like styled span
      return '<span style="
                  display: inline-block;
                  padding: 4px 10px;
                  border-radius: 12px;
                  font-weight: bold;
                  color: #fff;
                  background-color: ' . $color . ';
                  font-size: 0.9em;
                  text-align: center;
              ">' . $type . '</span>';
    }
  ),

  array(
    'db' => 'coaching_price',
    'dt' => 3, // column index in DataTable
    'field' => 'coaching_price',
    'formatter' => function ($price, $row) {
      return '₱ ' . number_format($price, 2);
    }
  ),

  array(
    'db' => 'coaching_date',
    'dt' => 4,
    'field' => 'coaching_date',
    'formatter' => function ($date, $row) {
      return date('F j, Y', strtotime($row['coaching_date']));
    }
  ),


);

// Database connection details
include '../../connections/ssp_connection.php';


// Include the SSP class
require('../../assets/datatables/ssp.class_with_where.php');

$dateFrom = isset($_GET['date_from']) ? $_GET['date_from'] : null;
$dateTo = isset($_GET['date_to']) ? $_GET['date_to'] : null;

// Build the where condition
$where = "coaching_date BETWEEN '$dateFrom' AND '$dateTo'";

// Fetch and encode JOIN AND WHERE
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));