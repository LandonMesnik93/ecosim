<?php
include 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'] ?? '';
$balance = floatval($data['balance'] ?? 0);

if (!$name) {
  echo json_encode(['success' => false, 'error' => 'Missing name']);
  exit;
}

$stmt = $conn->prepare("UPDATE players SET balance = ? WHERE name = ?");
$stmt->bind_param("ds", $balance, $name);
$success = $stmt->execute();

echo json_encode(['success' => $success]);
