<?php


$endpoint_secret = 'whsec_abc9b87e1599a9de70cbe72fbc0d9c33aa071662568cecc9c4eb651f15cb0bd1';

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
  $event = \Stripe\Webhook::constructEvent(
    $payload, $sig_header, $endpoint_secret
  );
} catch(\UnexpectedValueException $e) {
  http_response_code(400);
  exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
  http_response_code(400);
  exit();
}

$fd = fopen("hello.txt", 'w') or die("не удалось создать файл");
fwrite($fd, var_dump($event));
fclose($fd);

switch ($event->type) {
  case 'checkout.session.completed':
    $paymentIntent = $event->data->object;
  default:
    echo 'Received unknown event type ' . $event->type;
}

http_response_code(200);
