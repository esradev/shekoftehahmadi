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

if (! function_exists('romonet_get_home_featured_query')) {
  function romonet_get_home_featured_query($post_type, $limit = 3, $meta_key = 'featured')
  {
    $limit = max(1, absint($limit));
    $ids   = get_posts(
      array(
        'post_type'      => $post_type,
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'fields'         => 'ids',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
          array(
            'key'     => $meta_key,
            'value'   => '1',
            'compare' => '=',
          ),
        ),
      )
    );

    if (count($ids) < $limit) {
      $more_ids = get_posts(
        array(
          'post_type'      => $post_type,
          'post_status'    => 'publish',
          'posts_per_page' => $limit - count($ids),
          'post__not_in'   => $ids,
          'fields'         => 'ids',
          'orderby'        => 'date',
          'order'          => 'DESC',
        )
      );
      $ids = array_merge($ids, $more_ids);
    }

    if (empty($ids)) {
      return new WP_Query(array('post__in' => array(0)));
    }

    return new WP_Query(
      array(
        'post_type'      => $post_type,
        'post_status'    => 'publish',
        'post__in'       => $ids,
        'orderby'        => 'post__in',
        'posts_per_page' => $limit,
        'no_found_rows'  => true,
      )
    );
  }
}

if (! function_exists('romonet_get_home_services_query')) {
  function romonet_get_home_services_query($limit = 6)
  {
    $limit = max(1, absint($limit));
    $ids   = get_posts(
      array(
        'post_type'      => 'service',
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'fields'         => 'ids',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
          array(
            'key'     => 'service_highlight',
            'value'   => '1',
            'compare' => '=',
          ),
        ),
      )
    );

    if (count($ids) < $limit) {
      $more_ids = get_posts(
        array(
          'post_type'      => 'service',
          'post_status'    => 'publish',
          'posts_per_page' => $limit - count($ids),
          'post__not_in'   => $ids,
          'fields'         => 'ids',
          'orderby'        => 'date',
          'order'          => 'DESC',
        )
      );
      $ids = array_merge($ids, $more_ids);
    }

    if (empty($ids)) {
      return new WP_Query(array('post__in' => array(0)));
    }

    return new WP_Query(
      array(
        'post_type'      => 'service',
        'post_status'    => 'publish',
        'post__in'       => $ids,
        'orderby'        => 'post__in',
        'posts_per_page' => $limit,
        'no_found_rows'  => true,
      )
    );
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

if (! function_exists('romonet_get_home_testimonials')) {
  function romonet_get_home_testimonials($limit = 3)
  {
    return get_posts(
      array(
        'post_type'      => 'portfolio',
        'post_status'    => 'publish',
        'posts_per_page' => max(1, absint($limit)),
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
          array(
            'key'     => 'testimonial',
            'value'   => '',
            'compare' => '!=',
          ),
        ),
      )
    );
  }
}

if (! function_exists('romonet_get_home_client_names')) {
  function romonet_get_home_client_names($limit = 6)
  {
    $limit = max(1, absint($limit));
    $posts = get_posts(
      array(
        'post_type'      => 'portfolio',
        'post_status'    => 'publish',
        'posts_per_page' => 24,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
          array(
            'key'     => 'client_name',
            'value'   => '',
            'compare' => '!=',
          ),
        ),
      )
    );

    $names = array();
    foreach ($posts as $post) {
      $name = trim((string) get_post_meta($post->ID, 'client_name', true));
      if ('' === $name || in_array($name, $names, true)) {
        continue;
      }

      $names[] = $name;
      if (count($names) >= $limit) {
        break;
      }
    }

    return $names;
  }
}

if (! function_exists('romonet_get_persian_initials')) {
  function romonet_get_persian_initials($name)
  {
    $name = trim((string) $name);
    if ('' === $name) {
      return '؟';
    }

    $parts = preg_split('/\s+/u', $name);
    if (count($parts) >= 2) {
      return mb_substr($parts[0], 0, 1, 'UTF-8') . '.' . mb_substr($parts[1], 0, 1, 'UTF-8');
    }

    return mb_substr($name, 0, 2, 'UTF-8');
  }
}

if (! function_exists('romonet_get_portfolio_term_label')) {
  function romonet_get_portfolio_term_label($post_id = 0)
  {
    $post_id = $post_id ? absint($post_id) : get_the_ID();
    $terms   = function_exists('romonet_get_post_project_type_terms')
      ? romonet_get_post_project_type_terms($post_id)
      : get_the_terms($post_id, 'project_type');

    if (is_array($terms) && ! empty($terms) && ! is_wp_error($terms)) {
      return $terms[0]->name;
    }

    return 'نمونه‌کار';
  }
}

if (! function_exists('romonet_get_portfolio_fallback_image')) {
  function romonet_get_portfolio_fallback_image($index = 0)
  {
    $images = array(
      'portfolio-1.png',
      'portfolio-2.png',
      'portfolio-3.png',
    );
    $file   = $images[absint($index) % count($images)];

    return get_template_directory_uri() . '/assets/img/' . $file;
  }
}
