<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
</head>
<body>
  <h2>Register</h2>
  <form action="register.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br>

    <input type="submit" value="Register">
  </form>
</body>
</html>

<?php
  // Check if the form was submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // TODO: Check if the username already exists in the database
    // For this example, we'll just hardcode a list of valid usernames for testing purposes
    $valid_usernames = array("admin", "user1", "user2");

    // Check if the username is already taken
    if (in_array($username, $valid_usernames)) {
      // Username already taken
      echo "Username already taken";
    } else {
      // Check if the password and confirm password match
      if ($password != $confirm_password) {
        // Passwords do not match
        echo "Passwords do not match";
      } else {
        // TODO: Insert the new user into the database
        // For this example, we'll just display a message saying that the registration was successful
        echo "Registration successful!";
      }
    }
  }
?>
