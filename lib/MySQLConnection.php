<?php

class MySQLConnection {

  private static $connection = null;
  private static $db = null;

  private static $username = 'root';
  private static $password = 'password';
  private static $database = 'pantry';

  private function __construct() {
    MySQLConnection::$db = new mysqli('localhost', MySQLConnection::$username, MySQLConnection::$password, MySQLConnection::$database);
    if(MySQLConnection::$db->connect_errno > 0 )
      die("Connection error" . MySQLConnection::$db->connect_error);
  }

  public static function makeConnection() {
    if(!isset(MySQLConnection::$db))
      new MySQLConnection;
    return MySQLConnection::$db;
  }

}

$db = MySQLConnection::makeConnection();

?>

