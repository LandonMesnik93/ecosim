<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php'; // this file should connect to your MySQL database

$sql = "SELECT name, balance FROM players WHERE UPPER(name) != 'BANK' ORDER BY balance DESC";
$result = $conn->query($sql);

$players = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $players[] = [
            'name' => $row['name'],
            'balance' => floatval($row['balance'])
        ];
    }
}

echo json_encode($players);