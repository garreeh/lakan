<?php
// Set timezone to Manila
date_default_timezone_set('Asia/Manila');

// Get first and last day of the current month
$firstDay = date('Y-m-01 00:00:00');
$lastDay  = date('Y-m-t 23:59:59');

$monthLabel = date('F Y', strtotime($firstDay));

// Query total sales for this month
$salesQuery = $conn->query("
    SELECT SUM(membershiptype_price) as total_sales
    FROM customer c
    LEFT JOIN membership_history mh ON c.customer_id = mh.customer_id
    LEFT JOIN membership_type mt ON 
        (c.membership_type_id = mt.membership_type_id OR mh.membership_type_id = mt.membership_type_id)
    WHERE 
        ((c.start_date_membership BETWEEN '$firstDay' AND '$lastDay') 
         OR (mh.start_date BETWEEN '$firstDay' AND '$lastDay'))
");

$salesRow = $salesQuery->fetch_assoc();
$totalSalesMonth = $salesRow['total_sales'] ?? 0;
