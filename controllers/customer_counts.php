<?php
$today = date('Y-m-d');

/* ACTIVE MEMBERS */
// Include VIPs as always active
$activeQuery = "
  SELECT COUNT(*) AS total_active
  FROM customer
  WHERE (membership_type_id = 4 OR (start_date_membership <= '$today' AND end_date_membership >= '$today'))
";
$activeResult = mysqli_query($conn, $activeQuery);
$activeCount = mysqli_fetch_assoc($activeResult)['total_active'] ?? 0;

/* EXPIRED MEMBERS */
// Exclude VIPs from expired
$expiredQuery = "
  SELECT COUNT(*) AS total_expired
  FROM customer
  WHERE membership_type_id != 4 
    AND end_date_membership < '$today'
";
$expiredResult = mysqli_query($conn, $expiredQuery);
$expiredCount = mysqli_fetch_assoc($expiredResult)['total_expired'] ?? 0;
