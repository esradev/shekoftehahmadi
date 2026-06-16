<?php

/**
 * Custom error notices
 *
 * Override WooCommerce error messages with styled notice markup.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

if (! defined('ABSPATH')) {
  exit;
}

/** @var array $notices */
if (! isset($notices) || ! $notices) {
  return;
}
?>

<ul class="woocommerce-error" role="alert">
  <?php foreach ($notices as $notice) : ?>
    <li <?php echo wc_get_notice_data_attr($notice); ?>>
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
    </li>
  <?php endforeach; ?>
</ul>
