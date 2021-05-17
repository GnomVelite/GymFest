<?php
session_start();
//ini_set('display_errors',1);
//error_reporting(E_ALL);

$eventid = $_SESSION['purchase_event_id'];
$userid = $_SESSION['purchase_user_id'];

include '../conn.php';
require_once('../stripe-php/init.php');

\Stripe\Stripe::setApiKey('sk_test_51IngTGK7oIGdMTyiKubdQEDhAKhLekrOfb1F2CswwVdYXkaYVqWogq1XlNfB7O1chs2WpVmx4LQyRxl80evmHVBM00UUDLHLAW');

function print_log($val) {
  return file_put_contents('php://stderr', print_r($val, TRUE));
}

// You can find your endpoint's secret in your webhook settings
$endpoint_secret = 'whsec_pnufDB5Mf0idWN2sCXO1WiXr6dZLGM90';

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
  $event = \Stripe\Webhook::constructEvent(
    $payload, $sig_header, $endpoint_secret
  );
} catch(\UnexpectedValueException $e) {
  // Invalid payload
  http_response_code(400);
  exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
  // Invalid signature
  http_response_code(400);
  exit();
}

function fulfill_order($session) {
  global $conn;
  $stripe_id = $session->id;
  //$stripe_id = 'ez';
  $status = 'checkout.session.completed';

  print_log("Fulfilling order...");
  print_log($session);

  $paymentsql = "INSERT INTO `payments` (`stripe_id`, `status`, `timestamp`) VALUES ('$stripe_id', '$status', CURRENT_TIME())";
  if ($conn->query($paymentsql)) {
    http_response_code(200);
    //unset($_SESSION['purchase_event_id']);
    //unset($_SESSION['purchase_user_id']);

  } else {
    http_response_code(400);
  }
}

function create_ticket($session) {
  global $conn;
  $validToken = false;

  $stripe_id = $session->id;
  $userid = $session->metadata->userid;
  $eventid = $session->metadata->eventid;

  while(true) {
    $token = rand(100000000, 999999999);

    $sql = "SELECT id FROM `tickets` WHERE ticketToken = '".($token)."'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
      break;
    }
  }

  if ($session->metadata->onlyplusone > 0) {
    $ticketsql = "INSERT INTO `tickets` (`userId`,`eventId`,`ticketToken`, `stripe_id`, `status`, `type`) VALUES ('$userid', '$eventid', '$token', '$stripe_id', 'VALID', 'PLUSONE')";
    if ($conn->query($ticketsql)) {
      http_response_code(200);
    } else {
      http_response_code(400);
    }
  } else {
    $ticketsql = "INSERT INTO `tickets` (`userId`,`eventId`,`ticketToken`, `stripe_id`, `status`, `type`) VALUES ('$userid', '$eventid', '$token', '$stripe_id', 'VALID', 'PERSONAL')";
    if ($conn->query($ticketsql)) {
      http_response_code(200);
    } else {
      http_response_code(400);
    }
  }



  if ($session->metadata->plusones > 0) {
    while(true) {
      $token = rand(100000000, 999999999);
  
      $sql = "SELECT id FROM `tickets` WHERE ticketToken = '".($token)."'";
      $result = $conn->query($sql);
      if ($result->num_rows == 0) {
        break;
      }
    }
  
    $ticketsql = "INSERT INTO `tickets` (`userId`,`eventId`,`ticketToken`, `stripe_id`, `status`, `type`) VALUES ('$userid', '$eventid', '$token', '$stripe_id', 'VALID', 'PLUSONE')";
    if ($conn->query($ticketsql)) {
      http_response_code(200);
    } else {
      http_response_code(400);
    }
  }
}

function verifyPurchase($session) {
  $sql = "SELECT id FROM `tickets` WHERE ticketToken = '".($token)."'";
  $result = $conn->query($sql);

  if ($result->num_rows == 0) {
    create_ticket($session);
    fulfill_order($session);
  }
}

// Handle the checkout.session.completed event
if ($event->type == 'checkout.session.completed') {
  $session = $event->data->object;

  // Fulfill the purchase...
  //verifyPurchase($session);
  create_ticket($session);
  fulfill_order($session);
}

// Handle the payment_intent.create event
if ($event->type == 'payment_intent.create') {
  $session = $event->data->object;

  // Create the ticket...
}

http_response_code(200);