<?php

/**
 * Front page query helpers.
 */

if (! defined('ABSPATH')) {
  exit;
}

if (! function_exists('romonet_get_post_summary')) {
  function romonet_get_post_summary($post_id, $words = 22)
  {
    $post_id = absint($post_id);
    if (! $post_id) {
      return '';
    }

    $excerpt = get_post_field('post_excerpt', $post_id);
    if (is_string($excerpt) && '' !== trim($excerpt)) {
      return wp_trim_words(wp_strip_all_tags($excerpt), $words);
    }

    $content = get_post_field('post_content', $post_id);

    return wp_trim_words(wp_strip_all_tags($content), $words);
  }
}

if (! function_exists('romonet_get_home_archive_url')) {
  function romonet_get_home_archive_url($post_type)
  {
    $link = get_post_type_archive_link($post_type);

    return $link ? $link : home_url('/');
  }
}

if (! function_exists('romonet_get_home_shop_url')) {
  function romonet_get_home_shop_url()
  {
    if (function_exists('wc_get_page_permalink')) {
      $shop_url = wc_get_page_permalink('shop');
      if ($shop_url) {
        return $shop_url;
      }
    }

    return home_url('/shop/');
  }
}

if (! function_exists('romonet_get_home_products_query')) {
  function romonet_get_home_products_query($limit = 4)
  {
    if (! class_exists('WooCommerce')) {
      return new WP_Query(array('post__in' => array(0)));
    }

    return new WP_Query(
      array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => max(1, absint($limit)),
        'orderby'        => 'date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
      )
    );
  }
}
