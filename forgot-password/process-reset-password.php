<?php
header('Content-Type: application/json');

$token = $_POST["token"] ?? '';
$password = $_POST["password"] ?? '';
$password_confirmation = $_POST["password_confirmation"] ?? '';

if (!$token) {
    echo json_encode(["status" => "error", "message" => "No token provided."]);
    exit();
}

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM user WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    echo json_encode(["status" => "error", "message" => "Token not found."]);
    exit();
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    echo json_encode(["status" => "error", "message" => "Token has expired."]);
    exit();
}

// Server-side password validation
if (strlen($password) < 8) {
    echo json_encode(["status" => "error", "message" => "Password must be at least 8 characters."]);
    exit();
}

if (!preg_match("/[a-z]/i", $password)) {
    echo json_encode(["status" => "error", "message" => "Password must contain at least one letter."]);
    exit();
}

if (!preg_match("/[0-9]/", $password)) {
    echo json_encode(["status" => "error", "message" => "Password must contain at least one number."]);
    exit();
}

if ($password !== $password_confirmation) {
    echo json_encode(["status" => "error", "message" => "Passwords must match."]);
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$sql = "UPDATE user
        SET password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si", $hashedPassword, $user["id"]);
$stmt->execute();

echo json_encode(["status" => "success", "message" => "Password updated successfully! You will be redirected to the login page shortly."]);
exit();
