<?php

$config = array(
  // Stripe mode - should be "test" or "live"
  // Note: You should always test your sales page in test mode
  // before accepting live charges.
  "mode" => "test",

  // Your Stripe test mode secret key
  "test_secret_key" => "",

  // Your Stripe test mode publishable key
  "test_publishable_key" => "",

  // Your stripe live mode secret key 
  "live_secret_key" => "",

  // Your Stripe live mode publishable key
  "live_publishable_key" => "",

  // The 3-letter currency code for your local currency
  // Note: your customers will be able to pay with different
  // currencies - payments will be converted to your local currency
  //
  // More info on currencies can be found here:
  //    https://support.stripe.com/questions/which-currencies-does-stripe-support
  "currency_code" => "USD",

  // The name of your product (used on the checkout form)
  "site_name" => "Buy Me A Coffee",

  // A short description of your product (used on the checkout form)
  "short_description" => "Be Awesome",

  // Number only - the price of your product in cents (or your currency's smallest 
  // denomination) - this value can be changed.
  "price_in_cents" => 500, // $5.00
);
