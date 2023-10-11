<?php
  require 'vendor/autoload.php';
  require_once 'config.php';
  require_once 'dbConnect.php';

  \Stripe\Stripe::setApiKey(STRIPE_API_KEY);

  $checkout_session_id = $_GET['session_id'];
  $checkout_session = \Stripe\Checkout\Session::retrieve($checkout_session_id);

  $sql = 'INSERT INTO users (name, email) VALUES (\'' . $checkout_session['customer_details']['name']. '\', \'' . $checkout_session['customer_details']['email'] . '\');';

  if(!$db->query($sql)){
      echo "Error: " . $db->error;
  }

  $plan = $_GET['plan'];
  $price = $checkout_session['amount_total'];
  $status = $checkout_session['status'];

  $sql = 'INSERT INTO user_subscriptions 
          (cs_id, user_id, plan, price, status) 
          VALUES (\'' . $checkout_session['id'] . '\' , LAST_INSERT_ID(), \'' . $plan . '\', ' . substr($price, 0, strlen($price) - 2) . ', \'' . $status . '\');';
            
  if(!$db->query($sql)){
      echo "Error: " . $db->error;
  }

  $db->close();

  $session_json = json_encode($checkout_session, JSON_PRETTY_PRINT);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Stripe Checkout</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/global.css" />
  </head>
  <body>
    <div class="sr-root">
      <div class="sr-main">
        <div class="sr-payment-summary completed-view">
          <h1>Payment succeeded</h1>
          <h4>
            View CheckoutSession response:</a>
          </h4>
        </div>
        <div class="sr-section completed-view">
          <div class="sr-callout">
            <pre><?= $session_json ?></pre>
          </div>
          <button onclick="window.location.href = '/public';">Restart</button>
        </div>
      </div>
    </div>
  </body>
</html>
