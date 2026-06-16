<?php

/**
 * Theme setup and supported features.
 */

if (! defined('ABSPATH')) {
  exit;
}

if (! function_exists('romonet_theme_setup')) {
  function romonet_theme_setup()
  {
    load_theme_textdomain('romonet', get_theme_file_path('/languages'));

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_editor_style('build/index.css');
    add_theme_support('wp-block-styles');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    add_image_size('romonet-card', 720, 540, true);
    add_image_size('romonet-hero', 1600, 900, true);
  }
}
add_action('after_setup_theme', 'romonet_theme_setup');
