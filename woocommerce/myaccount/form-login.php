<?php
/**
 * Login Form
 *
 * This template overrides WooCommerce my account login/register forms with a custom layout.
 * It uses Tailwind CSS for styling and matches the contact form page design.
 *
 * @see https://woocommerce.com/document/template-structure/
 */

if (! defined('ABSPATH')) {
  exit;
}

do_action('woocommerce_before_customer_login_form');
?>

<main class="bg-white text-slate-900 antialiased">
  <section class="relative isolate bg-white py-16 sm:py-20 lg:py-24">
    <div class="mx-auto grid max-w-7xl grid-cols-1 lg:grid-cols-2">
      <div class="relative px-6 pt-24 pb-20 sm:pt-32 lg:static lg:px-8 lg:py-48">
        <div class="absolute inset-y-0 right-0 -z-10 w-full overflow-hidden bg-slate-100 ring-1 ring-slate-900/10 lg:w-1/2">
          <svg class="absolute inset-0 h-full w-full stroke-slate-200 [mask:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
            <defs>
              <pattern id="login-page-pattern" width="200" height="200" x="100%" y="-1" patternUnits="userSpaceOnUse">
                <path d="M130 200V.5M.5 .5H200" fill="none" />
              </pattern>
            </defs>
            <rect width="100%" height="100%" stroke-width="0" fill="white" />
            <svg x="100%" y="-1" class="overflow-visible fill-slate-50">
              <path d="M-470.5 0h201v201h-201Z" stroke-width="0" />
            </svg>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#login-page-pattern)" />
          </svg>
        </div>

        <div class="mx-auto max-w-xl lg:mx-0 lg:max-w-lg">
          <h2 class="text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
            <?php esc_html_e('My Account', 'woocommerce'); ?>
          </h2>
          <p class="mt-6 text-lg leading-8 text-slate-600">
            <?php esc_html_e('Access your account to view orders, manage addresses, and more.', 'woocommerce'); ?>
          </p>

          <dl class="mt-10 space-y-4 text-base leading-7 text-slate-600">
            <div class="flex gap-x-4">
              <dt class="flex-none">
                <span class="sr-only"><?php esc_html_e('Benefits', 'woocommerce'); ?></span>
                <svg class="h-7 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
              </dt>
              <dd><?php esc_html_e('View your order history and track shipments', 'woocommerce'); ?></dd>
            </div>
            <div class="flex gap-x-4">
              <dt class="flex-none">
                <span class="sr-only"><?php esc_html_e('Addresses', 'woocommerce'); ?></span>
                <svg class="h-7 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
              </dt>
              <dd><?php esc_html_e('Manage your shipping and billing addresses', 'woocommerce'); ?></dd>
            </div>
            <div class="flex gap-x-4">
              <dt class="flex-none">
                <span class="sr-only"><?php esc_html_e('Account', 'woocommerce'); ?></span>
                <svg class="h-7 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </dt>
              <dd><?php esc_html_e('Edit your account details and preferences', 'woocommerce'); ?></dd>
            </div>
          </dl>
        </div>
      </div>

      <div class="px-6 pt-20 pb-24 sm:pb-32 lg:px-8 lg:py-48">
        <div class="mx-auto max-w-xl lg:mr-0 lg:max-w-lg">
          <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
            
            <!-- Login Form -->
            <form class="mb-8 grid gap-4 rounded-2xl border border-slate-200 bg-white p-7 shadow-sm sm:p-8 woocommerce-form woocommerce-form-login login" method="post" novalidate>
              <h3 class="text-xl font-semibold text-slate-900">
                <?php esc_html_e('Login', 'woocommerce'); ?>
              </h3>

              <?php do_action('woocommerce_login_form_start'); ?>

              <label class="grid gap-2 text-sm font-medium text-slate-700">
                <span>
                  <?php esc_html_e('Username or email address', 'woocommerce'); ?>
                  <span class="text-red-500" aria-hidden="true">*</span>
                </span>
                <input type="text" 
                       class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100" 
                       name="username" 
                       id="username" 
                       autocomplete="username" 
                       value="<?php echo (! empty($_POST['username']) && is_string($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" 
                       required 
                       aria-required="true" />
              </label>

              <label class="grid gap-2 text-sm font-medium text-slate-700">
                <span>
                  <?php esc_html_e('Password', 'woocommerce'); ?>
                  <span class="text-red-500" aria-hidden="true">*</span>
                </span>
                <input type="password" 
                       class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100" 
                       name="password" 
                       id="password" 
                       autocomplete="current-password" 
                       required 
                       aria-required="true" />
              </label>

              <?php do_action('woocommerce_login_form'); ?>

              <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                <label class="flex items-center gap-3 text-sm text-slate-600">
                  <input class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500" 
                         name="rememberme" 
                         type="checkbox" 
                         id="rememberme" 
                         value="forever" />
                  <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
                </label>
              </div>

              <div class="flex flex-col gap-4">
                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                <button type="submit" 
                        class="rounded-xl bg-blue-600 px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700" 
                        name="login" 
                        value="<?php esc_attr_e('Log in', 'woocommerce'); ?>">
                  <?php esc_html_e('Log in', 'woocommerce'); ?>
                </button>
                <p class="woocommerce-LostPassword lost_password text-sm">
                  <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="text-blue-600 hover:text-blue-700">
                    <?php esc_html_e('Lost your password?', 'woocommerce'); ?>
                  </a>
                </p>
              </div>

              <?php do_action('woocommerce_login_form_end'); ?>

            </form>

            <!-- Register Form -->
            <form class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-7 shadow-sm sm:p-8 woocommerce-form woocommerce-form-register register" method="post" <?php do_action('woocommerce_register_form_tag'); ?> >
              <h3 class="text-xl font-semibold text-slate-900">
                <?php esc_html_e('Register', 'woocommerce'); ?>
              </h3>

              <?php do_action('woocommerce_register_form_start'); ?>

              <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

                <label class="grid gap-2 text-sm font-medium text-slate-700">
                  <span>
                    <?php esc_html_e('Username', 'woocommerce'); ?>
                    <span class="text-red-500" aria-hidden="true">*</span>
                  </span>
                  <input type="text" 
                         class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100" 
                         name="username" 
                         id="reg_username" 
                         autocomplete="username" 
                         value="<?php echo (! empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" 
                         required 
                         aria-required="true" />
                </label>

              <?php endif; ?>

              <label class="grid gap-2 text-sm font-medium text-slate-700">
                <span>
                  <?php esc_html_e('Email address', 'woocommerce'); ?>
                  <span class="text-red-500" aria-hidden="true">*</span>
                </span>
                <input type="email" 
                       class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100" 
                       name="email" 
                       id="reg_email" 
                       autocomplete="email" 
                       value="<?php echo (! empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" 
                       required 
                       aria-required="true" />
              </label>

              <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                <label class="grid gap-2 text-sm font-medium text-slate-700">
                  <span>
                    <?php esc_html_e('Password', 'woocommerce'); ?>
                    <span class="text-red-500" aria-hidden="true">*</span>
                  </span>
                  <input type="password" 
                         class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100" 
                         name="password" 
                         id="reg_password" 
                         autocomplete="new-password" 
                         required 
                         aria-required="true" />
                </label>

              <?php else : ?>

                <p class="text-sm text-slate-600">
                  <?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?>
                </p>

              <?php endif; ?>

              <?php do_action('woocommerce_register_form'); ?>

              <div>
                <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                <button type="submit" 
                        class="rounded-xl bg-blue-600 px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700" 
                        name="register" 
                        value="<?php esc_attr_e('Register', 'woocommerce'); ?>">
                  <?php esc_html_e('Register', 'woocommerce'); ?>
                </button>
              </div>

              <?php do_action('woocommerce_register_form_end'); ?>

            </form>

          <?php else : ?>

            <!-- Login Form Only (Registration Disabled) -->
            <form class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-7 shadow-sm sm:p-8 woocommerce-form woocommerce-form-login login" method="post" novalidate>
              <h3 class="text-xl font-semibold text-slate-900">
                <?php esc_html_e('Login', 'woocommerce'); ?>
              </h3>

              <?php do_action('woocommerce_login_form_start'); ?>

              <label class="grid gap-2 text-sm font-medium text-slate-700">
                <span>
                  <?php esc_html_e('Username or email address', 'woocommerce'); ?>
                  <span class="text-red-500" aria-hidden="true">*</span>
                </span>
                <input type="text" 
                       class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100" 
                       name="username" 
                       id="username" 
                       autocomplete="username" 
                       value="<?php echo (! empty($_POST['username']) && is_string($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" 
                       required 
                       aria-required="true" />
              </label>

              <label class="grid gap-2 text-sm font-medium text-slate-700">
                <span>
                  <?php esc_html_e('Password', 'woocommerce'); ?>
                  <span class="text-red-500" aria-hidden="true">*</span>
                </span>
                <input type="password" 
                       class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100" 
                       name="password" 
                       id="password" 
                       autocomplete="current-password" 
                       required 
                       aria-required="true" />
              </label>

              <?php do_action('woocommerce_login_form'); ?>

              <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                <label class="flex items-center gap-3 text-sm text-slate-600">
                  <input class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500" 
                         name="rememberme" 
                         type="checkbox" 
                         id="rememberme" 
                         value="forever" />
                  <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
                </label>
              </div>

              <div class="flex flex-col gap-4">
                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                <button type="submit" 
                        class="rounded-xl bg-blue-600 px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700" 
                        name="login" 
                        value="<?php esc_attr_e('Log in', 'woocommerce'); ?>">
                  <?php esc_html_e('Log in', 'woocommerce'); ?>
                </button>
                <p class="woocommerce-LostPassword lost_password text-sm">
                  <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="text-blue-600 hover:text-blue-700">
                    <?php esc_html_e('Lost your password?', 'woocommerce'); ?>
                  </a>
                </p>
              </div>

              <?php do_action('woocommerce_login_form_end'); ?>

            </form>

          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
</main>

<?php do_action('woocommerce_after_customer_login_form');
