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
  // Check if the form was submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // TODO: Check the username and password against a database or other authentication system
    // For this example, we'll just hardcode a username and password for testing purposes
    $valid_username = "admin";
    $valid_password = "password123";

    // Check if the username and password are valid
    if ($username == $valid_username && $password == $valid_password) {
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
