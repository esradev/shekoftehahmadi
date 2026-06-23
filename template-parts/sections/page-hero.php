<?php

if (! defined('ABSPATH')) {
  exit;
}

$api_args = isset($args) && is_array($args) ? $args : array();

if (function_exists('romonet_merge_page_hero_args')) {
  $api_args = romonet_merge_page_hero_args($api_args);
}

$badge            = isset($api_args['badge']) ? (string) $api_args['badge'] : '';
$title            = isset($api_args['title']) ? (string) $api_args['title'] : get_the_title();
$description      = isset($api_args['description']) ? (string) $api_args['description'] : '';
$current          = isset($api_args['current']) ? (string) $api_args['current'] : $title;
$show_breadcrumbs = isset($api_args['show_breadcrumbs']) ? (bool) $api_args['show_breadcrumbs'] : true;

$primary     = isset($api_args['primary']) ? (string) $api_args['primary'] : '';
$primary_url = isset($api_args['primary_url']) ? (string) $api_args['primary_url'] : '';

$secondary     = isset($api_args['secondary']) ? (string) $api_args['secondary'] : '';
$secondary_url = isset($api_args['secondary_url']) ? (string) $api_args['secondary_url'] : '';

?>

<section class="relative overflow-hidden border-b border-slate-200 bg-slate-50">
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgb(37_99_235/0.12)_1px,transparent_0)] bg-size-[22px_22px]" aria-hidden="true"></div>
  <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
    <?php
    if ($show_breadcrumbs) {
      get_template_part('template-parts/ui/breadcrumbs', null, array('current' => $current, 'class' => 'mb-8'));
    }
    ?>

    <header class="max-w-3xl">
      <?php if ($badge) : ?>
        <p class="text-sm font-bold uppercase tracking-wider text-pink-600"><?php echo esc_html($badge); ?></p>
      <?php endif; ?>

      <h1 class="mt-3 text-balance text-4xl font-extrabold leading-tight tracking-tight text-slate-900 sm:text-5xl">
        <?php echo esc_html($title); ?>
      </h1>

      <?php if ($description) : ?>
        <p class="mt-4 text-pretty text-lg leading-8 text-slate-600">
          <?php echo esc_html($description); ?>
        </p>
      <?php endif; ?>

      <?php if ($primary && $primary_url) : ?>
        <div class="mt-8 flex flex-wrap items-center gap-3">
          <a href="<?php echo esc_url($primary_url); ?>" class="inline-flex items-center gap-2 rounded-xl bg-pink-600 px-6 py-3.5 text-base font-semibold text-white shadow-sm transition hover:bg-pink-700"><?php echo esc_html($primary); ?></a>

          <?php if ($secondary && $secondary_url) : ?>
            <a href="<?php echo esc_url($secondary_url); ?>" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-6 py-3.5 text-base font-semibold text-slate-900 transition hover:bg-slate-50"><?php echo esc_html($secondary); ?></a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </header>
  </div>
</section>
