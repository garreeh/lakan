<?php
include './../../connections/ssp_connection.php';
include './../../connections/connections.php';

// Get DataTables params
$dateFrom    = $_GET['date_from'] ?? null;
$dateTo      = $_GET['date_to'] ?? null;
$start       = $_GET['start'] ?? 0;
$length      = $_GET['length'] ?? 10;
$orderColumn = $_GET['order'][0]['column'] ?? 0;
$orderDir    = $_GET['order'][0]['dir'] ?? 'desc';
$searchValue = $_GET['search']['value'] ?? '';

// Columns mapping (update to include new columns)
$columns = ['customer_id', 'first_name', 'last_name', 'start_date', 'membership_type', 'membership_price'];
$orderBy = $columns[$orderColumn] ?? 'customer_id';

// Escape search value
$searchSql = '';
if (!empty($searchValue)) {
  $searchValue = $conn->real_escape_string($searchValue);
  $searchSql = " AND (
        c.first_name LIKE '%$searchValue%' OR
        c.last_name LIKE '%$searchValue%' OR
        cd.customer_id LIKE '%$searchValue%' OR
        cd.start_date LIKE '%$searchValue%' OR
        mt.membership_type_name LIKE '%$searchValue%' OR
        mt.membershiptype_price LIKE '%$searchValue%'
    )";
}

// Main UNION query with date filter and search
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
$searchSql
ORDER BY $orderBy $orderDir
LIMIT $start, $length
";

$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
  $data[] = [
    $row['customer_id'],
    $row['first_name'],
    $row['last_name'],
    !empty($row['start_date']) && $row['start_date'] != '0000-00-00'
      ? date('F j, Y', strtotime($row['start_date']))
      : '-',
    $row['membership_type_name'] ?? '-',
    isset($row['membership_price'])
      ? '₱' . number_format($row['membership_price'], 2)
      : '-'
  ];
}

// Total records (all customers)
$totalRecords = $conn->query("SELECT COUNT(*) FROM customer")->fetch_row()[0];

// Filtered records (with UNION and search)
$unionSql = "
SELECT cd.customer_id, cd.membership_type_id, cd.start_date
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
$searchSql
";

$filteredRecordsQuery = "SELECT COUNT(*) as count FROM ($unionSql) AS temp";
$filteredRecords = $conn->query($filteredRecordsQuery)->fetch_assoc()['count'];

// Return JSON for DataTables
echo json_encode([
  'draw' => intval($_GET['draw']),
  'recordsTotal' => intval($totalRecords),
  'recordsFiltered' => intval($filteredRecords),
  'data' => $data
]);
