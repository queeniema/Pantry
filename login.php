<?php
  session_start();
  require('lib/MySQLConnection.php');
  if (isset($_POST['username']) and isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM `users` WHERE username='$username' and password='$password'";

    $result = mysql_query($query) or die(mysql_error());
    $count = mysql_num_rows($result);
    if ($count == 1) {
      $_SESSION['username'] = $username;
    } else {
      echo "Invalid Login Credentials.";
    }
  }

  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo "Hi " . $username . ". ";
    echo "You are logged in. ";
    echo "<a href='logout.php'>Logout</a>";

  }else{
?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>Pantry - Login</title>
    </head>
    <body>
      <div>
      <?php
      	if(isset($msg) & !empty($msg)) {
      		echo $msg;
      	}
      ?>
      <h1>Login</h1>
      <form action="" method="POST">
        <p><label>Username: </label>
      	<input id="username" type="text" name="username" placeholder="username" /></p>

        <p><label>Password: </label>
      	<input id="password" type="password" name="password" placeholder="password" /></p>

        <input class="btn register" type="submit" name="submit" value="Login" />
      </form>
      <a href="register.php">Signup</a>
      </div>
    </body>
  </html>
<?php
  }
?>
