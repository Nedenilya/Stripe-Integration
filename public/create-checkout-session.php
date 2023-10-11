<?php

require 'vendor/autoload.php';
require_once 'config.php';

\Stripe\Stripe::setApiKey(STRIPE_API_KEY);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  echo 'Invalid request';
  exit;
}

$checkout_session = \Stripe\Checkout\Session::create([
  'success_url' => DOMAIN_URL . '/success.php?session_id={CHECKOUT_SESSION_ID}&plan=' . $_POST['plan'],
  'cancel_url' => DOMAIN_URL . '/canceled.php',
  'mode' => 'subscription',
  'line_items' => [[
    'price' => $_POST['priceId'],
    'quantity' => 1,
  ]]
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
