<?php
$conn_db = new mysqli('localhost', 'root', 'admin');
// Check connection
if ($conn_db->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

mysqli_query($conn_db, "CREATE DATABASE pasa_report");

include_once './__utils.php';

$sql = file_get_contents('./pasa_report.sql');
$conn->multi_query($sql);

?>