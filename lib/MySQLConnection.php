<?php

class MySQLConnection {

  private static $connection = null;

  private static $username = 'root';
  private static $password = 'password';
  private static $database = 'pantry';

  private function __construct() {
    $connection = mysql_connect('localhost', MySQLConnection::$username, MySQLConnection::$password);
    if(!$connection)
      die("Connection error" . mysql_error());
    if(!mysql_select_db(MySQLConnection::$database))
      die("Table error" . mysql_error());
  }

  public static function makeConnection() {
    if(!isset(MySQLConnection::$connection))
      MySQLConnection::$connection = new MySQLConnection;
    return MySQLConnection::$connection;
  }

}

$mysql_connection = MySQLConnection::makeConnection();

?>

