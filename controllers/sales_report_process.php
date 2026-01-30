<?php
include './../connections/connections.php';

if (isset($_POST['searchSalesReport'])) {

  $dateFrom = $_POST['date_from'] ?? null;
  $dateTo   = $_POST['date_to'] ?? null;

  if (!$dateFrom || !$dateTo) {
    echo json_encode(['error' => 'Please provide both Date From and Date To.']);
    exit;
  }

  // Main UNION query to get membership data
  $sql = "
    SELECT cd.customer_id, cd.start_date, c.first_name, c.last_name, mt.membership_type_name, mt.membershiptype_price AS membership_price
    FROM (
        SELECT customer_id, start_date_membership AS start_date, membership_type_id
        FROM customer
        WHERE start_date_membership IS NOT NULL
          AND start_date_membership != '0000-00-00 00:00:00'
        UNION ALL
        SELECT customer_id, start_date AS start_date, membership_type_id
        FROM membership_history
        WHERE start_date IS NOT NULL
          AND start_date != '0000-00-00 00:00:00'
    ) AS cd
    LEFT JOIN customer c ON cd.customer_id = c.customer_id
    LEFT JOIN membership_type mt ON cd.membership_type_id = mt.membership_type_id
    WHERE cd.start_date BETWEEN '$dateFrom' AND '$dateTo'
    ORDER BY cd.start_date ASC
    ";

  $result = $conn->query($sql);

  $data = [];
  while ($row = $result->fetch_assoc()) {
    $data[] = [
      'customer_id' => $row['customer_id'],
      'first_name' => $row['first_name'],
      'last_name' => $row['last_name'],
      'start_date' => !empty($row['start_date']) && $row['start_date'] != '0000-00-00'
        ? date('F j, Y', strtotime($row['start_date']))
        : '-',
      'membership_type' => $row['membership_type'] ?? '-',
      'membership_price' => isset($row['membership_price'])
        ? '₱' . number_format($row['membership_price'], 2)
        : '-'
    ];
  }

  echo json_encode([
    'success' => true,
    'date_from' => $dateFrom,
    'date_to' => $dateTo,
    'data' => $data
  ]);
  exit;
}

echo json_encode(['error' => 'Invalid request.']);
