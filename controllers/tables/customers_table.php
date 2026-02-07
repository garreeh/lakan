<?php

date_default_timezone_set('Asia/Manila');

$table = 'customer';
$primaryKey = 'customer_id';

$columns = array(

  array(
    'db' => 'customer_id',
    'dt' => 0,
    'field' => 'customer_id'
  ),

  array(
    'db' => 'first_name',
    'dt' => 1,
    'field' => 'first_name',
    'formatter' => function ($val, $row) {
      return '<a href="../views/edit_details.php?module=active&customer_id=' . $row['customer_id'] . '" class="datatable-clickable">
                        ' . htmlspecialchars($val) . '
                    </a>';
    }
  ),

  array(
    'db' => 'last_name',
    'dt' => 2,
    'field' => 'last_name',
    'formatter' => function ($val, $row) {
      return '<a href="../views/edit_details.php?module=active&customer_id=' . $row['customer_id'] . '">
                        ' . htmlspecialchars($val) . '
                    </a>';
    }
  ),

  array(
    'db' => 'start_date_membership',
    'dt' => 3,
    'field' => 'start_date_membership',
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
    'db' => 'end_date_membership',
    'dt' => 4,
    'field' => 'end_date_membership',
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
    'db' => 'start_date_membership',
    'dt' => 5,
    'field' => 'start_date_membership',
    'formatter' => function ($val, $row) {

      $today = strtotime(date('Y-m-d'));
      $start = !empty($row['start_date_membership']) ? strtotime($row['start_date_membership']) : null;
      $end   = !empty($row['end_date_membership']) ? strtotime($row['end_date_membership']) : null;

      $statusText = 'Inactive';
      $bgColor = '#adb5bd';
      $textColor = '#000';

      if ($row['membership_type_id'] == 4) {
        $statusText = 'VIP';
        $bgColor = '#cce5ff';
        $textColor = '#004085';
      } elseif ($start && $start > $today) {
        $statusText = 'Upcoming';
        $bgColor = '#fff3cd';
        $textColor = '#856404';
      } elseif ($start && $end && $start <= $today && $end >= $today) {
        $statusText = 'Active';
        $bgColor = '#d4edda';
        $textColor = '#155724';
      }

      return '<span style="
                        display:inline-block;
                        min-width:140px;
                        height:30px;
                        line-height:30px;
                        text-align:center;
                        border-radius:10px;
                        background-color:' . $bgColor . ';
                        color:' . $textColor . ';
                        font-weight:600;
                        font-size:13px;">
                        ' . $statusText . '
                    </span>';
    }
  ),

  array(
    'db' => 'customer_id',
    'dt' => 6,
    'field' => 'customer_id',
    'formatter' => function ($val, $row) {
      return '
            <div class="dropdown">
                <button class="btn btn-info" type="button" data-bs-toggle="dropdown">
                    &#x22EE;
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="../views/edit_details.php?module=active&customer_id=' . $row['customer_id'] . '">
                        View Details
                    </a>
                </div>
            </div>';
    }
  ),

  // IMPORTANT: searchable hidden column
  array(
    'db' => 'membership_type_id',
    'dt' => 7,
    'field' => 'membership_type_id'
  ),
);

include './../../connections/ssp_connection.php';
require './../../assets/datatables/ssp.class_with_where.php';

$today = date('Y-m-d');

/**
 * ✅ WRAPPED WHERE (THIS FIXES SEARCH)
 */
$where = "
(
    (start_date_membership <= '$today' AND end_date_membership >= '$today')
    OR start_date_membership > '$today'
    OR membership_type_id = 4
)
";

echo json_encode(
  SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where)
);
