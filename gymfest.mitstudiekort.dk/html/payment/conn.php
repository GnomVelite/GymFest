<?php
$host = "localhost"; /* Host name */
$user = "admin"; /* User */
$password = ""; /* Password */
$dbname = "GymFest"; /* Database name */

$conn = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$conn) {
 die("Connection failed: " . mysqli_connect_error());
}