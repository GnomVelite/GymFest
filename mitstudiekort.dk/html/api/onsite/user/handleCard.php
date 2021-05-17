<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); 
include "../db/conn.php";

$err1 = 0;
$err2 = 0;

$id = $_SESSION['id'];
$resultArray = $_SESSION['lectioData'];

$birthdate = mysqli_real_escape_string($conn, $_REQUEST['be']);
$expiredate = mysqli_real_escape_string($conn, $_REQUEST['ee']);
$barcode = mysqli_real_escape_string($conn, $_REQUEST['bc']);

$birthdate = htmlspecialchars($birthdate, ENT_QUOTES, 'UTF-8');
$expiredate = htmlspecialchars($expiredate, ENT_QUOTES, 'UTF-8');
$barcode = htmlspecialchars($barcode, ENT_QUOTES, 'UTF-8');

// var_dump($_SESSION);
// echo "<br><br>";
// var_dump($resultArray);

// Fødselsdag i fremtiden
if ($birthdate-time() > 0) {
  $err1 = 1;
}

// Udløbsdato i fortiden
if ($expiredate-time() < 0) {
  $err2 = 1;
}

$nameArr = explode(" ",$resultArray[0]);
$nameArr = mb_convert_encoding($nameArr, 'HTML-ENTITIES', 'utf-8');
//var_dump($nameArr);
$lname = $nameArr[count($nameArr)-1];
//echo $lname;
$fname = "";
for ($i = 0; $i < count($nameArr)-1; $i++) {
  $name = $nameArr[$i]." " ;
  
  $fname = $fname.$name;
}
$fname = substr($fname,0,strlen($fname)-1);

//echo $fname;
$className = mb_convert_encoding($resultArray[5], 'HTML-ENTITIES', 'utf-8');
$schoolName = mb_convert_encoding($resultArray[1], 'HTML-ENTITIES', 'utf-8');
//echo "UTC:".time();

$className = substr($className, 1);

$cardExistssql = "SELECT ownerid FROM cards WHERE `ownerid` = '".($id)."'";
$result = $conn->query($cardExistssql);
if($result->num_rows == 0){
  $cardNotReused = "SELECT barcode, school FROM cards WHERE `barcode` = '".($barcode)."'";
  $result2 = $conn->query($cardNotReused);
  if ($result2->num_rows > 0) {
      while($trow = $result2 -> fetch_assoc()) {
        $schoolNow = $trow["school"];
      }
    } else {
      $schoolNow = "";
    }
  if ($schoolNow != $resultArray[1]) {
    //echo $schoolNow;
    $usersql = "UPDATE users SET firstName = '".($fname)."', lastName = '".($lname)."' WHERE `id` = '".($id)."'";
    if ($conn->query($usersql)) { // opdater navn
    }
    $cardsql = "INSERT INTO `cards`(`ownerid`, `barcode`, `school`, `class`, `expiry`, `birthdate`, `pictureid`) VALUES ('$id','$barcode','$schoolName', '$className', '$expiredate','$birthdate','$resultArray[2]')";
    //echo $cardsql;
    if ($conn->query($cardsql)) { // Card oprettet
      echo "Succes";
      $_SESSION["schoolname"] = $schoolName;
      $_SESSION["classname"] = $className;
      $_SESSION["barcode"] = $barcode;
      unset($_SESSION["lectioData"]);
    } else {
      echo "error1";
    }
  } else {
    echo "error2";
  }
} else {
  echo "error3";
}
?>