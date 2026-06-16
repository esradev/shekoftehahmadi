<?php
/**
 * My Account page
 *
 * This template overrides WooCommerce my account output with a custom layout.
 * It uses Tailwind CSS for styling and matches the checkout page design.
 *
 * @see https://woocommerce.com/document/template-structure/
 */

if (! defined('ABSPATH')) {
  exit;
}

$current_user = wp_get_current_user();
?>

<div class="min-h-screen bg-slate-50">
  <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-slate-900">
        <?php esc_html_e('My Account', 'woocommerce'); ?>
      </h1>
      <p class="mt-2 text-slate-600">
        <?php
        printf(
          /* translators: 1: user display name */
          esc_html__('Welcome back, %s!', 'woocommerce'),
          esc_html($current_user->display_name)
        );
        ?>
      </p>
    </div>

    <div class="lg:flex lg:gap-8">
      
      <!-- Navigation Sidebar -->
      <aside class="lg:w-64 lg:flex-shrink-0">
        <?php do_action('woocommerce_account_navigation'); ?>
      </aside>

      <!-- Main Content Area -->
      <main class="mt-8 flex-1 lg:mt-0">
        <div class="rounded-lg bg-white p-6 shadow-sm">
          <?php do_action('woocommerce_account_content'); ?>
        </div>
      </main>
      
    </div>
    
  </div>
</div>
