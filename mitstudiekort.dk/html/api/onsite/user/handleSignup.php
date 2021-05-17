<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); 
include "../db/conn.php";

$nameerr = $usernameerr = $emailerr = false;

// Data fra POST

$firstname = mysqli_real_escape_string($conn, $_REQUEST['fname']);
$lastname = mysqli_real_escape_string($conn, $_REQUEST['lname']);
$email = mysqli_real_escape_string($conn, $_REQUEST['email']);
$password = mysqli_real_escape_string($conn, $_REQUEST['pass']);
//$barcode = mysqli_real_escape_string($conn, $_REQUEST['barcode']);

$fistname = htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8');
$lastname = htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

// Verificer integritet af data


if(!filter_var($email, FILTER_VALIDATE_EMAIL) || $email == ""){
  $emailerr = true;
  header_remove('Location');
  header("Location: /signup.php?err=1");
}

// Vi hasher password

$hash = password_hash($password, PASSWORD_DEFAULT);

if(!$nameerr && !$emailerr){
  echo "dinmor"; // OG meme
  $sql = "SELECT email FROM users WHERE `email` = '".($email)."'";
  $result = $conn->query($sql);
  if($result->num_rows == 0){
    echo "dinfar";
    $sql2 = "INSERT INTO users (firstName, lastName, email, password) VALUES ('$firstname', '$lastname', '$email', '$hash')";
    if ($conn->query($sql2)) {
      echo "User created!";
      //$_SESSION["username"] = $username;
  
      header_remove('Location');
      header('Location: /login.php');
      exit;
    } else {
      echo "error";
    }
  } else {  
    echo "User already exits";
  }
}
?>