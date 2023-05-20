<!DOCTYPE html>
<html>

<head>
    <title>Admin Menu - Update Topic</title>
</head>

<body>
    <h1>Admin Menu - Update Topic</h1>

    <?php
    include '../../db/database-connect.php';
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    function getTopics()
    {
        global $conn;
        $sql = "SELECT id, title FROM topics";
        $result = mysqli_query($conn, $sql);

        $topics = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $topics[] = $row;
            }
        }

        return $topics;
    }

    function updateTopic($id, $newTitle, $newDescription, $newFollowers)
    {
        global $conn;
        $sql = "UPDATE topics SET title='$newTitle', description='$newDescription', followers='$newFollowers' WHERE id='$id'";

        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    $topics = getTopics();

    if (isset($_POST['update'])) {
        $topicId = $_POST['topic_id'];
        $newTitle = $_POST['new_title'];
        $newDescription = $_POST['new_description'];
        $newFollowers = $_POST['new_followers'];

        if (updateTopic($topicId, $newTitle, $newDescription, $newFollowers)) {
            echo "Topic updated successfully.";
        } else {
            echo "Failed to update the topic.";
        }
    }

    echo '<h2>Update Topic</h2>';
    echo '<form method="post" action="">';
    echo '<label for="topic_id">Topic ID:</label>';
    echo '<select name="topic_id" id="topic_id">';
    foreach ($topics as $topic) {
        echo "<option value=\"" . $topic['id'] . "\">" . $topic['id'] . "</option>";
    }
    echo '</select>';
    echo '<br>';
    echo '<label for="new_title">New Title:</label>';
    echo '<input type="text" name="new_title" id="new_title">';
    echo '<br>';
    echo '<label for="new_description">New Description:</label>';
    echo '<input type="text" name="new_description" id="new_description">';
    echo '<br>';
    echo '<label for="new_followers">New Followers:</label>';
    echo '<input type="text" name="new_followers" id="new_followers">';
    echo '<br>';
    echo '<input type="submit" name="update" value="Update">';
    echo '</form>';

    mysqli_close($conn);
    ?>

</body>

</html>
