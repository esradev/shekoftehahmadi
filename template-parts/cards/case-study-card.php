<?php

if (! defined('ABSPATH')) {
  exit;
}

$title      = isset($args['title']) ? $args['title'] : '';
$text       = isset($args['text']) ? $args['text'] : '';
$url        = isset($args['url']) ? $args['url'] : '#';
$client     = isset($args['client']) ? $args['client'] : '';
$technology = isset($args['technology']) ? $args['technology'] : '';
$duration   = isset($args['duration']) ? $args['duration'] : '';
$key_metric = isset($args['key_metric']) ? $args['key_metric'] : '';
$featured   = ! empty($args['featured']);

if (empty($client)) {
  $client = get_post_meta(get_the_ID(), 'case_study_client', true);
}
if (empty($technology)) {
  $technology = get_post_meta(get_the_ID(), 'case_study_technology', true);
}
if (empty($duration)) {
  $duration = get_post_meta(get_the_ID(), 'case_study_duration', true);
}
if (empty($key_metric)) {
  $key_metric = get_post_meta(get_the_ID(), 'case_study_key_metric', true);
}
if (! $featured) {
  $featured = '1' === get_post_meta(get_the_ID(), 'featured', true);
}

?>

<a href="<?php echo esc_url($url); ?>" class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-100/40">
  <?php if ($featured) : ?>
    <span class="absolute start-4 top-4 z-10 rounded-full bg-cyan-600 px-3 py-1 text-xs font-bold text-white shadow-sm">ویژه</span>
  <?php endif; ?>

  <div class="aspect-16/10 overflow-hidden bg-linear-to-br from-slate-900 to-slate-700">
    <?php if (has_post_thumbnail()) : ?>
      <?php echo get_the_post_thumbnail(null, 'medium', array('class' => 'h-full w-full object-cover opacity-90 transition duration-500 group-hover:scale-105 group-hover:opacity-100', 'alt' => esc_attr($title))); ?>
    <?php else : ?>
      <div class="flex h-full flex-col justify-between p-6 text-white">
        <span class="text-xs font-semibold uppercase tracking-[0.3em] text-cyan-300">مطالعه موردی</span>
        <?php if ($key_metric) : ?>
          <span class="text-2xl font-extrabold"><?php echo esc_html($key_metric); ?></span>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="p-7">
    <span class="text-xs font-semibold uppercase tracking-[0.3em] text-cyan-600">مطالعه موردی</span>
    <h3 class="mt-2 text-lg font-bold text-slate-900 transition group-hover:text-blue-700"><?php echo esc_html($title); ?></h3>

    <?php if ($client) : ?>
      <div class="mt-2 text-xs font-medium text-slate-500">مشتری: <?php echo esc_html($client); ?></div>
    <?php endif; ?>

    <p class="mt-2 text-sm leading-7 text-slate-600"><?php echo esc_html($text); ?></p>

    <div class="mt-4 flex flex-wrap items-center gap-2">
      <?php if ($key_metric) : ?>
        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700"><?php echo esc_html($key_metric); ?></span>
      <?php endif; ?>
      <?php if ($technology) : ?>
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-600"><?php echo esc_html($technology); ?></span>
      <?php endif; ?>
      <?php if ($duration) : ?>
        <span class="text-xs text-slate-500"><?php echo esc_html($duration); ?></span>
      <?php endif; ?>
    </div>

    <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600">مشاهده مطالعه
      <svg class="h-4 w-4 transition group-hover:-translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <path d="M19 12H5" />
        <path d="m12 19-7-7 7-7" />
      </svg>
    </span>
  </div>
</a>
