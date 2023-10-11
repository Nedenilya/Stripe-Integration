<?php
require 'vendor/autoload.php';
require_once 'config.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Stripe Checkout Sample</title>
    <meta name="description" content="A demo of Stripe Payment Intents" />

    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/global.css" />
    <script src="https://js.stripe.com/v3/"></script>
  </head>

  <body>
    <div class="sr-root">
      <div class="sr-main" style="display: flex;">
        <div class="sr-container">
          <section class="container">
            <div>
              <h1>Basic subscription</h1>
            </div>
            <form action="/public/create-checkout-session.php" method="POST">
              <input type="hidden" name="plan" value="Basic" />
              <input type="hidden" name="priceId" value="<?=BASIC_PRICE; ?>" />
              <button>$12.00</button>
            </form>
          </section>
          <section class="container">
            <div>
              <h1>Pro subscription</h1>
            </div>
            <form action="/public/create-checkout-session.php" method="POST">
              <input type="hidden" name="plan" value="Pro" />
              <input type="hidden" name="priceId" value="<?=PRO_PRICE; ?>" />
              <button>$210.00</button>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
