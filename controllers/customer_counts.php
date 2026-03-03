<?php
// Manila Timezone
date_default_timezone_set('Asia/Manila');

$today = date('Y-m-d');

// FOR ACTIVE SUBS
$activeQuery = "
  SELECT COUNT(*) AS total_active
  FROM customer
  WHERE
    membership_type_id = 4
    OR DATE(start_date_membership) >= '$today'
    OR (
        DATE(start_date_membership) <= '$today'
        AND DATE(end_date_membership) >= '$today'
    )
";
$activeResult = mysqli_query($conn, $activeQuery);
$activeCount = mysqli_fetch_assoc($activeResult)['total_active'] ?? 0;


// FOR EXPIRED SUBS
$expiredQuery = "
  SELECT COUNT(*) AS total_expired
  FROM customer
  WHERE
    (is_paused = 0 OR is_paused IS NULL)
    AND membership_type_id != 4
    AND DATE(end_date_membership) < '$today'
";
$expiredResult = mysqli_query($conn, $expiredQuery);
$expiredCount = mysqli_fetch_assoc($expiredResult)['total_expired'] ?? 0;


// FOR PAUSED SUBS
$pausedQuery = "
  SELECT COUNT(*) AS total_paused
  FROM customer
  WHERE is_paused = 1
";
$pausedResult = mysqli_query($conn, $pausedQuery);
$pausedCount = mysqli_fetch_assoc($pausedResult)['total_paused'] ?? 0;