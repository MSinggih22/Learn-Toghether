<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lt";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create a PDO instance
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Check if the user is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['token'])) {
    // Get the user ID and session token from the session
    $user_id = $_SESSION['user_id'];
    $token = $_SESSION['token'];

    // Delete the session from the sessions table
    $stmt = $pdo->prepare('DELETE FROM sessions WHERE user_id = :user_id AND token = :token');
    $stmt->execute(['user_id' => $user_id, 'token' => $token]);
}

// Clear all session data
session_unset();

session_destroy();

header('Location: index.php');
exit();
