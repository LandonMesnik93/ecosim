<?php
include 'db.php';
header('Content-Type: application/json');

$sql = "SELECT name, team_group, balance FROM players WHERE name != 'BANK' ORDER BY balance DESC";
$result = $conn->query($sql);

$players = [];

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $players[] = [
      'name' => $row['name'],
      'team' => $row['team_group'],
      'balance' => floatval($row['balance'])
    ];
  }
}

echo json_encode($players);
