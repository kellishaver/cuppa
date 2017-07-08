Cuppa
====

A very simple PHP donation script backed by Stripe. I built it so people could tip small amounts of money (or large amounts, I'm not picky) with the premise "buy me a coffee."

### To install:

* Download or clone the repo to your web server.
* Edit `config/app.php` and fill in the blanks, like your Stripe API keys
* Edit the HTML and Markdown files in `template/` as desired (if at all). 
* Edit the CSS in `css/` as desired (if at all).
* `[[price-form]]` is a special template variable that gets replaced with the donation form.
* Upload to your server, point your browser at it, and it should work.

### Notes:

* I recommend doing a sample transaction in "test" mode before going live. You can change the test/live setting in `config/app.php`.
* PHP must be compiled with the `mbstring` extension for the Stripe SDK to work.
* You must have SSL to use the script in live mode. If you don't have SSL already, I recommend [LetsEncrypt](https://letsencrypt.org).
* Obviously, you need a properly configured Stripe account.
* Stripe's recent Dashboard redesign moved the API key info. You can now find it under "API" in the left sidebar.

**If you like and use this script, please consider [buying me a coffee](https://coffee.kellishaver.com).**