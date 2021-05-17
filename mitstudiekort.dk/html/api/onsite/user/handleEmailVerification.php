<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include "../db/conn.php";
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

session_start();

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

if (!isset($_SESSION['id'])) {
  echo "error";
} else {
    $id = $_SESSION['id'];
}


$time = time();
$sql = "UPDATE users SET `emailKey` = UUID(), emailDate = '".($time)."' WHERE `id` = '".($id)."'";
if (!$conn->query($sql)) { // opdater email data
  echo "notkeyUpdated";
}
$userSql = "SELECT firstName, lastName, loginChange, email, emailKey FROM users WHERE `id` = '".($id)."'";
$userResult = $conn->query($userSql); // hent bruger data

if ($userResult->num_rows > 0) {
    while($brow = $userResult -> fetch_assoc()) {
        $firstName = $brow["firstName"];
        $lastName = $brow["lastName"];
        $loginChange = $brow["loginChange"];
        $email = $brow["email"];
        $key = $brow["emailKey"];
    }
}


if ($loginChange != NULL){ // bestem om der skal ændres på login eller verificeres allerede kendt email
  $to = $loginChange;
} else{
  $to = $email;
}
//email setup

$subject = 'Verificering af Email - Mit Studiekort';

$message = '
<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Mail fra mit studiekort</title>
  <style>
@media only screen and (max-width: 620px) {
  table[class=\'body\'] h1 {
    font-size: 28px !important;
    margin-bottom: 10px !important;
  }

  table[class=\'body\'] p,
table[class=\'body\'] ul,
table[class=\'body\'] ol,
table[class=\'body\'] td,
table[class=\'body\'] span,
table[class=\'body\'] a {
    font-size: 16px !important;
  }

  table[class=\'body\'] .wrapper,
table[class=\'body\'] .article {
    padding: 10px !important;
  }

  table[class=\'body\'] .content {
    padding: 0 !important;
  }

  table[class=\'body\'] .container {
    padding: 0 !important;
    width: 100% !important;
  }

  table[class=\'body\'] .main {
    border-left-width: 0 !important;
    border-radius: 0 !important;
    border-right-width: 0 !important;
  }

  table[class=\'body\'] .btn table {
    width: 100% !important;
  }

  table[class=\'body\'] .btn a {
    width: 100% !important;
  }

  table[class=\'body\'] .img-responsive {
    height: auto !important;
    max-width: 100% !important;
    width: auto !important;
  }
}
@media all {
  .ExternalClass {
    width: 100%;
  }

  .ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
    line-height: 100%;
  }

  .apple-link a {
    color: inherit !important;
    font-family: inherit !important;
    font-size: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
    text-decoration: none !important;
  }

  .btn-primary table td:hover {
    background-color: #d5075d !important;
  }

  .btn-primary a:hover {
    background-color: #d5075d !important;
    border-color: #d5075d !important;
  }
}
</style></head>
  <body class style="background-color: rgb(170,22,200); font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; //background-color: #161f33; background-image: linear-gradient(rgb(70,91,230), rgb(170,22,200)); width: 100%;" width="100%">
      <tr>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;" width="580" valign="top">
          <div class="header" style="padding: 20px 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;" width="100%">
              <tr>
                <td class="align-center" style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-align: center;" valign="top" align="center">
                  <a href="https://www.mitstudiekort.dk/index.php" style="color: #ec0867; text-decoration: underline;"><img src="https://www.mitstudiekort.dk/assets/email-logo.png" height="100" alt="Logo" style="border: none; -ms-interpolation-mode: bicubic; max-width: 100%;"></a>
                  
                </td>
              </tr>
              <tr>
                  <td class="align-center" style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-align: center;" valign="top" align="center">
              <a style="color: white; font-size: 40px; text-decoration: none;" href="https://www.mitstudiekort.dk/index.php">Mit studiekort</a>
            </td>
            </tr>
            </table>
          </div>
          <div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">

            <!-- START CENTERED WHITE CONTAINER -->
            <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;"></span>
            <table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;" width="100%">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;" width="100%">
                    <tr>
                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Hej '.$firstName.' '.$lastName.',</p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Du modtager denne mail, fordi vi skal verificerer din email konto på mit studiekort. For at verificere at denne email konto er din egen skal du trykke på nedenstående link, der kun er aktivt i 24 timer.</p>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; min-width: 100%; width: 100%;" width="100%">
                          <tbody>
                            <tr>
                              <td align="center" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;" valign="top">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: auto; width: auto;">
                                  <tbody>
                                    <tr>
                                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; border-radius: 5px; text-align: center; background-color: #ec0867;" valign="top" align="center" bgcolor="#ec0867"> <a href="https://www.mitstudiekort.dk/api/onsite/auth/handleEmailVerified.php?key='.$key.'" target="_blank" style="border: solid 1px #ec0867; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; background-color: #ec0867; border-color: #ec0867; color: #ffffff;">Tryk her!</a> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Du har ikke mulighed for at ændre dine andre login oplysninger før du har verificeret din email, hvis linket er løbet ud skal du åbne mit studiekort igen og få sendt en ny email.</p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; text-align: center;"> Venlig hilsen</p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; text-align: center;"> Team mit studiekort</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>

            <!-- START FOOTER -->
            <div class="footer" style="clear: both; margin-top: 10px; text-align: center; width: 100%;">
              <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;" width="100%">
                <tr>
                  <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;" valign="top" align="center">
                    <span class="apple-link" style="color: #9a9ea6; font-size: 12px; text-align: center;">Mit studiekort A/S, Bygning 451, Akademivej, 2800 Kongens Lyngby, Denmark</span>
                    
                  </td>
                </tr>
              </table>
            </div>
            <!-- END FOOTER -->

          <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
      </tr>
    </table>
  </body>
</html>

';


  $mail = new PHPMailer(true);

  try {
      //Server settings
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = 'mitstudiekort@gmail.com';                     //SMTP username
      $mail->Password   = 'F4lc0n153_goo';                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
      $mail->CharSet = 'UTF-8';

      //Recipients
      $mail->setFrom('noreply@mitstudiekort.dk', 'MitStudiekort - Brugerprofil');
      $mail->addAddress($email);     //Add a recipient

      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $message;

      $mail->send();
      echo 'emailSent';
    } catch (Exception $e) {
      echo 'emailFailed';
    }
?>