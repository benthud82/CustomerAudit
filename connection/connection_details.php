<?php

$dbtype = "mysql";
$dbhost = "localhost"; // Host name 
$dbuser = "root"; // Mysql username 
$dbpass = ""; // Mysql password 
$dbname = "custaudit"; // Database name 
$conn1 = new PDO("{$dbtype}:host={$dbhost};dbname={$dbname};charset=utf8", $dbuser, $dbpass, array());
$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



//$dbtype = "mysql";
//$dbhost = "127.0.0.1"; // Host name 
//$dbuser = "bentley"; // Mysql username 
//$dbpass = "dave41"; // Mysql password 
//$dbname = "custaudit"; // Database name 
//$conn1 = new PDO("{$dbtype}:host={$dbhost};dbname={$dbname};charset=utf8", $dbuser, $dbpass, array(
//    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//    PDO::ATTR_EMULATE_PREPARES => false,
//    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));