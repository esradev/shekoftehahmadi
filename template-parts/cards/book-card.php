<?php

if (! defined('ABSPATH')) {
  exit;
}
$post_id = get_the_ID();

$title = isset($args['title']) ? $args['title'] : get_the_title($post_id);
$text  = isset($args['text']) ? $args['text'] : wp_trim_words(wp_strip_all_tags(get_the_excerpt($post_id) ? get_the_excerpt($post_id) : get_the_content(null, false, $post_id)), 20);
$url   = isset($args['url']) ? $args['url'] : get_permalink($post_id);

$book_subtitle      = get_post_meta($post_id, 'book_subtitle', true);
$book_publish_year  = get_post_meta($post_id, 'book_publish_year', true);
$book_pages         = get_post_meta($post_id, 'book_pages', true);
$book_file_format   = get_post_meta($post_id, 'book_file_format', true);
$book_reading_level = get_post_meta($post_id, 'book_reading_level', true);
$book_language      = get_post_meta($post_id, 'book_language', true);
$book_download_url  = get_post_meta($post_id, 'book_download_url', true);
$book_preview_url   = get_post_meta($post_id, 'book_preview_url', true);
$book_featured      = '1' === get_post_meta($post_id, 'book_featured', true);

$book_authors = function_exists('romonet_get_post_book_author_terms') ? romonet_get_post_book_author_terms($post_id) : array();
$book_topics  = function_exists('romonet_get_post_book_topic_terms') ? romonet_get_post_book_topic_terms($post_id) : array();

$author_links = array();
foreach ($book_authors as $author) {
  $author_url = get_term_link($author);
  if (! is_wp_error($author_url)) {
    $author_links[] = array(
      'name' => $author->name,
      'url'  => $author_url,
    );
  }
}

?>

<article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-pink-200 hover:shadow-xl hover:shadow-pink-100/40">
  <div class="relative aspect-16/10 overflow-hidden bg-linear-to-br from-slate-900 via-pink-900 to-cyan-800">
    <?php if ($book_featured) : ?>
      <span class="absolute end-4 top-4 z-10 rounded-full bg-cyan-500 px-3 py-1 text-xs font-bold text-white shadow-sm">منتخب</span>
    <?php endif; ?>

    <?php if (has_post_thumbnail()) : ?>
      <?php echo get_the_post_thumbnail(null, 'medium', array('class' => 'h-full w-full object-cover transition duration-500 group-hover:scale-105', 'alt' => esc_attr($title))); ?>
    <?php else : ?>
      <div class="flex h-full flex-col justify-between p-6 text-white">
        <span class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-200">کتاب</span>
        <span class="text-2xl font-black"><?php echo esc_html($book_file_format ? $book_file_format : 'PDF'); ?></span>
      </div>
    <?php endif; ?>
  </div>

  <div class="space-y-4 p-6">
    <div class="flex flex-wrap gap-2">
      <?php if (! empty($book_topics)) : ?>
        <?php foreach (array_slice($book_topics, 0, 2) as $topic) : ?>
          <?php
          $topic_url = get_term_link($topic);
          if (is_wp_error($topic_url)) {
            continue;
          }
          ?>
          <a href="<?php echo esc_url($topic_url); ?>" class="inline-flex rounded-full bg-pink-50 px-3 py-1 text-xs font-semibold text-pink-700 transition hover:bg-pink-100">
            <?php echo esc_html($topic->name); ?>
          </a>
        <?php endforeach; ?>
      <?php else : ?>
        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">کتابخانه</span>
      <?php endif; ?>
    </div>

    <div>
      <h3 class="text-lg font-bold leading-8 text-slate-900 transition group-hover:text-pink-700">
        <a href="<?php echo esc_url($url); ?>" class="focus:outline-none"><?php echo esc_html($title); ?></a>
      </h3>
      <?php if ($book_subtitle) : ?>
        <p class="mt-2 text-sm leading-7 text-slate-600"><?php echo esc_html($book_subtitle); ?></p>
      <?php endif; ?>
      <p class="mt-2 text-sm leading-7 text-slate-600"><?php echo esc_html($text); ?></p>
    </div>

    <?php if (! empty($author_links)) : ?>
      <p class="text-sm font-semibold text-slate-700">
        نویسنده:
        <span class="font-medium text-slate-600">
          <?php foreach ($author_links as $index => $author_link) : ?>
            <?php if ($index > 0) : ?>
              <span>، </span>
            <?php endif; ?>
            <a href="<?php echo esc_url($author_link['url']); ?>" class="transition hover:text-pink-700"><?php echo esc_html($author_link['name']); ?></a>
          <?php endforeach; ?>
        </span>
      </p>
    <?php endif; ?>

    <div class="flex flex-wrap items-center gap-2">
      <?php if ($book_publish_year) : ?>
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600"><?php echo esc_html($book_publish_year); ?></span>
      <?php endif; ?>
      <?php if ($book_pages) : ?>
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600"><?php echo esc_html($book_pages); ?> صفحه</span>
      <?php endif; ?>
      <?php if ($book_file_format) : ?>
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600"><?php echo esc_html($book_file_format); ?></span>
      <?php endif; ?>
      <?php if ($book_language) : ?>
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600"><?php echo esc_html($book_language); ?></span>
      <?php endif; ?>
      <?php if ($book_reading_level) : ?>
        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700"><?php echo esc_html($book_reading_level); ?></span>
      <?php endif; ?>
    </div>

    <div class="flex flex-wrap items-center gap-2 pt-1">
      <a href="<?php echo esc_url($url); ?>" class="inline-flex items-center justify-center rounded-xl bg-pink-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-pink-500">
        مشاهده جزئیات کتاب
      </a>
      <?php if ($book_preview_url) : ?>
        <a href="<?php echo esc_url($book_preview_url); ?>" target="_blank" rel="noreferrer noopener" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-pink-200 hover:bg-pink-50 hover:text-pink-700">
          پیش‌نمایش
        </a>
      <?php endif; ?>
      <?php if ($book_download_url) : ?>
        <a href="<?php echo esc_url($book_download_url); ?>" target="_blank" rel="noreferrer noopener" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-pink-200 hover:bg-pink-50 hover:text-pink-700">
          دانلود
        </a>
      <?php endif; ?>
    </div>
  </div>
</article>
