<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); 
include "../db/conn.php";

$startRange = mysqli_real_escape_string($conn, $_REQUEST['start']);
$endRange = mysqli_real_escape_string($conn, $_REQUEST['end']);

if (isset($_SESSION["userdata"])) {
  $user = $_SESSION["userdata"];

  $startDate = date("U",strtotime($startRange));

  $endDate = date("U",strtotime($endRange));

  $sql = "SELECT events.id, events.name, events.startDate, events.endDate FROM events INNER JOIN invitations ON events.id = invitations.eventId WHERE invitations.userId = '".($user->id)."' AND events.publishedAt < UNIX_TIMESTAMP() AND events.startDate BETWEEN ".$startDate." AND ".$endDate." ORDER BY startDate ASC";
  $result = $conn->query($sql);

  if($result->num_rows > 0) {
    $amount = $result->num_rows;
    $response = array();
    $i = 0;
    while($row = $result -> fetch_assoc()) {
      $id = mb_convert_encoding($row["id"], "UTF-8");
      $name = mb_convert_encoding($row["name"], "UTF-8");
      $startDate = mb_convert_encoding($row["startDate"], "UTF-8");
      $endDate = mb_convert_encoding($row["endDate"], "UTF-8");


          $url = "https://gymfest.mitstudiekort.dk/student/events/event?id=".$id;
          $response[$i]["title"] = $name;
          $response[$i]["start"] = gmdate('Y-m-d\TH:i:s\Z', $startDate);
          $response[$i]["end"] =  gmdate('Y-m-d\TH:i:s\Z', $endDate);
          $response[$i]["url"] = $url;
          $i++;
      }
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
  } else{
    echo "no Events";
  }
  
} else {
 echo "User not logged in";
}

?>