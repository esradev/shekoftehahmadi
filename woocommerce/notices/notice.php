<?php

/**
 * Custom notice messages
 *
 * Override WooCommerce notice messages with styled notice markup.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.4.0
 */

if (! defined('ABSPATH')) {
  exit;
}

/** @var array $notices */
if (! isset($notices) || ! $notices) {
  return;
}
?>

<?php foreach ($notices as $notice) : ?>
  <div class="woocommerce-info" <?php echo wc_get_notice_data_attr($notice); ?> role="status">
    <div class="woocommerce-message__content">
      <?php echo wc_kses_notice($notice['notice']); ?>
    </div>
    <div class="woocommerce-message__close-wrapper">
      <button type="button" class="woocommerce-message__close" aria-label="Dismiss">
        <span class="screen-reader-text">Dismiss</span>
        <svg class="woocommerce-message__close-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
        </svg>
      </button>
    </div>
  </div>
<?php endforeach; ?>
