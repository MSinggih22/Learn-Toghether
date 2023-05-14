<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<body>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Document</title>
	</head>

	<body>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<label for="title">Title:</label>
			<input type="text" id="title" name="title">

			<label for="description">Description:</label>
			<textarea id="description" name="description"></textarea>

			<form action="action.php" method="POST" onsubmit="return confirm('Are you sure you want to submit?');">
				<!-- form fields -->
				<button type="submit" name="submit">Add</button>
			</form>
		</form>

		<script>
			// clear the input fields when the page loads
			document.getElementById("title").value = "";
			document.getElementById("description").value = "";
		</script>


	</html>

	<?php
	// if the form is submitted
	if (isset($_POST['submit'])) {
		// get the values of the input fields
		$title = $_POST['title'];
		$description = $_POST['description'];

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

		// insert the new data into the "boxes" table
		$sql = "INSERT INTO topics (title, description, views, comments, followers) 
            VALUES ('$title', '$description', '$views', '$comments', '$followers')";
		mysqli_query($conn, $sql);

		mysqli_close($conn);

		// redirect to the same page to reload the boxes
		header("Location: " . $_SERVER['PHP_SELF']);
		exit();
	}
	?>
</body>

</html>
</body>

</html>