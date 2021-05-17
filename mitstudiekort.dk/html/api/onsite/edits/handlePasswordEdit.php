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
$pass = mysqli_real_escape_string($conn, $_REQUEST['password']);
$newPass = mysqli_real_escape_string($conn, $_REQUEST['newPassword']);
$passErr =  true;

if (strlen($newPass) > 7  ){
  $passErr = false;
}

if(!$passErr){
  $checkSql = "SELECT password FROM users WHERE `id` = '".($id)."'"; // Hent hash der passer med login
  $checkResult = $conn->query($checkSql); 
  if ($checkResult->num_rows > 0) {
    while($brow = $checkResult -> fetch_assoc()) {
      $hash = $brow["password"];
    }
    if (password_verify($pass, $hash)) { // verificer at pass svarer til hash
      $newPass = password_hash($newPass, PASSWORD_DEFAULT);
      $sql = "UPDATE users SET `loginChange` = '".$newPass."' WHERE `id` = '".($id)."'";
      if ($conn->query($sql)) { // opdater loginChange til det nye password
        echo "passwordValid";
      } else {
        echo "passwordError";
      }
    } else {
      echo 'invalidPassword';
    }
  } else {
    echo "passwordError";
  }
} else {
  echo "tooShort";
}
?>