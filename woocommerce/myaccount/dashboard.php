<?php
/**
 * My Account Dashboard
 *
 * This template overrides WooCommerce dashboard with a custom layout.
 * It uses Tailwind CSS for styling and matches the checkout page design.
 *
 * @see https://woocommerce.com/document/template-structure/
 */

if (! defined('ABSPATH')) {
  exit;
}

$allowed_html = array(
  'a' => array(
    'href' => array(),
  ),
);
?>

<div class="space-y-6">
  
  <!-- Welcome Section -->
  <div class="rounded-lg bg-indigo-50 p-6">
    <p class="text-lg font-medium text-slate-900">
      <?php
      printf(
        /* translators: 1: user display name 2: logout url */
        wp_kses(__('Hello %1$s (not %1$s? <a href="%2$s" class="text-indigo-600 hover:text-indigo-500">Log out</a>)', 'woocommerce'), $allowed_html),
        '<strong>' . esc_html($current_user->display_name) . '</strong>',
        esc_url(wc_logout_url())
      );
      ?>
    </p>
  </div>

  <!-- Dashboard Description -->
  <div class="rounded-lg bg-slate-50 p-6">
    <p class="text-slate-700">
      <?php
      /* translators: 1: Orders URL 2: Address URL 3: Account URL. */
      $dashboard_desc = __('From your account dashboard you can view your <a href="%1$s" class="text-indigo-600 hover:text-indigo-500">recent orders</a>, manage your <a href="%2$s" class="text-indigo-600 hover:text-indigo-500">billing address</a>, and <a href="%3$s" class="text-indigo-600 hover:text-indigo-500">edit your password and account details</a>.', 'woocommerce');
      if (wc_shipping_enabled()) {
        /* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
        $dashboard_desc = __('From your account dashboard you can view your <a href="%1$s" class="text-indigo-600 hover:text-indigo-500">recent orders</a>, manage your <a href="%2$s" class="text-indigo-600 hover:text-indigo-500">shipping and billing addresses</a>, and <a href="%3$s" class="text-indigo-600 hover:text-indigo-500">edit your password and account details</a>.', 'woocommerce');
      }
      printf(
        wp_kses($dashboard_desc, $allowed_html),
        esc_url(wc_get_endpoint_url('orders')),
        esc_url(wc_get_endpoint_url('edit-address')),
        esc_url(wc_get_endpoint_url('edit-account'))
      );
      ?>
    </p>
  </div>

  <?php
  /**
   * My Account dashboard.
   *
   * @since 2.6.0
   */
  do_action('woocommerce_account_dashboard');

  /**
   * Deprecated woocommerce_before_my_account action.
   *
   * @deprecated 2.6.0
   */
  do_action('woocommerce_before_my_account');

  /**
   * Deprecated woocommerce_after_my_account action.
   *
   * @deprecated 2.6.0
   */
  do_action('woocommerce_after_my_account');
  ?>

</div>
