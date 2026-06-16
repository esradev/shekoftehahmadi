<?php

/**
 * Navigation registration.
 */

if (! defined('ABSPATH')) {
  exit;
}

if (! function_exists('romonet_register_menus')) {
  function romonet_register_menus()
  {
    register_nav_menus(
      array(
        'primary' => esc_html__('Primary Menu', 'romonet'),
        'top-bar' => esc_html__('Top Bar Menu', 'romonet'),
        'footer'  => esc_html__('Footer Menu', 'romonet'),
        'legal'   => esc_html__('Legal Menu', 'romonet'),
      )
    );
  }
}
add_action('after_setup_theme', 'romonet_register_menus');
