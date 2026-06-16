<?php

/**
 * Checkout Login Form
 *
 * This template overrides WooCommerce checkout login form with a custom layout.
 * It uses Tailwind CSS for styling and matches the checkout form design.
 *
 * @see https://woocommerce.com/document/template-structure/
 */

if (! defined('ABSPATH')) {
  exit;
}

if (is_user_logged_in() || 'no' === get_option('woocommerce_enable_checkout_login_reminder')) {
  return;
}
?>

<div class="mb-8">
  <p class="text-sm text-slate-600">
    <?php esc_html_e('Returning customer?', 'woocommerce'); ?>
    <a href="#" id="show-login-form" class="ml-1 text-indigo-600 hover:text-indigo-500"><?php esc_html_e('Click here to login', 'woocommerce'); ?></a>
  </p>

  <div id="checkout-login-form" class="hidden mt-6 rounded-2xl border border-slate-200 bg-white p-7 shadow-sm sm:p-8">
    <h2 class="mb-4 text-xl font-semibold text-slate-900"><?php esc_html_e('Login', 'woocommerce'); ?></h2>

    <p class="mb-6 text-sm text-slate-600">
      <?php esc_html_e('If you have shopped with us before, please enter your details below.', 'woocommerce'); ?>
    </p>

    <form class="woocommerce-form woocommerce-form-login login grid gap-4" method="post" novalidate>

    <label class="grid gap-2 text-sm font-medium text-slate-700">
      <span for="username">
        <?php esc_html_e('Username or email', 'woocommerce'); ?>&nbsp;<span class="required text-red-500" aria-hidden="true">*</span>
      </span>
      <input type="text" class="block w-full rounded-md bg-white px-3 py-2 text-base text-slate-900 outline-1 outline-offset-1 outline-slate-300 placeholder:text-slate-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm romonet-checkout-input" name="username" id="username" autocomplete="username" required aria-required="true" />
    </label>

    <label class="grid gap-2 text-sm font-medium text-slate-700">
      <span for="password">
        <?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required text-red-500" aria-hidden="true">*</span>
      </span>
      <input class="block w-full rounded-md bg-white px-3 py-2 text-base text-slate-900 outline-1 outline-offset-1 outline-slate-300 placeholder:text-slate-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm romonet-checkout-input woocommerce-Input" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
    </label>

    <div class="flex items-center gap-2">
      <label class="flex items-center gap-2 text-sm text-slate-700">
        <input class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
        <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
      </label>
    </div>

    <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
    <input type="hidden" name="redirect" value="<?php echo esc_url(wc_get_page_permalink('checkout')); ?>" />
    <button type="submit" class="inline-flex w-full items-center justify-center rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-50 focus:outline-hidden woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e('Login', 'woocommerce'); ?>">
      <?php esc_html_e('Login', 'woocommerce'); ?>
    </button>

    <p class="text-sm text-slate-600">
      <a href="<?php echo esc_url(wc_lostpassword_url()); ?>" class="text-indigo-600 hover:text-indigo-500">
        <?php esc_html_e('Lost your password?', 'woocommerce'); ?>
      </a>
    </p>
  </form>
  </div>
</div>

<script type="text/javascript">
  (function() {
    var showLoginButton = document.getElementById('show-login-form');
    var loginForm = document.getElementById('checkout-login-form');

    if (!showLoginButton || !loginForm) {
      return;
    }

    showLoginButton.addEventListener('click', function(e) {
      e.preventDefault();
      loginForm.classList.toggle('hidden');
      showLoginButton.classList.toggle('hidden');
    });
  })();
</script>
