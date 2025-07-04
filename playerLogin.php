<?php
include 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'] ?? '';
$password = $data['password'] ?? '';

if (!$name || !$password) {
  http_response_code(400);
  echo json_encode(['error' => 'Name and password required.']);
  exit;
}

$nameEscaped = $conn->real_escape_string($name);

$sql = "SELECT name, `group`, store, password, balance, gunPermit, driversLicense 
        FROM players WHERE LOWER(name) = LOWER('$nameEscaped') LIMIT 1";

$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
  $player = $result->fetch_assoc();

  if (password_verify($password, $player['password'])) {
    // Remove password from response
    unset($player['password']);
    
    // Convert some fields if needed
    $player['balance'] = floatval($player['balance']);
    $player['gunPermit'] = (bool)$player['gunPermit'];
    $player['driversLicense'] = (bool)$player['driversLicense'];

    echo json_encode(['success' => true, 'player' => $player]);
    exit;
  }
}

http_response_code(401);
echo json_encode(['error' => 'Invalid name or password.']);
exit;