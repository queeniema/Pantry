<?php
	require('lib/MySQLConnection.php');

  if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
  	$email = $_POST['email'];
    $password = $_POST['password'];
    $query = "INSERT INTO `users` (username, password, email) VALUES ('$username', '$password', '$email')";

    $result = mysql_query($query);
    if($result) {
        $msg = "User Created Successfully.";
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Pantry - Registration</title>
  </head>
  <body>
    <div>
      <?php
      	if(isset($msg) & !empty($msg)) {
      		echo $msg;
      	}
      ?>
      <h1>Register</h1>
      <form action="" method="POST">
        <p><label>E-Mail: </label>
        <input id="password" type="email" name="email" required placeholder="user@email.com" /></p>

        <p><label>Username: </label>
      	<input id="username" type="text" name="username" placeholder="username" /></p>

        <p><label>Password: </label>
      	<input id="password" type="password" name="password" placeholder="password" /></p>

        <input class="btn register" type="submit" name="submit" value="Register" />
      </form>
      <a href="login.php">Login</a>
    </div>
  </body>
</html>