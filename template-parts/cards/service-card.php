<?php

if (! defined('ABSPATH')) {
  exit;
}

$title    = isset($args['title']) ? $args['title'] : '';
$text     = isset($args['text']) ? $args['text'] : '';
$url      = isset($args['url']) ? $args['url'] : '#';
$duration = isset($args['duration']) ? $args['duration'] : '';
$price    = isset($args['price']) ? $args['price'] : '';
$industry = isset($args['industry']) ? $args['industry'] : '';
$highlight = ! empty($args['highlight']);
$terms    = isset($args['terms']) && is_array($args['terms']) ? $args['terms'] : array();

if (empty($duration)) {
  $duration = get_post_meta(get_the_ID(), 'service_duration', true);
}
if (empty($price)) {
  $price = get_post_meta(get_the_ID(), 'service_price_range', true);
}
if (empty($industry)) {
  $industry = get_post_meta(get_the_ID(), 'service_industry', true);
}
if (! $highlight) {
  $highlight = '1' === get_post_meta(get_the_ID(), 'service_highlight', true);
}
if (empty($terms)) {
  $terms = get_the_terms(get_the_ID(), 'service_category');
  if (is_wp_error($terms) || ! is_array($terms)) {
    $terms = array();
  }
}

?>

<a href="<?php echo esc_url($url); ?>" class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-pink-200 hover:shadow-xl hover:shadow-pink-100/40">
  <?php if ($highlight) : ?>
    <span class="absolute start-4 top-4 z-10 rounded-full bg-pink-600 px-3 py-1 text-xs font-bold text-white shadow-sm">پیشنهادی</span>
  <?php endif; ?>

  <div class="aspect-16/10 overflow-hidden bg-linear-to-br from-pink-50 to-cyan-50">
    <?php if (has_post_thumbnail()) : ?>
      <?php echo get_the_post_thumbnail(null, 'medium', array('class' => 'h-full w-full object-cover transition duration-500 group-hover:scale-105', 'alt' => esc_attr($title))); ?>
    <?php else : ?>
      <div class="grid h-full w-full place-items-center text-pink-600">
        <svg class="h-12 w-12 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
          <path d="M4 6h16M4 12h10M4 18h7" />
        </svg>
      </div>
    <?php endif; ?>
  </div>

  <div class="flex flex-1 flex-col p-7">
    <?php if (! empty($terms)) : ?>
      <div class="mb-3 flex flex-wrap gap-2">
        <?php foreach (array_slice($terms, 0, 1) as $term) : ?>
          <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600"><?php echo esc_html($term->name); ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <h3 class="text-lg font-bold text-slate-900 transition group-hover:text-pink-700"><?php echo esc_html($title); ?></h3>
    <p class="mt-3 flex-1 text-sm leading-7 text-slate-600"><?php echo esc_html($text); ?></p>

    <?php if ($duration || $price || $industry) : ?>
      <div class="mt-5 space-y-2 rounded-2xl bg-slate-50 p-4 text-xs text-slate-600">
        <?php if ($duration) : ?><div><span class="font-bold text-slate-800">مدت:</span> <?php echo esc_html($duration); ?></div><?php endif; ?>
        <?php if ($price) : ?><div><span class="font-bold text-slate-800">بازه قیمت:</span> <?php echo esc_html($price); ?></div><?php endif; ?>
        <?php if ($industry) : ?><div><span class="font-bold text-slate-800">مناسب برای:</span> <?php echo esc_html($industry); ?></div><?php endif; ?>
      </div>
    <?php endif; ?>

    <span class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-pink-600">جزئیات بیشتر
      <svg class="h-4 w-4 transition group-hover:-translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <path d="M19 12H5" />
        <path d="m12 19-7-7 7-7" />
      </svg>
    </span>
  </div>
</a>
