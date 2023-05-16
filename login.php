<?php
// Connect to the database (replace 'dbname', 'username', and 'password' with your own credentials)
$serverusername = "localhost";
$uname = "root";
$password = "";
$dbname = "lt";

$connection = new mysqli($serverusername, $uname, $password, $dbname);
if ($connection->connect_error) {
  die("Connection error: " . $connection->connect_error);
}
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the username and password from the form
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Query the database for the user with the given username and password
  $stmt = $connection->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
  $stmt->bind_param('ss', $username, $password);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
  $stmt->close();

  // Check if a user was found with the given username and password
  if ($user) {
    $token = bin2hex(random_bytes(16));
    $stmt = $connection->prepare('INSERT INTO sessions (user_id, token) VALUES (?, ?)');
    $stmt->bind_param('ss', $user['id'], $token);
    $stmt->execute();
    $stmt->close();

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['token'] = $token;

    // Login successful
    echo "Login successful!";
    // Redirect the user to the inside page
    header("Location: ex_index.php");
    exit();
  } else {
    // Login failed
    echo "Invalid username or password";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
</head>

<body>
  <h2>Login</h2>
  <form action="login.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>
    <input type="submit" name="login" value="Login">
  </form>
</body>

</html>