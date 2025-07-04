<?php
include 'db.php';
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = json_decode(file_get_contents('php://input'), true);
$name = trim($data['name'] ?? '');
$teamGroup = trim($data['team'] ?? '');
$password = $data['password'] ?? '';
$balance = floatval($data['balance'] ?? 0);

if (!$name || !$password) {
  echo json_encode(['success' => false, 'error' => 'Missing name or password']);
  exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Check if player already exists
$stmt = $conn->prepare("SELECT name FROM players WHERE LOWER(name) = LOWER(?) LIMIT 1");
$stmt->bind_param("s", $name);
$stmt->execute();
$res = $stmt->get_result();
if ($res && $res->num_rows > 0) {
  echo json_encode(['success' => false, 'error' => 'Player already exists']);
  exit;
}

// Insert into correct SQL column: team_group
$stmt = $conn->prepare("INSERT INTO players (name, team_group, password, balance) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssd", $name, $teamGroup, $hashedPassword, $balance);

$success = $stmt->execute();
if (!$success) {
  echo json_encode(['success' => false, 'error' => 'DB error: ' . $conn->error]);
  exit;
}

echo json_encode(['success' => true]);
