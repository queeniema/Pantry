<?php
  $username = 'root';
  $password = 'password';
  $database = 'pantry';

  $connection = mysql_connect('localhost', $username, $password);

  if (!$connection) {
    die("Connection error" . mysql_error());
  }

  if (!mysql_select_db($database)) {
    die("Table error" . mysql_error());
  }
?>