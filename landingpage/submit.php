<?php
$servername = "127.0.0.1";
$username = "root";
$password = "4Shyn.zyyy20";
$dbname = "final";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
  http_response_code(500);
  echo "Database connection failed.";
  exit();
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$name || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo "Invalid input.";
  exit();
}

$stmt = $conn->prepare("INSERT INTO submissions (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
  http_response_code(200);
  echo "Success";
} else {
  http_response_code(500);
  echo "Database error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
