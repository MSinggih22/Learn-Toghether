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

// Get the user ID and session token from the session
$user_id = $_SESSION['user_id'];
$token = $_SESSION['token'];

try {
	$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// Prepare the SQL statement to fetch the session from the sessions table
	$stmt = $pdo->prepare('SELECT * FROM sessions WHERE user_id = :user_id AND token = :token');
	$stmt->execute(['user_id' => $user_id, 'token' => $token]);
	$session = $stmt->fetch();

	if (!$session) {
		// Invalid session, redirect to the login page
		header('Location: index.html');
		exit();
	}
} catch (PDOException $e) {
	die("Connection error: " . $e->getMessage());
}
?>
<?php

if (!isset($_SESSION['user_id']) || !isset($_SESSION['token'])) {
	header('Location: ../login.php');
	exit();
}

if (isset($_POST['submit'])) {
	$title = $_POST['title'];
	$description = $_POST['description'];

	$img = addslashes(file_get_contents($_FILES['img']['tmp_name']));

	$user_id = $_SESSION['user_id'];

	$categories = $_POST['category'];

	$followers = 0;

	$sql = "INSERT INTO topics (user_id, title, description,  followers, img, created_at) 
            VALUES ('$user_id', '$title', '$description', '$followers', '$img', NOW())";
	mysqli_query($conn, $sql);

	$topic_id = mysqli_insert_id($conn);

	foreach ($categories as $category_id) {
		$sql = "INSERT INTO relasi_topics_category (topic_id, category_id) VALUES ('$topic_id', '$category_id')";
		mysqli_query($conn, $sql);
	}

	mysqli_close($conn);

	header("Location: logined-forum.php");
	exit();
}

include '../../db/database-connect.php';
$sql = "SELECT * FROM topics_category";
$result = mysqli_query($conn, $sql);

$categories = array();
if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$categories[] = $row;
	}
}

mysqli_close($conn);

$loggedInUser = $_SESSION['user_id'];
$loggedinUsername = "";

include '../../db/database-connect.php';

// Retrieve the username of the logged in user
$sql = "SELECT username FROM users WHERE id = '$loggedInUser'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
	$loggedinUsername = $row['username'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Forum</title>
	<link rel="stylesheet" href="../../css/index.css">
	<link rel="stylesheet" href="../../css/post.css">
	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
	<div class="sidebar close">
		<div class="logo-details">
			<i class='bx bx-book'></i>
			<span class="logo_name">Learning Together</span>
		</div>
		<ul class="nav-links">
			<li>
				<a href="index.html">
					<i class='bx bx-home'></i>
					<span class="link_name">Home</span>
				</a>
				<ul class="sub-menu blank">
					<li><a class="link_name" href="index.html">Home</a></li>
				</ul>
			</li>
			<li>
				<div class="iocn-link">
					<a href="index.php">
						<i class='bx bx-collection'></i>
						<span class="link_name">Forum</span>
					</a>
					<i class='bx bxs-chevron-down arrow'></i>
				</div>
				<ul class="sub-menu">
					<li><a class="link_name" href="#">Forum</a></li>
					<li><a href="forum-category.php">Category</a></li>
					<li><a href="#">Trending</a></li>
				</ul>
			</li>
			<li>
				<a href="#">
					<i class='bx bx-pie-chart-alt-2'></i>
					<span class="link_name">Timeline</span>
				</a>
				<ul class="sub-menu blank">
					<li><a class="link_name" href="#">Timeline</a></li>
				</ul>
			</li>
			<li>
				<div class="iocn-link">
					<a href="#">
						<i class='bx bx-collection'></i>
						<span class="link_name">Customer Services</span>
					</a>
					<i class='bx bxs-chevron-down arrow'></i>
				</div>
				<ul class="sub-menu">
					<li><a class="link_name" href="#">Customer Service</a></li>
					<li><a href="#">Faqs</a></li>
					<li><a href="#">Gudlines</a></li>
					<li><a href="#">Rules</a></li>
				</ul>
			</li>
			<li>
				<div class="iocn-link">
					<a href="#">
						<i class='bx bx-cog'></i>
						<span class="link_name">Settings</span>
					</a>
					<i class='bx bxs-chevron-down arrow'></i>
				</div>
				<ul class="sub-menu blank">
					<li>
						<a class="link_name" href="#">Settings</a>
					</li>
				</ul>
			</li>
			<?php
			// Prepare the SQL statement to fetch the user from the users table
			$stmt = $pdo->prepare('SELECT * FROM users WHERE id = :user_id');
			$stmt->execute(['user_id' => $user_id]);
			$user = $stmt->fetch();

			if ($user) {
				// User found, display the username
				echo "<div class='profile-details'>";
				echo "<div class='profile-details'>";
				echo "<div class='profile-content'>";
				echo "<img src='image/tes.png' alt='profileImg'>";
				echo "</div>";
				echo "<div class='name-job'>";
				echo "<div class='profile_name'>";
				echo "<h2>" . $user['username'] . "</h2>";
				echo "</div>";
				echo  "</div>";
				echo "<a class='bx bx-log-out' href='logout.php'></a>";
				echo "</div>";
				echo "</li>";
			} else {
				// User not found
				echo "<p>Unable to fetch user data.</p>";
			}
			?>
		</ul>
	</div>
	<section class="section">
		<div class="content">
			<i onclick="chonclick(this)" class='bx bx-chevron-right'></i>
			<span class="text"></span>
			<div class="post">
				<form class="form-container" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to submit?');">
					<label for="title">Title:</label>
					<input type="text" id="title" name="title">
					<label for="description">Description:</label>
					<textarea id="description" name="description"></textarea>

					<label for="category">Category:</label>
					<?php foreach ($categories as $category) : ?>
						<label>
							<input type="checkbox" name="category[]" value="<?php echo $category['id']; ?>">
							<?php echo $category['name']; ?>
						</label>
					<?php endforeach; ?>
					<label for="img">Select img:</label>
					<input type="file" name="img" id="img">
					<button type="submit" name="submit">Add</button>
				</form>
			</div>
		</div>
	</section>
	<script>
		let arrow = document.querySelectorAll(".arrow");
		for (var i = 0; i < arrow.length; i++) {
			arrow[i].addEventListener("click", (e) => {
				let arrowParent = e.target.parentElement.parentElement;
				arrowParent.classList.toggle("showMenu");
				let mainContent = document.querySelector(".section");
				mainContent.classList.toggle("shifted");
			});
		}
		let sidebar = document.querySelector(".sidebar");
		let sidebarBtn = document.querySelector(".bx-chevron-right");
		console.log(sidebarBtn);
		sidebarBtn.addEventListener("click", () => {
			sidebar.classList.toggle("close");
			let mainContent = document.querySelector(".section");
			mainContent.classList.toggle("shifted");
		});
		//search script
		const searchBar = document.querySelector('input[type="text"]');
		searchBar.addEventListener("keyup", function(e) {
			const term = e.target.value.toLowerCase();
			const items = document.querySelectorAll("div.item");
			Array.from(items).forEach(function(item) {
				const title = item.textContent;
				if (title.toLowerCase().indexOf(term) != -1) {
					item.style.display = "block";
				} else {
					item.style.display = "none";
				}
			});
		});
		// clear the input fields when the page loads
		document.getElementById("title").value = "";
		document.getElementById("description").value = "";
	</script>
</body>

</html>