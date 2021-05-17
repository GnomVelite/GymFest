<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start(); 
include "../db/conn.php";

$user = $_SESSION["userdata"];

$sql = "SELECT events.id, events.name, events.startDate, events.endDate, events.price FROM events INNER JOIN invitations ON events.id = invitations.eventId WHERE invitations.userId = '".($user->id)."' AND events.publishedAt < UNIX_TIMESTAMP() ORDER BY startDate ASC";
$result = $conn->query($sql);

$i = 0;
$j=0;
$endedEvents = array();
if($result->num_rows > 0 /*&& isset($_SESSION['username'])*/) {
    $amount = $result->num_rows;
    $response = array();
    while($row = $result -> fetch_assoc()) {
        $id = mb_convert_encoding($row["id"], "UTF-8");
        $name = mb_convert_encoding($row["name"], "UTF-8");
        $startDate = mb_convert_encoding($row["startDate"], "UTF-8");
        $endDate = mb_convert_encoding($row["endDate"], "UTF-8");
        $publishedAt = mb_convert_encoding($row["publishedAt"], "UTF-8");
        $price = mb_convert_encoding($row["price"], "UTF-8");

        if ($endDate >= time()){
            $response[$i]["id"] = $id;
            $response[$i]["name"] = $name;
            $response[$i]["startDate"] = $startDate;
            $response[$i]["endDate"] = $endDate;
            $response[$i]["price"] = $price;
            $i++;
        } else {
            $endedEvents[$j]["id"] = $id;
            $endedEvents[$j]["name"] = $name;
            $endedEvents[$j]["startDate"] = $startDate;
            $endedEvents[$j]["endDate"] = $endDate;
            $endedEvents[$j]["price"] = $price;
            $j++;
            
        } 
    }

     echo '{"events": ' . json_encode($response, JSON_UNESCAPED_UNICODE) . ',"endedEvents":'.json_encode($endedEvents,JSON_UNESCAPED_UNICODE).'}';

} else {
  echo "error";
}
?>