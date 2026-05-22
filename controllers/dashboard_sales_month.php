<?php
include './../connections/connections.php';

date_default_timezone_set('Asia/Manila');

$firstDay = date('Y-m-01');
$lastDay = date('Y-m-t');
$monthLabel = date('F Y');

$totalMembershipSales = 0;
$totalWalkinSales = 0;

/* =========================
   CUSTOMER MEMBERSHIPS
========================= */
$membershipSql = "
SELECT 
    c.payment_type,
    c.down_payment_amount,
    c.start_date_membership,
    mt.membershiptype_price
FROM customer c
LEFT JOIN membership_type mt 
    ON c.membership_type_id = mt.membership_type_id
WHERE DATE(c.start_date_membership) 
    BETWEEN '$firstDay' AND '$lastDay'
";

$result = $conn->query($membershipSql);

while ($row = $result->fetch_assoc()) {

    if ($row['payment_type'] === 'Downpayment') {
        // ✅ ONLY downpayment (initial)
        $totalMembershipSales += (float) ($row['down_payment_amount'] ?? 0);
    } else {
        // ✅ Full payment / renewal
        $totalMembershipSales += (float) ($row['membershiptype_price'] ?? 0);
    }
}

/* =========================
   MEMBERSHIP HISTORY (RENEWALS)
========================= */
$membershipHistorySql = "
SELECT 
    mt.membershiptype_price AS amount
FROM membership_history mh
LEFT JOIN membership_type mt 
    ON mh.membership_type_id = mt.membership_type_id
WHERE DATE(mh.start_date) 
    BETWEEN '$firstDay' AND '$lastDay'
";

$result = $conn->query($membershipHistorySql);

while ($row = $result->fetch_assoc()) {
    $totalMembershipSales += (float) ($row['amount'] ?? 0);
}

/* =========================
   DOWNPAYMENT PARTIAL PAYMENTS
========================= */
$downpaymentSql = "
SELECT payment_amount AS amount
FROM downpayment_record_customer
WHERE DATE(created_at) 
    BETWEEN '$firstDay' AND '$lastDay'
";

$result = $conn->query($downpaymentSql);

while ($row = $result->fetch_assoc()) {
    // ✅ Add ALL partial payments
    $totalMembershipSales += (float) ($row['amount'] ?? 0);
}

/* =========================
   WALK-IN SALES
========================= */
$walkinSql = "
SELECT walk_in_price AS amount 
FROM walk_in 
WHERE DATE(created_at) 
    BETWEEN '$firstDay' AND '$lastDay'
";

$result = $conn->query($walkinSql);

while ($row = $result->fetch_assoc()) {
    $totalWalkinSales += (float) ($row['amount'] ?? 0);
}

/* =========================
   FINAL TOTAL
========================= */
$totalSalesMonth = $totalMembershipSales + $totalWalkinSales;
?>