<?php
include '../../db/database-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $timeline_id = $_POST['timeline_id'];
    $comment = $_POST['comment'];

    // Perform the necessary validation and sanitization of the input data

    // Get the user ID from the session
    session_start();
    $user_id = $_SESSION['user_id'];

    // Insert the comment into the timeline_comments table
    $insertSql = "INSERT INTO timeline_comments (timeline_id, comments, user_id) VALUES ({$timeline_id}, '{$comment}', {$user_id})";
    $insertResult = mysqli_query($conn, $insertSql);

    if ($insertResult) {
        // Comment inserted successfully
        // Redirect the user back to the page displaying the timeline
        header("Location: logined-timeline.php");
        exit();
    } else {
        // Failed to insert the comment
        // Handle the error accordingly
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
