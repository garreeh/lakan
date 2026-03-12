<?php
include './../connections/connections.php';

date_default_timezone_set('Asia/Manila'); // Set PHP timezone to Manila

if (isset($_POST['searchSalesReport'])) {

  $dateFrom = $_POST['date_from'] ?? null;
  $dateTo = $_POST['date_to'] ?? null;

  if (!$dateFrom || !$dateTo) {
    echo json_encode(['error' => 'Please provide both Date From and Date To.']);
    exit;
  }

  $data = [];

  // 1️⃣ Fetch Memberships (customer + membership_history)
  $membershipSql = "
        SELECT cd.customer_id, c.first_name, c.last_name, cd.start_date, 
               mt.membership_type_name AS membership_type, mt.membershiptype_price AS membership_price, cd.source
        FROM (
            SELECT customer_id, start_date_membership AS start_date, membership_type_id, 'customer' AS source
            FROM customer
            WHERE start_date_membership IS NOT NULL AND start_date_membership != '0000-00-00 00:00:00'
            AND DATE(start_date_membership) BETWEEN '$dateFrom' AND '$dateTo'
            UNION ALL
            SELECT customer_id, start_date AS start_date, membership_type_id, 'history' AS source
            FROM membership_history
            WHERE start_date IS NOT NULL AND start_date != '0000-00-00 00:00:00'
            AND DATE(start_date) BETWEEN '$dateFrom' AND '$dateTo'
        ) AS cd
        LEFT JOIN customer c ON cd.customer_id = c.customer_id
        LEFT JOIN membership_type mt ON cd.membership_type_id = mt.membership_type_id
        ORDER BY cd.start_date ASC
    ";

  $membershipResult = $conn->query($membershipSql);
  if ($membershipResult) {
    while ($row = $membershipResult->fetch_assoc()) {
      $membershipType = $row['membership_type'] ?? '-';
      if (($row['source'] ?? '') === 'history') {
        $membershipType .= ' (Renewed)';
      }

      $membershipPriceRaw = $row['membership_price'] ?? 0;

      $data[] = [
        'customer_id' => $row['customer_id'],
        'first_name' => $row['first_name'] ?? '-',
        'last_name' => $row['last_name'] ?? '-',
        'start_date' => !empty($row['start_date']) ? date('F j, Y', strtotime($row['start_date'])) : '-',
        'start_date_only' => !empty($row['start_date']) ? date('Y-m-d', strtotime($row['start_date'])) : '',
        'membership_type' => $membershipType,
        'membership_price' => '₱' . number_format($membershipPriceRaw, 2),
        'membership_price_raw' => $membershipPriceRaw,
        'type' => 'Membership'
      ];
    }
  }

  // 2️⃣ Fetch Walk-Ins (compare only date part)
  $walkinSql = "
        SELECT walk_id, walk_in_name, created_at, walk_in_type, walk_in_price
        FROM walk_in
        WHERE DATE(created_at) BETWEEN '$dateFrom' AND '$dateTo'
        ORDER BY created_at ASC
    ";

  $walkinResult = $conn->query($walkinSql);
  if ($walkinResult) {
    while ($row = $walkinResult->fetch_assoc()) {
      $fullName = trim($row['walk_in_name'] ?? '');
      if ($fullName === '') {
        $firstName = '-';
        $lastName = '-';
      } else {
        $parts = explode(' ', $fullName);
        if (count($parts) === 1) {
          $firstName = $parts[0];
          $lastName = '-';
        } else {
          $lastName = array_pop($parts);
          $firstName = implode(' ', $parts);
        }
      }

      $walkinPriceRaw = $row['walk_in_price'] ?? 0;
      $walkinType = ($row['walk_in_type'] ?? 'Member') . ' (Walk-In)';

      $data[] = [
        'customer_id' => $row['walk_id'],
        'first_name' => $firstName,
        'last_name' => $lastName,
        'start_date' => !empty($row['created_at']) ? date('F j, Y H:i:s', strtotime($row['created_at'])) : '-',
        'start_date_only' => !empty($row['created_at']) ? date('Y-m-d', strtotime($row['created_at'])) : '',
        'membership_type' => $walkinType,
        'membership_price' => '₱' . number_format($walkinPriceRaw, 2),
        'membership_price_raw' => $walkinPriceRaw,
        'type' => 'Walk-In'
      ];
    }
  }

  // 3️⃣ Sort all combined data by start_date_only
  usort($data, function ($a, $b) {
    return strtotime($a['start_date_only']) <=> strtotime($b['start_date_only']);
  });

  // 4️⃣ Calculate totals
  $totalMembershipSales = array_sum(array_column(
    array_filter($data, fn($d) => $d['type'] === 'Membership'),
    'membership_price_raw'
  ));

  $totalWalkinSales = array_sum(array_column(
    array_filter($data, fn($d) => $d['type'] === 'Walk-In'),
    'membership_price_raw'
  ));

  $totalSales = $totalMembershipSales + $totalWalkinSales;

  // 5️⃣ Return JSON response
  echo json_encode([
    'success' => true,
    'date_from' => $dateFrom,
    'date_to' => $dateTo,
    'data' => $data,
    'totals' => [
      'membership_sales' => $totalMembershipSales,
      'walkin_sales' => $totalWalkinSales,
      'total_sales' => $totalSales
    ]
  ]);
  exit;
}

echo json_encode(['error' => 'Invalid request.']);