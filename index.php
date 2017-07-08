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

  // Get the price adjustment form into a variable.
  ob_start();
    require_once(__DIR__.'/lib/price_form.php');
    $price_form = ob_get_contents();
  ob_end_clean();

  // Markdown parser
  $Parsedown = new Parsedown();

  // Parse the product info page
  $product_info = $Parsedown->text(file_get_contents(dirname(__FILE__) . '/templates/index.md'));

  // Replace the [[price-form]] template var with the buy now button code
  $product_info = str_replace("[[price-form]]", $price_form, $product_info);

  // Render the page
  include(dirname(__FILE__) . '/templates/inc/header.php');
  echo $product_info;
  include(dirname(__FILE__) . '/templates/inc/footer.php');
