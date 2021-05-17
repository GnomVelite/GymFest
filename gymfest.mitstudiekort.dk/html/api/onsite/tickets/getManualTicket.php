<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); 
include "../db/conn.php";
include "../db/conndds.php";

$ticket = mysqli_real_escape_string($conn, $_REQUEST['tid']);
$ticket = htmlspecialchars($ticket, ENT_QUOTES, 'UTF-8');

$eventid = mysqli_real_escape_string($conn, $_REQUEST['eid']);
$eventid = htmlspecialchars($eventid, ENT_QUOTES, 'UTF-8');

$return = [];

if (isset($ticket) && isset($eventid)) {

    $ticketSql = "SELECT eventId, userId, status FROM tickets WHERE `ticketToken` = '".($ticket)."'";
    $ticketResult = $conn->query($ticketSql);

    if($ticketResult->num_rows > 0) {
        while($brow = $ticketResult -> fetch_assoc()) {
            
            $userId = $brow["userId"];

            $ownerSql = "SELECT cards.class, users.firstName, users.lastName FROM cards INNER JOIN users ON users.id = cards.ownerid WHERE users.id = '".($userId)."'";
            $ownerResult = $conndds->query($ownerSql);
        
            if($ownerResult->num_rows > 0) {
                while($srow = $ownerResult -> fetch_assoc()) {
                    $className = $srow["class"];
                    $firstName = $srow["firstName"];
                    $lastName = $srow["lastName"];
                    $return["studentName"] = $firstName." ".$lastName;
                }
            }

            $ticketToken = $ticket;
            $return["status"] = $brow["status"];
            $return["ticketToken"] = $ticketToken;
            $return["className"] = $className;

            if ($return["status"] == "VALID") {
                $ticketupdatesql = "UPDATE tickets SET `status` = 'ARRIVED', `arrivedAt` = CURRENT_TIME() WHERE `userId` = '".($userId)."' AND `eventId` = '".($eventid)."'";
                $conn->query($ticketupdatesql);
            }
        }
    } else {
        $return["status"] = "ERROR";
        $return["ticketToken"] = "NONE";            
    }

}

echo json_encode($return);

?>