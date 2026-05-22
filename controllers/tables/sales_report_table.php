<?php
include './../../connections/ssp_connection.php';
include './../../connections/connections.php';

date_default_timezone_set('Asia/Manila');

$dateFrom = $_GET['date_from'] ?? date('Y-m-01');
$dateTo = $_GET['date_to'] ?? date('Y-m-d');

$start = $_GET['start'] ?? 0;
$length = $_GET['length'] ?? 10;
$orderColumn = $_GET['order'][0]['column'] ?? 0;
$orderDir = $_GET['order'][0]['dir'] ?? 'desc';

$data = [];
$seen = [];

/* =========================
   1️⃣ MEMBERSHIP SALES
========================= */
$membershipSql = "
    SELECT 
        cd.customer_id,
        c.first_name,
        c.last_name,
        cd.start_date,
        mt.membership_type_name AS membership_type,
        mt.membershiptype_price AS membership_price,
        c.payment_type,
        c.down_payment_amount,
        cd.source
    FROM (
        SELECT customer_id, start_date_membership AS start_date, membership_type_id, 'customer' AS source
        FROM customer
        WHERE start_date_membership IS NOT NULL
        AND DATE(start_date_membership) BETWEEN '$dateFrom' AND '$dateTo'

        UNION ALL

        SELECT customer_id, start_date AS start_date, membership_type_id, 'history' AS source
        FROM membership_history
        WHERE start_date IS NOT NULL
        AND DATE(start_date) BETWEEN '$dateFrom' AND '$dateTo'
    ) AS cd
    LEFT JOIN customer c ON cd.customer_id = c.customer_id
    LEFT JOIN membership_type mt ON cd.membership_type_id = mt.membership_type_id
";

$membershipResult = $conn->query($membershipSql);

if ($membershipResult) {
  while ($row = $membershipResult->fetch_assoc()) {

    $ts = strtotime($row['start_date']);

    if (!$ts || $ts < 0)
      continue;

    if (strtolower($row['membership_type'] ?? '') === 'vip')
      continue;

    $key = $row['customer_id'] . '-membership-' . $ts;
    if (isset($seen[$key]))
      continue;
    $seen[$key] = true;

    $paymentType = $row['payment_type'] ?? null;
    $membershipName = $row['membership_type'] ?? '-';

    $membershipLabel = $membershipName;

    // Renewal label
    if (($row['source'] ?? '') === 'history') {
      $membershipLabel .= ' (Renewal)';
    }

    // 🔥 MAIN LOGIC
    if ($paymentType === 'Downpayment') {

      $amount = (float) ($row['down_payment_amount'] ?? 0);

      // ✅ YOUR REQUEST
      $membershipLabel = 'Down (Initial) - ' . $membershipName;

      $type = 'Downpayment';

    } else {

      $amount = (float) ($row['membership_price'] ?? 0);
      $type = 'Membership';
    }

    $data[] = [
      'customer_id' => $row['customer_id'],
      'first_name' => $row['first_name'] ?? '-',
      'last_name' => $row['last_name'] ?? '-',

      'start_date' => date('F j, Y', $ts),
      'start_date_only' => date('Y-m-d', $ts),
      'timestamp' => $ts,

      'membership_type' => $membershipLabel,
      'membership_price' => '₱' . number_format($amount, 2),
      'membership_price_raw' => $amount,
      'type' => $type
    ];
  }
}

/* =========================
   2️⃣ WALK-IN SALES
========================= */
$walkinSql = "
    SELECT walk_id, walk_in_name, created_at, walk_in_type, walk_in_price
    FROM walk_in
    WHERE DATE(created_at) BETWEEN '$dateFrom' AND '$dateTo'
";

$walkinResult = $conn->query($walkinSql);

if ($walkinResult) {
  while ($row = $walkinResult->fetch_assoc()) {

    $ts = strtotime($row['created_at']);
    if (!$ts || $ts < 0)
      continue;

    $key = $row['walk_id'] . '-walkin-' . $ts;
    if (isset($seen[$key]))
      continue;
    $seen[$key] = true;

    $parts = explode(' ', trim($row['walk_in_name'] ?? ''));
    $firstName = $parts[0] ?? '-';
    $lastName = count($parts) > 1 ? end($parts) : '-';

    $amount = (float) ($row['walk_in_price'] ?? 0);

    $data[] = [
      'customer_id' => $row['walk_id'],
      'first_name' => $firstName,
      'last_name' => $lastName,

      'start_date' => date('F j, Y', $ts),
      'start_date_only' => date('Y-m-d', $ts),
      'timestamp' => $ts,

      'membership_type' => ($row['walk_in_type'] ?? '-') . ' (Walk-In)',
      'membership_price' => '₱' . number_format($amount, 2),
      'membership_price_raw' => $amount,
      'type' => 'Walk-In'
    ];
  }
}

/* =========================
   3️⃣ DOWNPAYMENT RECORDS
========================= */
$dpSql = "
    SELECT 
      dprh.customer_id,
      dprh.payment_amount,
      dprh.created_at,
      c.first_name,
      c.last_name
    FROM downpayment_record_customer dprh
    LEFT JOIN customer c ON c.customer_id = dprh.customer_id
    WHERE DATE(dprh.created_at) BETWEEN '$dateFrom' AND '$dateTo'
";

$dpResult = $conn->query($dpSql);

if ($dpResult) {
  while ($row = $dpResult->fetch_assoc()) {

    $ts = strtotime($row['created_at']);
    if (!$ts || $ts < 0)
      continue;

    $amount = (float) $row['payment_amount'];

    $data[] = [
      'customer_id' => $row['customer_id'],
      'first_name' => $row['first_name'] ?? '-',
      'last_name' => $row['last_name'] ?? '-',

      'start_date' => date('F j, Y H:i:s', $ts),
      'start_date_only' => date('Y-m-d', $ts),
      'timestamp' => $ts,

      'membership_type' => 'Downpayment (Payment)',
      'membership_price' => '₱' . number_format($amount, 2),
      'membership_price_raw' => $amount,
      'type' => 'Downpayment'
    ];
  }
}

/* =========================
   4️⃣ SORT
========================= */
usort($data, function ($a, $b) use ($orderDir) {
  return $orderDir === 'asc'
    ? ($a['timestamp'] <=> $b['timestamp'])
    : ($b['timestamp'] <=> $a['timestamp']);
});

/* =========================
   5️⃣ PAGINATION
========================= */
$paginatedData = array_slice($data, $start, $length);

/* =========================
   6️⃣ RESPONSE
========================= */
echo json_encode([
  'draw' => intval($_GET['draw'] ?? 1),
  'recordsTotal' => count($data),
  'recordsFiltered' => count($data),
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