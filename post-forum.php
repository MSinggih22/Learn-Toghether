<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['token'])) {
	// User is not logged in, redirect to the login page
	header('Location: index.php');
	exit();
}

// if the form is submitted
if (isset($_POST['submit'])) {
	// get the values of the input fields
	$title = $_POST['title'];
	$description = $_POST['description'];

	// get the image data
	$img = addslashes(file_get_contents($_FILES['img']['tmp_name']));

	// get the user ID from the session
	$user_id = $_SESSION['user_id'];

	// connect to the database
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "lt";

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// set views, comments, and followers to 0
	$views = 0;
	$comments = 0;
	$followers = 0;

	// insert the new data into the "topics" table
	$sql = "INSERT INTO topics (user_id, title, description, views, comments, followers, img) 
    VALUES ('$user_id', '$title', '$description', '$views', '$comments', '$followers', '$img')";
	mysqli_query($conn, $sql);

	mysqli_close($conn);

	// redirect to the same page to reload the topics
	header("Location: " . $_SERVER['PHP_SELF']);
	exit();
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Add Topic</title>
</head>

<body>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to submit?');">
		<label for="title">Title:</label>
		<input type="text" id="title" name="title">

		<label for="description">Description:</label>
		<textarea id="description" name="description"></textarea>

		<label for="img">Select img:</label>
		<input type="file" name="img" id="img">
		<a href="index.php" class="button">Back</a>
		<button type="submit" name="submit">Add</button>
	</form>
	<script>
		// clear the input fields when the page loads
		document.getElementById("title").value = "";
		document.getElementById("description").value = "";
	</script>
</body>

</html>