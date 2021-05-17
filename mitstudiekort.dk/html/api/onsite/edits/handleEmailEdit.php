<?php
//start session
session_start(); 
include "../db/conn.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// check at brugeren er logget ind
if (!isset($_SESSION['email'])) {
  header_remove('Location');
  header('Location: /login.php');
} else {
  $id = $_SESSION['id']; // hent id
}

// Data fra POST
$newEmail = mysqli_real_escape_string($conn, $_REQUEST['newEmail']);

// Verificer integritet af data
if(!filter_var($newEmail, FILTER_VALIDATE_EMAIL) || $newEmail == ""){
  $emailerr = true;
} else{
  $emailerr = false;
}

if(!$emailerr){
  $checkSql = "SELECT email FROM users WHERE `email` = '".($newEmail)."'";
  $fetchedUsers = $conn->query($checkSql); // check at email ikke allerede eksisterer
    if ($fetchedUsers->num_rows > 0) {
      echo "usedEmail";
    }else{

    $sql = "UPDATE users SET `loginChange` = '".$newEmail."' WHERE `id` = '".($id)."'";
      if ($conn->query($sql)) { // opdater email
        echo "emailValid";
      } else {
        echo "notUpdated";
    }
  }
} else{
  echo "noEmail";
}
?>