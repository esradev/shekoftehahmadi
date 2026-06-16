<?php

if (! defined('ABSPATH')) {
  exit;
}

$style = isset($args['style']) ? sanitize_key($args['style']) : 'default';
$title = isset($args['title']) ? $args['title'] : 'آماده‌اید پروژه بعدی را شروع کنیم؟';
$text  = isset($args['text']) ? $args['text'] : 'برای دریافت پیشنهاد فنی و برآورد دقیق، همین امروز با ما صحبت کنید.';
$primary = isset($args['primary']) ? $args['primary'] : 'ثبت درخواست پروژه';
$primary_url = isset($args['primary_url']) ? $args['primary_url'] : home_url('/project-request/');
$secondary = isset($args['secondary']) ? $args['secondary'] : 'مشاوره رایگان';
$secondary_url = isset($args['secondary_url']) ? $args['secondary_url'] : home_url('/contact/');

$section_classes = 'relative overflow-hidden rounded-3xl px-6 py-14 text-center shadow-xl shadow-blue-200/50 sm:px-12 lg:py-16';
$primary_button_classes = 'rounded-xl bg-white px-6 py-3.5 text-base font-semibold text-blue-700 shadow-sm transition hover:bg-blue-50';
$secondary_button_classes = 'rounded-xl border border-white/30 px-6 py-3.5 text-base font-semibold text-white transition hover:bg-white/10';
$text_classes = 'mt-4 text-pretty text-lg leading-8 text-blue-100';

if ($style === 'inverse') {
  $section_classes .= ' bg-slate-900';
  $primary_button_classes = 'rounded-xl bg-blue-600 px-6 py-3.5 text-base font-semibold text-white shadow-sm transition hover:bg-blue-500';
  $secondary_button_classes = 'rounded-xl border border-slate-300 bg-transparent px-6 py-3.5 text-base font-semibold text-slate-200 transition hover:border-slate-200 hover:bg-slate-800';
  $text_classes = 'mt-4 text-pretty text-lg leading-8 text-slate-300';
} else {
  $section_classes .= ' bg-blue-700';
}

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
