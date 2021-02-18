<?php
include_once('env.php');
$mysqli = new mysqli('localhost',DBUSER,DBPASS,DBNAME);

// Check connection
if ($mysqli -> connect_errno) {
  echo 'Failed to connect to MySQL: ' . $mysqli -> connect_error;
  exit();
}