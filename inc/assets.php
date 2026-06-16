<?php

/**
 * Asset loading strategy.
 */

if (! defined('ABSPATH')) {
  exit;
}

if (! function_exists('romonet_get_asset_version')) {
  function romonet_get_asset_version($relative_path)
  {
    $path = get_theme_file_path($relative_path);

    if (file_exists($path)) {
      return (string) filemtime($path);
    }

    return wp_get_theme()->get('Version');
  }
}

if (! function_exists('romonet_enqueue_assets')) {
  function romonet_enqueue_assets()
  {
    wp_enqueue_style(
      'romonet-fonts',
      get_theme_file_uri('/assets/fonts.css'),
      array(),
      romonet_get_asset_version('/assets/fonts.css')
    );

    wp_enqueue_style(
      'romonet-theme',
      get_theme_file_uri('/build/index.css'),
      array('romonet-fonts'),
      romonet_get_asset_version('/build/index.css')
    );

    wp_enqueue_script('romonet-theme', get_theme_file_uri('/build/index.js'), array(), romonet_get_asset_version('/build/index.js'), true);

    // Enqueue forms.js for contact/project pages and global newsletter footer form
    if (! is_admin()) {
        wp_enqueue_script(
            'romonet-forms',
            get_theme_file_uri('/assets/js/forms.js'),
            array(),
            romonet_get_asset_version('/assets/js/forms.js'),
            true
        );

        wp_localize_script('romonet-forms', 'romonetFormsData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('romonet_form_nonce'),
        ));
    }

    wp_add_inline_style('romonet-theme', romonet_checkout_inline_styles());

    wp_enqueue_script(
      'romonet-alpine',
      'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js',
      array(),
      null,
      true
    );

    wp_script_add_data('romonet-alpine', 'strategy', 'defer');
  }
}

if (! function_exists('romonet_checkout_inline_styles')) {
  function romonet_checkout_inline_styles()
  {
    return '.woocommerce-checkout .woocommerce-billing-fields__field-wrapper, .woocommerce-checkout .woocommerce-shipping-fields__field-wrapper, .woocommerce-checkout .woocommerce-address-fields__field-wrapper, .woocommerce-checkout .woocommerce-additional-fields__field-wrapper, .woocommerce-checkout .woocommerce-account-fields { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.5rem; }
    .woocommerce-checkout .form-row { margin: 0 0 1.5rem; }
    .woocommerce-checkout .form-row.form-row-wide { grid-column: 1 / -1; }
    .woocommerce-checkout .form-row label { display: block; margin-bottom: 0.5rem; font-size: 0.9375rem; font-weight: 600; color: #0f172a; }
    .woocommerce-checkout .woocommerce-input-wrapper { display: block; }
    .woocommerce-checkout .woocommerce-input-wrapper input.input-text, .woocommerce-checkout .woocommerce-input-wrapper select, .woocommerce-checkout .woocommerce-input-wrapper textarea, .woocommerce-checkout .woocommerce-input-wrapper .select2-selection, .woocommerce-checkout .woocommerce-input-wrapper .country_select, .woocommerce-checkout .woocommerce-input-wrapper .state_select { width: 100%; min-height: 3rem; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 1rem; background-color: #ffffff; color: #0f172a; font-size: 0.9375rem; transition: border-color 0.2s ease, box-shadow 0.2s ease; }
    .woocommerce-checkout .woocommerce-input-wrapper input.input-text:focus, .woocommerce-checkout .woocommerce-input-wrapper select:focus, .woocommerce-checkout .woocommerce-input-wrapper textarea:focus { border-color: #6366f1; outline: none; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15); }
    .woocommerce-checkout .form-row.woocommerce-invalid .input-text, .woocommerce-checkout .form-row.woocommerce-invalid .select, .woocommerce-checkout .form-row.woocommerce-invalid .country_select, .woocommerce-checkout .form-row.woocommerce-invalid .state_select { border-color: #ef4444; }
    .woocommerce-checkout .woocommerce-form__label-for-checkbox { display: inline-flex; align-items: flex-start; gap: 0.75rem; }
    .woocommerce-checkout .input-checkbox { margin-top: 0.125rem; }
    .woocommerce-checkout .woocommerce-checkout-payment, .woocommerce-checkout .woocommerce-checkout-review-order-table { margin-top: 2rem; }
    .woocommerce-checkout .form-row.romonet-checkout-row { width: 100%; }
    .woocommerce-checkout .romonet-checkout-label { margin-bottom: 0.5rem; }
    .woocommerce-checkout .romonet-checkout-input { border-radius: 1rem; }';
  }
}
add_action('wp_enqueue_scripts', 'romonet_enqueue_assets');
