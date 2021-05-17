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
$publishTime = mysqli_real_escape_string($conn, $_REQUEST['pe']);
$price = mysqli_real_escape_string($conn, $_REQUEST['p']);
$tickets = mysqli_real_escape_string($conn, $_REQUEST['t']);
$invites = mysqli_real_escape_string($conn, $_REQUEST['i']);
$lat = mysqli_real_escape_string($conn, $_REQUEST['lat']);
$lng = mysqli_real_escape_string($conn, $_REQUEST['lng']);
$studentAdmins = mysqli_real_escape_string($conn, $_REQUEST['sa']);
$description = $_REQUEST['d'];
$description = str_replace("§€§€", "&", $description);
$description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
$description = mysqli_real_escape_string($conn, $description);


$starttime = htmlspecialchars($starttime, ENT_QUOTES, 'UTF-8');
$endtime = htmlspecialchars($endtime, ENT_QUOTES, 'UTF-8');
$eventname = htmlspecialchars($eventname, ENT_QUOTES, 'UTF-8');
$publishTime = htmlspecialchars($publishTime, ENT_QUOTES, 'UTF-8');
$price = htmlspecialchars($price, ENT_QUOTES, 'UTF-8');
$tickets = htmlspecialchars($tickets, ENT_QUOTES, 'UTF-8');
$lat = htmlspecialchars($lat, ENT_QUOTES, 'UTF-8');
$lng = htmlspecialchars($lng, ENT_QUOTES, 'UTF-8');

$invites = stripslashes($invites);
$invites = json_decode($invites);

$studentAdmins = stripslashes($studentAdmins);
$studentAdmins = json_decode($studentAdmins);

var_dump($description);


if (isset($_SESSION["userdata"])) {

    $user = $_SESSION["userdata"];
    $id = $user->id;
    $bytes = random_bytes(20);
    $scanToken = bin2hex($bytes);

    if ($user->role != "admin") {
        header_remove('Location');
        header('Location: /student/index.php');
    }

    $eventsql = "INSERT INTO `events` (`ownerId`, `name`, `startDate`, `endDate`, `publishedAt`, `price`, `tickets`, `description`, `lat`, `lng`, `scanToken`) VALUES ('$id','$eventname', '$starttime', '$endtime','$publishTime', '$price', '$tickets', '$description', '$lat', '$lng', '$scanToken')";

    if ($conn->query($eventsql)) { // Card oprettet
        $eventId = $conn->insert_id;

        foreach ($invites as $class) {
            $studentsql = "SELECT ownerid FROM cards WHERE `class` = '".($class)."'";
            $studentResult = $conndds->query($studentsql);

            if($studentResult->num_rows > 0) {
                while($srow = $studentResult -> fetch_assoc()) {
                    $studentId = $srow["ownerid"];

                    $invitesql = "INSERT INTO `invitations` (`eventId`, `userId`) VALUES ('$eventId','$studentId')";
                    $conn->query($invitesql);
                }
            } else {
                echo "fuck";
            }

        }

        foreach ($studentAdmins as $admin) {
            $adminsql = "INSERT INTO `studentEdits` (`eventId`, `studentId`) VALUES ('$eventId','$admin')";
            $conn->query($adminsql);
        }
    } else {
        echo "error";
    }
}

?>