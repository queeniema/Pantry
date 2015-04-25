<?php
  session_start();
  session_destroy();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Pantry - Logout</title>
  </head>
  <body>
    <div>
      <h1>Logged out</h1>
      You have been logged out. <a href="login.php">Login again</a>.
    </div>
  </body>
</html>