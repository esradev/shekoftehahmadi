<?php

if (! defined('ABSPATH')) {
  exit;
}

$title         = isset($args['title']) ? $args['title'] : '';
$price         = isset($args['price']) ? $args['price'] : '';
$text          = isset($args['text']) ? $args['text'] : '';
$url           = isset($args['url']) ? $args['url'] : '#';
$image         = isset($args['image']) ? $args['image'] : '';
$alt           = isset($args['alt']) ? $args['alt'] : $title;
$type_label    = isset($args['type_label']) ? $args['type_label'] : '';
$version       = isset($args['version']) ? $args['version'] : '';
$file_size     = isset($args['file_size']) ? $args['file_size'] : '';
$updated       = isset($args['updated']) ? $args['updated'] : '';
$category      = isset($args['category']) ? $args['category'] : '';
$rating_html   = isset($args['rating_html']) ? $args['rating_html'] : '';
$review_count  = isset($args['review_count']) ? (int) $args['review_count'] : 0;
$has_demo      = ! empty($args['has_demo']);
$license_label = isset($args['license_label']) ? $args['license_label'] : '';
$developer     = isset($args['developer']) ? $args['developer'] : '';
$compact       = ! empty($args['compact']);

if (! $image && function_exists('wc_placeholder_img_src')) {
  $image = wc_placeholder_img_src();
}

?>

<a href="<?php echo esc_url($url); ?>" class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-pink-200 hover:shadow-xl hover:shadow-pink-100/50">
  <div class="relative">
    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($alt); ?>" class="aspect-4/3 w-full rounded-t-2xl bg-linear-to-br from-slate-100 to-pink-50 object-cover transition duration-500 group-hover:scale-[1.02]" loading="lazy" />

    <?php if ($type_label) : ?>
      <span class="absolute top-4 right-4 inline-flex items-center rounded-full bg-pink-600 px-3 py-1 text-xs font-semibold text-white shadow-sm"><?php echo esc_html($type_label); ?></span>
    <?php endif; ?>

    <?php if ($has_demo) : ?>
      <span class="absolute top-4 left-4 inline-flex items-center rounded-full border border-white/70 bg-white/90 px-3 py-1 text-xs font-semibold text-pink-700 backdrop-blur-sm">دمو زنده</span>
    <?php endif; ?>

    <?php if ($license_label) : ?>
      <span class="absolute bottom-4 right-4 inline-flex items-center rounded-full bg-slate-900/80 px-3 py-1 text-xs font-medium text-white backdrop-blur-sm">لایسنس <?php echo esc_html($license_label); ?></span>
    <?php endif; ?>

    <div class="absolute inset-0 flex items-end p-4 opacity-0 transition-opacity duration-200 group-hover:opacity-100" aria-hidden="true">
      <div class="w-full rounded-xl bg-white/90 px-4 py-2.5 text-center text-sm font-semibold text-slate-900 backdrop-blur-sm">مشاهده جزئیات محصول</div>
    </div>
  </div>

  <div class="flex flex-1 flex-col <?php echo $compact ? 'p-5' : 'p-6 sm:p-7'; ?>">
    <?php if ($category) : ?>
      <p class="text-xs font-semibold tracking-wide text-pink-600"><?php echo esc_html($category); ?></p>
    <?php endif; ?>

    <div class="mt-2 <?php echo $compact ? 'space-y-1.5' : 'flex items-start justify-between gap-4'; ?>">
      <h3 class="<?php echo $compact ? 'text-base font-bold leading-6' : 'text-lg font-bold leading-7'; ?> text-slate-900 transition group-hover:text-pink-700"><?php echo esc_html($title); ?></h3>
      <p class="<?php echo $compact ? 'text-sm' : 'shrink-0 text-base'; ?> font-bold text-slate-900"><?php echo wp_kses_post($price); ?></p>
    </div>

    <?php if (! $compact && $developer) : ?>
      <p class="mt-1 text-xs text-slate-500"><?php echo esc_html($developer); ?></p>
    <?php endif; ?>

    <?php if (! $compact && $text) : ?>
      <p class="mt-3 flex-1 text-sm leading-7 text-slate-600"><?php echo esc_html($text); ?></p>
    <?php endif; ?>

    <?php if (! $compact && ($version || $file_size || $updated || $rating_html)) : ?>
      <div class="mt-5 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-4">
        <?php if ($version) : ?>
          <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600">نسخه <?php echo esc_html($version); ?></span>
        <?php endif; ?>

        <?php if ($file_size) : ?>
          <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600"><?php echo esc_html($file_size); ?></span>
        <?php endif; ?>

        <?php if ($updated) : ?>
          <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600"><?php echo esc_html($updated); ?></span>
        <?php endif; ?>

        <?php if ($rating_html) : ?>
          <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600">
            <?php echo wp_kses_post($rating_html); ?>
            <span><?php echo esc_html(sprintf('%d نظر', $review_count)); ?></span>
          </span>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <span class="<?php echo $compact ? 'mt-4' : 'mt-5'; ?> inline-flex items-center gap-1.5 text-sm font-semibold text-pink-600">جزئیات بیشتر
      <svg class="h-4 w-4 transition group-hover:-translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <path d="M19 12H5" />
        <path d="m12 19-7-7 7-7" />
      </svg>
    </span>
  </div>
</a>
