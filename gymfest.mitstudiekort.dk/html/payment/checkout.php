<?php
session_start();
$eventid = $_REQUEST['id'];
$eventid = htmlspecialchars($eventid, ENT_QUOTES, 'UTF-8');

$_SESSION['purchase_event_id'] = $eventid;

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Buy cool new product</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script src="https://js.stripe.com/v3/"></script>
  </head>
  <body>
    <section>
      <div class="product">
        <img
          src="https://i.imgur.com/EHyR2nP.png"
          alt="The cover of Stubborn Attachments"
        />
        <div class="description">
          <h3>Stubborn Attachments</h3>
          <h5>$20.00</h5>
        </div>
      </div>
      <button type="button" id="checkout-button">Checkout</button>
    </section>
  </body>
  <script type="text/javascript">
    // Create an instance of the Stripe object with your publishable API key
    var stripe = Stripe("pk_test_51IngTGK7oIGdMTyiPOHIVNHAR1VALsfKK04WJRYGvATn6U1EDU29OQm4sKumSZp8FjTw6hyk83HAyRPLOivEkQyD00xv2JDkoO");
    var checkoutButton = document.getElementById("checkout-button");

    checkoutButton.addEventListener("click", function () {
      fetch("create-checkout-session.php?eid=<?php echo $eventid; ?>", {
        method: "POST",
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (session) {
          return stripe.redirectToCheckout({ sessionId: session.id });
        })
        .then(function (result) {
          // If redirectToCheckout fails due to a browser or network
          // error, you should display the localized error message to your
          // customer using error.message.
          if (result.error) {
            alert(result.error.message);
          }
        })
        .catch(function (error) {
          console.error("Error:", error);
        });
    });
  </script>
</html>