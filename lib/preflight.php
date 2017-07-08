<?php
  
  // Validate our congif file
  // Set defaults where possible/needed

  // Objects are more pleasant than arrays
  $config = (object) $config;

  // We have to definitely set a payment mode - no default on th is,
  // so we're not preventing or forcing real sales
  if ($config->mode != "test" && $config->mode != "live") {
    die("Payment mode not set (should be 'test' or 'live').");
  }

  // Set Stripe access tokens based on mode
  if ($config->mode == "test") {
    $secret_key = $config->test_secret_key;
    $publishable_key = $config->test_publishable_key;
  } else if ($config->mode == "live") {
    $secret_key = $config->live_secret_key;
    $publishable_key = $config->live_publishable_key;
  }

  // We must have Stripe keys!
  if (empty($secret_key) || empty($publishable_key)) {
    die("Stripe keys not set correctly.");
  }

  // Default to the Stripe account's currency if none present
  if(empty($config->currency_code)) {
    $config->currency_code = "auto";
  }

  // Product must have a name
  if(empty($config->site_name)) {
    die("Site name not set.");
  }

  // Price must be an integer, cast it as such,
  // just in case
  $config->price_in_cents = (integer) $config->price_in_cents;

  // Default buy now button text
  if(empty($config->buy_now_button_text)) {
    $config->buy_now_button_text = "Buy Now";
  }

  \Stripe\Stripe::setApiKey($secret_key);
