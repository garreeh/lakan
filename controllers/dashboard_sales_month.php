<?php
include './../connections/connections.php'; // make sure connection is included

date_default_timezone_set('Asia/Manila'); // Set timezone

$firstDay = date('Y-m-01'); // First day of month
$lastDay = date('Y-m-t');    // Last day of month
$monthLabel = date('F Y', strtotime($firstDay));

$totalMembershipSales = 0;
$totalWalkinSales = 0;

// Memberships
$membershipSql = "SELECT mt.membershiptype_price AS amount
FROM customer c
LEFT JOIN membership_type mt ON c.membership_type_id = mt.membership_type_id
WHERE DATE(c.start_date_membership) BETWEEN '$firstDay' AND '$lastDay'";
$result = $conn->query($membershipSql);
while ($row = $result->fetch_assoc()) {
    $totalMembershipSales += $row['amount'] ?? 0;
}

// Membership history
$membershipHistorySql = "SELECT mt.membershiptype_price AS amount
FROM membership_history mh
LEFT JOIN membership_type mt ON mh.membership_type_id = mt.membership_type_id
WHERE DATE(mh.start_date) BETWEEN '$firstDay' AND '$lastDay'";
$result = $conn->query($membershipHistorySql);
while ($row = $result->fetch_assoc()) {
    $totalMembershipSales += $row['amount'] ?? 0;
}

// Walk-ins
$walkinSql = "SELECT walk_in_price AS amount FROM walk_in WHERE DATE(created_at) BETWEEN '$firstDay' AND '$lastDay'";
$result = $conn->query($walkinSql);
while ($row = $result->fetch_assoc()) {
    $totalWalkinSales += $row['amount'] ?? 0;
}

// Total sales
$totalSalesMonth = $totalMembershipSales + $totalWalkinSales;
?>