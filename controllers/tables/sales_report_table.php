<?php
include './../../connections/ssp_connection.php';
include './../../connections/connections.php';

date_default_timezone_set('Asia/Manila');

$dateFrom = $_GET['date_from'] ?? null;
$dateTo = $_GET['date_to'] ?? null;
$start = $_GET['start'] ?? 0;
$length = $_GET['length'] ?? 10;
$orderColumn = $_GET['order'][0]['column'] ?? 0;
$orderDir = $_GET['order'][0]['dir'] ?? 'desc';
$searchValue = $_GET['search']['value'] ?? '';

$columns = ['customer_id', 'first_name', 'last_name', 'start_date', 'membership_type', 'membership_price'];
$orderByColumn = $columns[$orderColumn] ?? 'customer_id';

$data = [];

// 1️⃣ Fetch Memberships
$membershipSql = "
    SELECT cd.customer_id, c.first_name, c.last_name, cd.start_date, mt.membership_type_name AS membership_type, mt.membershiptype_price AS membership_price, cd.source
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
    // Append (Renewed) if source is history
    $membershipType = $row['membership_type'] ?? '-';
    if (($row['source'] ?? '') === 'history') {
      $membershipType .= ' (Renewed)';
    }

    $membershipPriceRaw = isset($row['membership_price']) ? $row['membership_price'] : 0;

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

// 2️⃣ Fetch Walk-Ins
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

    $walkinPriceRaw = isset($row['walk_in_price']) ? $row['walk_in_price'] : 0;
    $walkinType = ($row['walk_in_type'] ?? '-') . ' (Walk-In)';

    $data[] = [
      'customer_id' => $row['walk_id'],
      'first_name' => $firstName,
      'last_name' => $lastName,
      'start_date' => !empty($row['created_at']) ? date('F j, Y', strtotime($row['created_at'])) : '-',
      'start_date_only' => !empty($row['created_at']) ? date('Y-m-d', strtotime($row['created_at'])) : '',
      'membership_type' => $walkinType,
      'membership_price' => '₱' . number_format($walkinPriceRaw, 2),
      'membership_price_raw' => $walkinPriceRaw,
      'type' => 'Walk-In'
    ];
  }
}

// 3️⃣ Filter search if needed
if (!empty($searchValue)) {
  $searchValueLower = mb_strtolower($searchValue);
  $data = array_filter($data, function ($row) use ($searchValueLower) {
    foreach (['customer_id', 'first_name', 'last_name', 'membership_type'] as $col) {
      if (strpos(mb_strtolower((string) $row[$col]), $searchValueLower) !== false)
        return true;
    }
    // Check start_date by Y-m-d (ignore time)
    if (isset($row['start_date_only']) && strpos($row['start_date_only'], $searchValueLower) !== false)
      return true;
    // Check price as numeric
    if (is_numeric($searchValueLower) && isset($row['membership_price_raw'])) {
      if (floatval($row['membership_price_raw']) == floatval($searchValueLower))
        return true;
    }
    return false;
  });
}

// 4️⃣ Sort
usort($data, function ($a, $b) use ($orderByColumn, $orderDir) {
  $valA = $a[$orderByColumn];
  $valB = $b[$orderByColumn];

  if ($orderByColumn === 'start_date') {
    $valA = strtotime($a['start_date_only']);
    $valB = strtotime($b['start_date_only']);
  }

  if ($valA == $valB)
    return 0;

  return ($orderDir === 'asc') ? (($valA < $valB) ? -1 : 1) : (($valA > $valB) ? -1 : 1);
});

// 5️⃣ Paginate
$paginatedData = array_slice($data, $start, $length);

// 6️⃣ Return JSON for DataTables
echo json_encode([
  'draw' => intval($_GET['draw']),
  'recordsTotal' => intval(count($data)),
  'recordsFiltered' => intval(count($data)),
  'data' => array_map(function ($row) {
    return [
      $row['customer_id'],
      $row['first_name'],
      $row['last_name'],
      $row['start_date'],
      $row['membership_type'],
      $row['membership_price']
    ];
  }, $paginatedData)
]);