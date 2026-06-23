<?php

if (! defined('ABSPATH')) {
  exit;
}

$title      = isset($args['title']) ? $args['title'] : '';
$text       = isset($args['text']) ? $args['text'] : '';
$url        = isset($args['url']) ? $args['url'] : '#';
$client     = isset($args['client']) ? $args['client'] : '';
$key_result = isset($args['key_result']) ? $args['key_result'] : '';
$featured   = ! empty($args['featured']);
$terms      = isset($args['terms']) && is_array($args['terms']) ? $args['terms'] : array();

if (empty($client) && function_exists('get_post_meta')) {
  $client = get_post_meta(get_the_ID(), 'client_name', true);
}
if (empty($key_result)) {
  $key_result = get_post_meta(get_the_ID(), 'key_result', true);
}
if (! $featured) {
  $featured = '1' === get_post_meta(get_the_ID(), 'featured', true);
}
if (empty($terms) && function_exists('romonet_get_post_project_type_terms')) {
  $terms = romonet_get_post_project_type_terms();
}

?>

<a href="<?php echo esc_url($url); ?>" class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-pink-200 hover:shadow-xl hover:shadow-pink-100/40">
  <?php if ($featured) : ?>
    <span class="absolute start-4 top-4 z-10 rounded-full bg-cyan-600 px-3 py-1 text-xs font-bold text-white shadow-sm">ویژه</span>
  <?php endif; ?>

  <div class="aspect-16/10 overflow-hidden bg-linear-to-br from-slate-100 to-slate-200">
    <?php if (has_post_thumbnail()) : ?>
      <?php echo get_the_post_thumbnail(null, 'large', array('class' => 'h-full w-full object-cover transition duration-500 group-hover:scale-105', 'alt' => esc_attr($title ?: get_the_title()))); ?>
    <?php else : ?>
      <div class="flex h-full items-end p-6">
        <span class="text-sm font-semibold text-slate-500">نمونه‌کار</span>
      </div>
    <?php endif; ?>
  </div>

  <div class="p-7">
    <?php if (! empty($terms)) : ?>
      <div class="mb-3 flex flex-wrap gap-2">
        <?php foreach (array_slice($terms, 0, 2) as $term) : ?>
          <span class="rounded-full bg-pink-50 px-2.5 py-1 text-xs font-semibold text-pink-700"><?php echo esc_html($term->name); ?></span>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <span class="text-xs font-semibold uppercase tracking-[0.3em] text-cyan-600">نمونه‌کار</span>
    <?php endif; ?>

    <h3 class="mt-2.5 text-lg font-bold text-slate-900 transition group-hover:text-pink-700"><?php echo esc_html($title); ?></h3>

    <?php if ($client) : ?>
      <p class="mt-1 text-xs font-medium text-slate-500">مشتری: <?php echo esc_html($client); ?></p>
    <?php endif; ?>

    <p class="mt-2 text-sm leading-7 text-slate-600"><?php echo esc_html($text); ?></p>

    <?php if ($key_result) : ?>
      <p class="mt-4 inline-flex rounded-xl bg-emerald-50 px-3 py-2 text-xs font-bold text-emerald-700"><?php echo esc_html($key_result); ?></p>
    <?php endif; ?>

    <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-pink-600">مشاهده پروژه
      <svg class="h-4 w-4 transition group-hover:-translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <path d="M19 12H5" />
        <path d="m12 19-7-7 7-7" />
      </svg>
    </span>
  </div>
</a>
