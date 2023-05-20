<!DOCTYPE html>
<html>

<head>
    <title>Admin Menu - Topics</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this topic?");
        }
    </script>
</head>

<body>
    <h1>Admin Menu - Topics</h1>

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

    // Delete (Menghapus data topik)
    function deleteTopic($id)
    {
        global $conn;
        $sql = "DELETE FROM topics WHERE id='$id'";

        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    // Mengambil data topik yang ada
    $topics = getTopics();

    // Menghapus topik jika parameter "id" ada dalam URL
    if (isset($_GET['id'])) {
        $topicId = $_GET['id'];
        if (deleteTopic($topicId)) {
            echo "Topic deleted successfully.";
        } else {
            echo "Failed to delete the topic.";
        }
    }

    // Menampilkan data topik dalam bentuk list dengan menu delete dan update
    if (!empty($topics)) {
        echo "<ul>";
        foreach ($topics as $topic) {
            echo "<li>" . $topic['title'] . " <a href=\"?id=" . $topic['id'] . "\" onclick=\"return confirmDelete();\">Delete</a> <a href=\"topics-update.php?id=" . $topic['id'] . "\">Update</a></li>";
        }
        echo "</ul>";
    } else {
        echo "No topics found.";
    }

    // Menutup koneksi ke database
    mysqli_close($conn);
    ?>
</body>
</html>
