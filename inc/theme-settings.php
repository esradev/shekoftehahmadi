<?php

/**
 * Theme settings and customizer entry point.
 */

if (! defined('ABSPATH')) {
  exit;
}

if (! function_exists('romonet_customize_register')) {
  function romonet_customize_register($wp_customize)
  {
    $wp_customize->add_section(
      'romonet_branding',
      array(
        'title'    => esc_html__('Romonet Branding', 'romonet'),
        'priority' => 30,
      )
    );

    $wp_customize->add_control(
      'romonet_primary_cta',
      array(
        'label'   => esc_html__('متن دکمه اصلی', 'romonet'),
        'section' => 'romonet_branding',
        'type'    => 'text',
      )
    );

    $wp_customize->add_setting(
      'romonet_primary_cta',
      array(
        'default'           => esc_html__('درخواست مشاوره', 'romonet'),
        'sanitize_callback' => 'sanitize_text_field',
      )
    );
  }
}
add_action('customize_register', 'romonet_customize_register');
