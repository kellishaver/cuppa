<form action="charge.php" method="POST" class="price-form">
  <input type="hidden" name="stripe_email">
  <input type="hidden" name="stripe_token">
  <input type="hidden" name="amount">
  <label>$<input type="number" size="4" value="5" id="donate-amount">USD</label><br><br>
  <button id="donate_button"><?= $config->short_description ?></button>
</form>

<script src="https://checkout.stripe.com/checkout.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
  var handler = StripeCheckout.configure({
    key:"<?= $publishable_key; ?>",
    amount:<?= $config->price_in_cents ?>,
    name:"<?= $config->site_name ?>",
    description:"<?= $config->short_description ?>",
    currency:"<?= $config->currency_code ?>",
    token: function(token) {
      $('input[name="stripe_email"]').val(token.email);
      $('input[name="stripe_token"]').val(token.id);
      $('input[name="amount"]').val($('#donate-amount').val() * 100);
      $('form').submit();
    }
  });

  $(function() {
    $('body').on('click', '#donate_button', function(e) {
      e.preventDefault();
      var amount = $('#donate-amount').val();
      amount = amount.replace(/\$/g, '').replace(/\,/g, '')
      amount = parseFloat(amount);
      if (isNaN(amount)) {
        alert('Please enter a valid amount.');
      }
      else if (amount < 1.00) {
        alert('Donation amount must be at least $1 to cover processing fees.');
      } else {
        amount = amount * 100;
        handler.open({
          amount: Math.round(amount)
        });
      }
    });
  });
</script>
