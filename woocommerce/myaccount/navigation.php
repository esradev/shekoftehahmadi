<?php
/**
 * My Account navigation
 *
 * This template overrides WooCommerce account navigation with a custom sidebar layout.
 * It uses Tailwind CSS for styling and matches the checkout page design.
 *
 * @see https://woocommerce.com/document/template-structure/
 */

if (! defined('ABSPATH')) {
  exit;
}

do_action('woocommerce_before_account_navigation');
?>

<nav class="rounded-lg bg-white p-4 shadow-sm" aria-label="<?php esc_html_e('Account pages', 'woocommerce'); ?>">
  <ul class="space-y-1">
    <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
      <li>
        <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" 
           class="block rounded-md px-3 py-2 text-sm font-medium transition-colors
                  <?php echo wc_is_current_account_menu_item($endpoint) 
                    ? 'bg-indigo-50 text-indigo-700' 
                    : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900'; ?>"
           <?php echo wc_is_current_account_menu_item($endpoint) ? 'aria-current="page"' : ''; ?>>
          <?php echo esc_html($label); ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>
