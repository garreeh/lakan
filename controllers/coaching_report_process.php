<?php
include './../connections/connections.php';

// Initialize response
$response = [
  'success' => false,
  'data' => [],
  'total_sales' => '₱ 0.00'
];

// Check if AJAX is for coaching report
if (isset($_POST['searchCoachingReport'])) {

  $date_from = isset($_POST['date_from']) ? $_POST['date_from'] : '';
  $date_to = isset($_POST['date_to']) ? $_POST['date_to'] : '';

  if ($date_from && $date_to) {

    // Query coaching sessions in date range
    $query = "SELECT coaching_price FROM coaching_service 
                  WHERE coaching_date BETWEEN '$date_from' AND '$date_to'";

    $result = $conn->query($query);

    if ($result) {
      $totalSales = 0;
      $data = [];

      while ($row = $result->fetch_assoc()) {
        $data[] = $row;

        // Sum the prices (make sure numeric)
        $price = is_numeric($row['coaching_price']) ? $row['coaching_price'] : 0;
        $totalSales += $price;
      }

      $response['success'] = true;
      $response['data'] = $data;
      $response['total_sales'] = '₱ ' . number_format($totalSales, 2);
    }
  }
}

// Return JSON
echo json_encode($response);
?>