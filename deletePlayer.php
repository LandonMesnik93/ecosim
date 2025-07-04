<?php
include 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$name = trim($data['name'] ?? '');

if (!$name) {
  echo json_encode(['success' => false, 'error' => 'Missing player name']);
  exit;
}

$stmt = $conn->prepare("DELETE FROM players WHERE name = ?");
$stmt->bind_param("s", $name);
$success = $stmt->execute();

echo json_encode(['success' => $success]);
