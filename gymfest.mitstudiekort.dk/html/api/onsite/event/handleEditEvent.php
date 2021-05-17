<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); 
include "../db/conn.php";
include "../db/conndds.php";

$starttime = mysqli_real_escape_string($conn, $_REQUEST['se']);
$endtime = mysqli_real_escape_string($conn, $_REQUEST['ee']);
$eventname = mysqli_real_escape_string($conn, $_REQUEST['en']);

$price = mysqli_real_escape_string($conn, $_REQUEST['p']);

$eventID = mysqli_real_escape_string($conn, $_REQUEST['id']);


$lat = mysqli_real_escape_string($conn, $_REQUEST['lat']);
$lng = mysqli_real_escape_string($conn, $_REQUEST['lng']);

$description = $_REQUEST['d'];
$description = str_replace("§€§€", "&", $description);
$description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
$description = mysqli_real_escape_string($conn, $description);


$starttime = htmlspecialchars($starttime, ENT_QUOTES, 'UTF-8');
$endtime = htmlspecialchars($endtime, ENT_QUOTES, 'UTF-8');
$eventname = htmlspecialchars($eventname, ENT_QUOTES, 'UTF-8');

$price = htmlspecialchars($price, ENT_QUOTES, 'UTF-8');

$lat = htmlspecialchars($lat, ENT_QUOTES, 'UTF-8');
$lng = htmlspecialchars($lng, ENT_QUOTES, 'UTF-8');


if (isset($_SESSION["userdata"])) {

    $user = $_SESSION["userdata"];
    $id = $user->id;

  if ($user->role != "admin") {
      header_remove('Location');
      header('Location: /student/index.php');
  }

  $eventsql = 'UPDATE `events` SET `startDate` = "'.($starttime).'", `endDate` = "'.($endtime).'", `price` = "'.($price).'", `description` = "'.($description).'", `lat` = "'.($lat).'", `lng` = "'.($lng).'", `name` = "'.($eventname).'" WHERE `id` = "'.($eventID).'" AND `ownerId` = "'.($user->id).'"';
  echo $eventsql;
  if ($conn->query($eventsql)) { 
      echo "YAY!";
  } else{
    echo "bad sql";
  }
} else {
    echo "error";
}

?>