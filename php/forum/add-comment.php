<?php
session_start(); // Start the session
include '../../db/database-connect.php';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $topicID = $_POST['topic_id'];
    $userID = $_SESSION['user_id'];
    $comment = $_POST['comment'];
    $createdAt = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("INSERT INTO topics_comments (user_id, topic_id, comment, created_at) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $userID, $topicID, $comment, $createdAt);
    if ($stmt->execute()) {
        echo "Comment added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}

mysqli_close($conn);
