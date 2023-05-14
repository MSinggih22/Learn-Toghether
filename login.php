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

<input type="submit" value="Login">
</form>
</body>
</html>
<?php
  // Connect to the database (replace 'dbname', 'username', and 'password' with your own credentials)
  $serverusername="localhost";
  $username="root";
  $password="";
  $dbname = "lt";
  
  $connection = new mysqli($serverusername, $username, $password, $dbname);
  if ($connection->connect_error) {
      die("Connection error: " . $connection->connect_error);
  }

  // Check if the form was submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query the database for the user with the given username and password
    $stmt = $connection->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    // Check if a user was found with the given username and password
    if ($user) {
      // Login successful
      echo "Login successful!";
      // Redirect the user to the inside page
      header("Location: ex.php");
      exit();
    } else {
      // Login failed
      echo "Invalid username or password";
    }
  }
?> 