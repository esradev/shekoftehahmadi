<?php

/**
 * CTA block pattern and shortcode.
 */

if (! defined('ABSPATH')) {
  exit;
}

if (! function_exists('romonet_register_block_styles')) {
  function romonet_register_block_styles()
  {
    if (function_exists('register_block_style')) {
      register_block_style(
        'core/group',
        array(
          'name' => 'romonet-cta-default',
          'label' => __('CTA default', 'romonet'),
        )
      );
      register_block_style(
        'core/group',
        array(
          'name' => 'romonet-cta-inverse',
          'label' => __('CTA inverse', 'romonet'),
        )
      );
    }
  }
}
add_action('init', 'romonet_register_block_styles');

if (! function_exists('romonet_register_block_patterns')) {
  function romonet_register_block_patterns()
  {
    if (function_exists('register_block_pattern_category')) {
      register_block_pattern_category(
        'romonet',
        array('label' => __('Romonet', 'romonet'))
      );
    }

    if (function_exists('register_block_pattern')) {
      register_block_pattern(
        'romonet/cta',
        array(
          'title' => __('CTA Section', 'romonet'),
          'categories' => array('romonet'),
          'content' => '<!-- wp:group {"className":"romonet-cta-section is-style-romonet-cta-default relative overflow-hidden rounded-3xl px-6 py-14 text-center shadow-xl shadow-pink-200/50 sm:px-12 lg:py-16"} --><div class="wp-block-group romonet-cta-section is-style-romonet-cta-default relative overflow-hidden rounded-3xl px-6 py-14 text-center shadow-xl shadow-pink-200/50 sm:px-12 lg:py-16"><!-- wp:heading {"level":2,"textColor":"white","fontSize":"xlarge"} --><h2 class="has-white-color has-text-color has-xlarge-font-size">' . esc_html__('Ready to start your next project?', 'romonet') . '</h2><!-- /wp:heading --><!-- wp:paragraph {"textColor":"cyan-bluish-gray"} --><p class="has-cyan-bluish-gray-color has-text-color">' . esc_html__('Talk to us today to get a tailored proposal and accurate estimate.', 'romonet') . '</p><!-- /wp:paragraph --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} --><div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"white","textColor":"text-pink-700","className":"is-style-fill"} --><div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-pink-700-color has-text-color has-white-background-color has-background">' . esc_html__('Request a project', 'romonet') . '</a></div><!-- /wp:button --><!-- wp:button {"className":"is-style-outline","textColor":"white","borderRadius":9999} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-white-color has-text-color">' . esc_html__('Free consultation', 'romonet') . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->',
        )
      );
    }
  }
}
add_action('init', 'romonet_register_block_patterns');

if (! function_exists('romonet_cta_shortcode')) {
  function romonet_cta_shortcode($atts)
  {
    $atts = shortcode_atts(
      array(
        'title' => __('Ready to start your next project?', 'romonet'),
        'text' => __('Talk to us today to get a tailored proposal and accurate estimate.', 'romonet'),
        'primary' => __('Request a project', 'romonet'),
        'primary_url' => home_url('/project-request/'),
        'secondary' => __('Free consultation', 'romonet'),
        'secondary_url' => home_url('/contact/'),
        'style' => 'default',
      ),
      $atts,
      'romonet_cta'
    );

    $title = sanitize_text_field($atts['title']);
    $text = sanitize_text_field($atts['text']);
    $primary = sanitize_text_field($atts['primary']);
    $primary_url = esc_url($atts['primary_url']);
    $secondary = sanitize_text_field($atts['secondary']);
    $secondary_url = esc_url($atts['secondary_url']);
    $style = sanitize_key($atts['style']);

    if (! in_array($style, array('default', 'inverse'), true)) {
      $style = 'default';
    }

    $section_classes = 'relative overflow-hidden rounded-3xl px-6 py-14 text-center shadow-xl shadow-pink-200/50 sm:px-12 lg:py-16';
    $primary_button_classes = 'rounded-xl bg-white px-6 py-3.5 text-base font-semibold text-pink-700 shadow-sm transition hover:bg-pink-50';
    $secondary_button_classes = 'rounded-xl border border-white/30 px-6 py-3.5 text-base font-semibold text-white transition hover:bg-white/10';
    $text_classes = 'mt-4 text-pretty text-lg leading-8 text-pink-100';

    if ($style === 'inverse') {
      $section_classes .= ' bg-slate-900';
      $primary_button_classes = 'rounded-xl bg-pink-600 px-6 py-3.5 text-base font-semibold text-white shadow-sm transition hover:bg-pink-500';
      $secondary_button_classes = 'rounded-xl border border-slate-300 bg-transparent px-6 py-3.5 text-base font-semibold text-slate-200 transition hover:border-slate-200 hover:bg-slate-800';
      $text_classes = 'mt-4 text-pretty text-lg leading-8 text-slate-300';
    } else {
      $section_classes .= ' bg-pink-700';
    }

    ob_start();
?>
    <section class="<?php echo esc_attr($section_classes); ?>">
      <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgb(255_255_255/0.25)_1px,transparent_0)] bg-size-[20px_20px] opacity-20" aria-hidden="true"></div>
      <div class="relative mx-auto max-w-2xl">
        <h2 class="text-balance text-3xl font-extrabold tracking-tight text-white sm:text-4xl"><?php echo esc_html($title); ?></h2>
        <p class="<?php echo esc_attr($text_classes); ?>"><?php echo esc_html($text); ?></p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
          <a href="<?php echo esc_url($primary_url); ?>" class="<?php echo esc_attr($primary_button_classes); ?>"><?php echo esc_html($primary); ?></a>
          <a href="<?php echo esc_url($secondary_url); ?>" class="<?php echo esc_attr($secondary_button_classes); ?>"><?php echo esc_html($secondary); ?></a>
        </div>
      </div>
    </section>
<?php

    return ob_get_clean();
  }
}
add_shortcode('romonet_cta', 'romonet_cta_shortcode');
