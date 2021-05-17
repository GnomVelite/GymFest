<?php

//ini_set('display_errors',1);
//error_reporting(E_ALL);
session_start();
include 'conn.php';
include "../api/onsite/auth/msapi.php";

$eventid = $_REQUEST['eid'];
$eventid = htmlspecialchars($eventid, ENT_QUOTES, 'UTF-8');

$plusones = $_REQUEST['po'];
$plusones = htmlspecialchars($plusones, ENT_QUOTES, 'UTF-8');

$onlyplusones = $_REQUEST['opo'];
$onlyplusones = htmlspecialchars($onlyplusones, ENT_QUOTES, 'UTF-8');


if (isset($_SESSION["userdata"])) {
  $user = $_SESSION["userdata"];
} else {
  $user = new User($_SESSION["mstoken"], 1);
  $user->fetch_user();
  $user = $user->data;
}

//$plusones = 1;
// $_SESSION['purchase_event_id'] = $eventid;
// $_SESSION['purchase_user_id'] = $user->id;

$_SESSION['purchase_event_id'] = 1;
$_SESSION['purchase_user_id'] = 2;

$eventName = "";
$eventPrice = 0;

require_once('./stripe-php/init.php');
\Stripe\Stripe::setApiKey('sk_test_51IngTGK7oIGdMTyiKubdQEDhAKhLekrOfb1F2CswwVdYXkaYVqWogq1XlNfB7O1chs2WpVmx4LQyRxl80evmHVBM00UUDLHLAW');

header('Content-Type: application/json');

$YOUR_DOMAIN = 'https://gymfest.mitstudiekort.dk/payment';

function get_event_details($eventid) {
  global $conn;
  global $eventPrice;
  global $eventName;

  $eventsql = "SELECT price, name FROM events WHERE `id` = '".($eventid)."'";
  $eventResult = $conn->query($eventsql);

  if($eventResult->num_rows > 0) {
      while($row = $eventResult -> fetch_assoc()) {
          $eventName = $row["name"];
          $eventPrice = $row["price"];

          $eventPrice = $eventPrice*100;
      }
  } else {
      $eventName = "Fuck - ".$eventid;
      $eventPrice = 69420;
  }

}

get_event_details($eventid);

$plusOneSessionData = [];
$onlyPlusOneSessionData = [];

if($plusones > 0) {
  $plusOneSessionData = [
                          'price_data' => [
                            'currency' => 'dkk',
                            'unit_amount' => $eventPrice,
                            'product_data' => [
                              'name' => "PLUS ONE - ".$eventName,
                            ],
                          ],
                          'quantity' => 1,
                        ];
}

if ($onlyplusones == 0) {
  $onlyPlusOneSessionData = [
                              'price_data' => [
                                'currency' => 'dkk',
                                'unit_amount' => $eventPrice,
                                'product_data' => [
                                  'name' => $eventName,
                                ],
                              ],
                              'quantity' => 1,
                            ];
}

if ($onlyplusones == 1) {
  $onlyPlusOneSessionData = [
    'price_data' => [
      'currency' => 'dkk',
      'unit_amount' => $eventPrice,
      'product_data' => [
        'name' => $eventName,
      ],
    ],
    'quantity' => 1,
  ];
}

$checkout_session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [
    $onlyPlusOneSessionData,
    $plusOneSessionData,
  ],
  'mode' => 'payment',
  'metadata' => [
    'userid' => $user->id,
    'eventid' => $eventid,
    'plusones' => $plusones,
    'onlyplusone' => $onlyplusones,
  ],
  'success_url' => 'https://gymfest.mitstudiekort.dk/student/tickets?action=purchase',
  'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);

echo json_encode(['id' => $checkout_session->id]);
//var_dump($plusOneSessionData);
//echo json_encode($eventid);