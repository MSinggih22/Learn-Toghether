<?php
session_start();
include '../../db/database-connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    $username = $row['username'];
    $email = $row['email'];
    $users_image = $row['users_image'];
} else {
    echo "Error fetching user data from the database.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-topic'])) {
    $topic_id = $_POST['topic-id'];

    $sql = "SELECT user_id FROM topics WHERE id = '$topic_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $topic_user_id = $row['user_id'];

        if ($topic_user_id == $user_id) {
            mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");

            $sql = "DELETE FROM topics WHERE id = '$topic_id'";
            if (mysqli_query($conn, $sql)) {
                echo "Topic deleted successfully.";
            } else {
                echo "Error deleting topic: " . mysqli_error($conn);
            }
            mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");
        } else {
            echo "You don't have permission to delete this topic.";
        }
    } else {
        echo "Topic not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
</head>

<body>
    <h1>User Settings</h1>
    <h2>Welcome, <?php echo $username; ?>!</h2>
    <h3>Your Profile</h3>
    <p>Username: <?php echo $username; ?></p>
    <p>Email: <?php echo $email; ?></p>
    <img src="<?php echo $users_image; ?>" alt="Profile Image" width="200" height="200">

    <h3>Your Topics</h3>
    <?php
    $sql = "SELECT * FROM topics WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $topic_id = $row['id'];
            $topic_title = $row['title'];
            $topic_description = $row['description'];
            echo "<div>";
            echo "<h4>$topic_title</h4>";
            echo "<p>$topic_description</p>";
            echo "<form method='POST' action='user-settings.php'>";
            echo "<input type='hidden' name='topic-id' value='$topic_id'>";
            echo "<input type='submit' name='delete-topic' value='Delete Topic'>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "You have no topics.";
    }
    ?>
</body>

</html>