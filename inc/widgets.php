<?php

/**
 * Widget areas.
 */

if (! defined('ABSPATH')) {
  exit;
}

if (! function_exists('romonet_widgets_init')) {
  function romonet_widgets_init()
  {
    register_sidebar(
      array(
        'name'          => esc_html__('Sidebar', 'romonet'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Widgets in this area appear in the main sidebar.', 'romonet'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
      )
    );

    register_sidebar(
      array(
        'name'        => esc_html__('Footer Widgets', 'romonet'),
        'id'          => 'footer-1',
        'description' => esc_html__('Footer widget area for utility content.', 'romonet'),
      )
    );
  }
}
add_action('widgets_init', 'romonet_widgets_init');
