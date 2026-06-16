<?php

if (! defined('ABSPATH')) {
  exit;
}

$post_id     = isset($args['post_id']) ? absint($args['post_id']) : get_the_ID();
$title       = isset($args['title']) ? $args['title'] : get_the_title($post_id);
$excerpt     = isset($args['excerpt']) ? $args['excerpt'] : wp_trim_words(get_the_excerpt($post_id) ? get_the_excerpt($post_id) : wp_strip_all_tags(get_post_field('post_content', $post_id)), 34);
$link        = isset($args['url']) ? $args['url'] : get_permalink($post_id);
$published   = get_the_date('', $post_id);
$category    = get_the_category($post_id);
$category    = isset($category[0]) ? $category[0] : null;
$category_url = $category ? get_category_link($category->term_id) : '';
$category_name = $category ? $category->name : '';
$meta        = romonet_get_post_meta_bundle($post_id);
$featured    = ! empty($args['featured']);
?>

<article <?php post_class('group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl' . ($featured ? ' lg:grid lg:grid-cols-[1.1fr_.9fr] lg:items-stretch' : ''), $post_id); ?>>
  <a href="<?php echo esc_url($link); ?>" class="block overflow-hidden bg-slate-100 <?php echo $featured ? 'lg:min-h-full' : ''; ?>">
    <?php if (has_post_thumbnail($post_id)) : ?>
      <?php echo get_the_post_thumbnail($post_id, 'large', array('class' => ($featured ? 'h-72 lg:h-full' : 'h-72') . ' w-full object-cover transition duration-500 group-hover:scale-105', 'alt' => esc_attr($title))); ?>
    <?php else : ?>
      <div class="flex <?php echo $featured ? 'h-72 lg:h-full' : 'h-72'; ?> w-full items-center justify-center text-slate-400">
        <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
          <rect x="3" y="3" width="18" height="18" rx="2" />
          <path d="M3 9h18" />
          <path d="M9 21V9" />
        </svg>
      </div>
    <?php endif; ?>
  </a>

  <div class="p-7 <?php echo $featured ? 'flex flex-col justify-center' : ''; ?>">
    <div class="flex flex-wrap items-center gap-2">
      <?php if ($meta['article_type_label']) : ?>
        <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700"><?php echo esc_html($meta['article_type_label']); ?></span>
      <?php endif; ?>
      <?php if ($meta['difficulty_label']) : ?>
        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600"><?php echo esc_html($meta['difficulty_label']); ?></span>
      <?php endif; ?>
      <span class="text-xs font-semibold uppercase tracking-[0.2em] text-cyan-600"><?php echo esc_html(sprintf(__('%d min read', 'romonet'), $meta['reading_time'])); ?></span>
    </div>

    <div class="mt-4 flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">
      <span><?php echo esc_html($published); ?></span>
      <?php if ($category_name && $category_url) : ?>
        <a href="<?php echo esc_url($category_url); ?>" class="text-cyan-600 hover:text-cyan-700"><?php echo esc_html($category_name); ?></a>
      <?php endif; ?>
    </div>

    <h2 class="mt-4 text-2xl font-bold text-slate-900 <?php echo $featured ? 'lg:text-3xl' : ''; ?>">
      <a href="<?php echo esc_url($link); ?>" class="transition hover:text-blue-700"><?php echo esc_html($title); ?></a>
    </h2>

    <?php if ($meta['audience']) : ?>
      <p class="mt-3 text-xs font-semibold text-slate-500"><?php echo esc_html(sprintf(__('For: %s', 'romonet'), $meta['audience'])); ?></p>
    <?php endif; ?>

    <p class="mt-4 text-sm leading-7 text-slate-600"><?php echo esc_html($excerpt); ?></p>

    <?php if (! empty($meta['technologies'])) : ?>
      <div class="mt-5 flex flex-wrap gap-2">
        <?php foreach (array_slice($meta['technologies'], 0, 3) as $technology) : ?>
          <span class="rounded-full border border-slate-200 px-2.5 py-1 text-xs text-slate-500"><?php echo esc_html($technology); ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <a href="<?php echo esc_url($link); ?>" class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600">
      <?php esc_html_e('Read article', 'romonet'); ?>
      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <path d="M19 12H5" />
        <path d="m12 19-7-7 7-7" />
      </svg>
    </a>
  </div>
</article>
