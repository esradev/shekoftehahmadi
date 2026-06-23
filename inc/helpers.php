<?php

/**
 * Shared helper functions.
 */

if (! defined('ABSPATH')) {
  exit;
}

if (! function_exists('romonet_get_theme_option')) {
  function romonet_get_theme_option($key, $default = '')
  {
    $option = get_theme_mod($key, $default);

    return is_string($option) ? $option : $default;
  }
}

if (! function_exists('romonet_get_asset_uri')) {
  function romonet_get_asset_uri($path)
  {
    return get_theme_file_uri('/build/' . ltrim($path, '/'));
  }
}

if (! function_exists('romonet_primary_menu_fallback')) {
  function romonet_primary_menu_fallback()
  {
?>
<ul class="flex flex-col gap-3 md:flex-row md:items-center md:gap-6">
  <li><a class="text-white hover:text-primary-600" href="<?php echo esc_url(home_url('/')); ?>">خانه</a></li>
  <li><a class="text-white hover:text-primary-600" href="<?php echo esc_url(home_url('/service/')); ?>">خدمات</a></li>
  <li><a class="text-white hover:text-primary-600"
      href="<?php echo esc_url(home_url('/portfolio/')); ?>">نمونه‌کارها</a></li>
  <li><a class="text-white hover:text-primary-600" href="<?php echo esc_url(home_url('/pricing/')); ?>">قیمت‌ها</a></li>
  <li><a class="text-white hover:text-primary-600" href="<?php echo esc_url(home_url('/contact/')); ?>">تماس</a></li>
</ul>
<?php
  }
}

if (! function_exists('romonet_top_bar_menu_fallback')) {
  function romonet_top_bar_menu_fallback()
  {
  ?>
<ul class="flex flex-wrap items-center gap-x-5 gap-y-1">
  <li><a class="transition hover:text-white" href="<?php echo esc_url(home_url('/about/')); ?>">درباره ما</a></li>
  <li><a class="transition hover:text-white" href="<?php echo esc_url(home_url('/blog/')); ?>">وبلاگ</a></li>
</ul>
<?php
  }
}

if (! function_exists('romonet_footer_nav_menu_link_attributes')) {
  function romonet_footer_nav_menu_link_attributes($atts, $item, $args, $depth)
  {
    if (in_array($args->theme_location, array('footer', 'legal'), true)) {
      $atts['class'] = isset($atts['class']) ? $atts['class'] . ' text-slate-400 transition hover:text-white' : 'text-slate-400 transition hover:text-white';
    }

    return $atts;
  }
}

if (! function_exists('romonet_top_bar_nav_menu_link_attributes')) {
  function romonet_top_bar_nav_menu_link_attributes($atts, $item, $args, $depth)
  {
    if ($args->theme_location === 'top-bar') {
      $atts['class'] = isset($atts['class']) ? $atts['class'] . ' transition hover:text-white' : 'transition hover:text-white';
    }

    return $atts;
  }
}
