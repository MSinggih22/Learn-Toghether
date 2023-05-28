<?php
session_start();
include 'db/db-connect.php';

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

if (isset($_SESSION['user_id']) && isset($_SESSION['token'])) {
    $user_id = $_SESSION['user_id'];
    $token = $_SESSION['token'];

    $stmt = $pdo->prepare('DELETE FROM sessions WHERE user_id = :user_id AND token = :token');
    $stmt->execute(['user_id' => $user_id, 'token' => $token]);
}

session_unset();

session_destroy();

header('Location: forum/forum.php');
exit();
