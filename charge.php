<?php
  // Error Reporting - should be 0 unless you're debugging
  ini_set('display_errors', 0);
  ini_set('display_startup_errors', 0);
  //error_reporting(E_ALL);

  // Global config
  require_once(dirname(__FILE__) . '/config/app.php');

  // Required libraries
  require_once(dirname(__FILE__) . '/lib/Parsedown.php');
  require_once(dirname(__FILE__) . '/lib/stripe-php-3.9.0/init.php');

  // Config file validation and Stripe init
  require_once(dirname(__FILE__) . '/lib/preflight.php');

  // Generate a u nique ID for this order
  $order_id = uniqid();

  // Markdown parser
  $Parsedown = new Parsedown();

  // Init some variables
  $customer     = false;
  $charge       = false;
  $order        = false;
  $order_record = false;

  if (isset($_POST) && isset($_POST['stripe_email']) && isset($_POST['stripe_token']) && isset($_POST['amount'])) {
    // Attempt to create customer and associated charge
    try {
      $customer = \Stripe\Customer::create(array(
        'email' => $_POST['stripe_email'],
        'card'  => $_POST['stripe_token']
      ));
    } catch (Exception $e) {
      // do nothing.
    }

    if($customer) {
      // Customer record created, try charging
      try {
        $charge = \Stripe\Charge::create(array(
          'customer' => $customer->id,
          'amount'   => $_POST['amount'],
          'currency' => $config->currency_code,
          'description' => 'Order ID: ' . $order_id
        ));
      } catch (Exception $e) {
        // Do nothing.
      }
    }

    // Check for ustomer record created, charge succeeded, order record saved
    if($customer && $charge) {
      // Payment succeeded, show the thank you message
      if($charge->paid) {
        $output = $Parsedown->text(file_get_contents(dirname(__FILE__) . '/templates/thank_you.md'));
      } else {
        $output = $Parsedown->text(file_get_contents(dirname(__FILE__) . '/templates/payment_error.md'));
      }
    } else {
      // Payment succeeded, but saving order failed, show the order message
      $output = $Parsedown->text(file_get_contents(dirname(__FILE__) . '/templates/payment_error.md'));
    }
  } else {
    // POST vars missing, show the payment error page.
    $output = $Parsedown->text(file_get_contents(dirname(__FILE__) . '/templates/payment_error.md'));
  }

  // Render the page
  include(dirname(__FILE__) . '/templates/inc/header.php');
  echo $output;
  include(dirname(__FILE__) . '/templates/inc/footer.php');