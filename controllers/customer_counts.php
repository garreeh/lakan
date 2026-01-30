<?php
$today = date('Y-m-d');

/* =====================
   ACTIVE MEMBERS
   ===================== */
/*
Includes:
- VIP (membership_type_id = 4)
- Active (today within range)
- Upcoming (start_date > today)
*/
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


/* =====================
   EXPIRED MEMBERS
   ===================== */
/*
Includes:
- Non-VIP only
- Ended memberships
(matches Inactive table logic)
*/
$expiredQuery = "
  SELECT COUNT(*) AS total_expired
  FROM customer
  WHERE
    membership_type_id != 4
    AND DATE(end_date_membership) < '$today'
";
$expiredResult = mysqli_query($conn, $expiredQuery);
$expiredCount = mysqli_fetch_assoc($expiredResult)['total_expired'] ?? 0;
