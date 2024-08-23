<?php
$servername = "localhost";
$username = "myprojects_abc_us";
$password = "Admin$2024";

try {
  $conn = new PDO("mysql:host=$servername;dbname=myprojects_abc_DB", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>