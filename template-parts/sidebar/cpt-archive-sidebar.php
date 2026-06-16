<?php

if (! defined('ABSPATH')) {
  exit;
}

$post_type     = isset($args['post_type']) ? sanitize_key($args['post_type']) : '';
$config        = function_exists('romonet_get_cpt_archive_config') ? romonet_get_cpt_archive_config($post_type) : array();
$archive_url   = isset($config['archive_url']) ? $config['archive_url'] : '';
$taxonomy      = isset($config['taxonomy']) ? $config['taxonomy'] : '';
$secondary_taxonomy = isset($config['tech_taxonomy']) ? $config['tech_taxonomy'] : '';
$taxonomy_label = isset($config['taxonomy_label']) ? $config['taxonomy_label'] : 'دسته‌بندی';
$secondary_label = isset($config['tech_label']) ? $config['tech_label'] : 'فناوری‌ها';
$recent_count  = isset($args['recent_count']) ? absint($args['recent_count']) : 5;
$search_value  = function_exists('romonet_get_cpt_search_query') ? romonet_get_cpt_search_query() : '';

?>

<aside class="space-y-6 lg:sticky lg:top-28 lg:self-start">
  <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
    <h2 class="text-lg font-bold text-slate-900">جستجوی سریع</h2>
    <form method="get" action="<?php echo esc_url($archive_url); ?>" class="mt-4">
      <label for="cpt-sidebar-search" class="sr-only">جستجو</label>
      <div class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 p-3">
        <input id="cpt-sidebar-search" type="search" name="q" value="<?php echo esc_attr($search_value); ?>" placeholder="کلمه کلیدی..." class="w-full bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400" />
        <button type="submit" class="rounded-xl bg-blue-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-blue-500">برو</button>
      </div>
    </form>
  </div>

  <?php if ($taxonomy) :
    $terms = get_terms(array('taxonomy' => $taxonomy, 'hide_empty' => true));
    if (! is_wp_error($terms) && ! empty($terms)) :
  ?>
      <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900"><?php echo esc_html($taxonomy_label); ?></h2>
        <ul class="mt-4 space-y-3 text-sm text-slate-600">
          <?php foreach ($terms as $term) : ?>
            <li class="flex items-center justify-between gap-3">
              <a href="<?php echo esc_url(romonet_get_cpt_filter_url($archive_url, array($taxonomy => $term->slug))); ?>" class="transition hover:text-blue-700">
                <?php echo esc_html($term->name); ?>
              </a>
              <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500"><?php echo esc_html($term->count); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif;
  endif; ?>

  <?php
  $secondary_terms = $secondary_taxonomy
    ? get_terms(array('taxonomy' => $secondary_taxonomy, 'hide_empty' => true, 'number' => 12))
    : array();
  if (! is_wp_error($secondary_terms) && ! empty($secondary_terms)) :
  ?>
    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
      <h2 class="text-lg font-bold text-slate-900"><?php echo esc_html($secondary_label); ?></h2>
      <div class="mt-4 flex flex-wrap gap-2">
        <?php foreach ($secondary_terms as $term) : ?>
          <a href="<?php echo esc_url(romonet_get_cpt_filter_url($archive_url, array($secondary_taxonomy => $term->slug))); ?>" class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
            <?php echo esc_html($term->name); ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <?php
  $recent = new WP_Query(
    array(
      'post_type'           => $post_type,
      'post_status'         => 'publish',
      'posts_per_page'      => $recent_count,
      'ignore_sticky_posts' => true,
      'no_found_rows'       => true,
    )
  );

  if ($recent->have_posts()) :
  ?>
    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
      <h2 class="text-lg font-bold text-slate-900">آخرین موارد</h2>
      <ul class="mt-4 space-y-4">
        <?php while ($recent->have_posts()) : $recent->the_post(); ?>
          <li>
            <a href="<?php the_permalink(); ?>" class="group block">
              <p class="text-sm font-semibold text-slate-900 transition group-hover:text-blue-700"><?php the_title(); ?></p>
              <p class="mt-1 text-xs text-slate-500"><?php echo esc_html(get_the_date()); ?></p>
            </a>
          </li>
        <?php endwhile; ?>
      </ul>
    </div>
    <?php wp_reset_postdata(); ?>
  <?php endif; ?>

  <div class="rounded-2xl border border-blue-100 bg-linear-to-br from-blue-50 to-cyan-50 p-7 shadow-sm">
    <h2 class="text-lg font-bold text-slate-900">پروژه بعدی شما</h2>
    <p class="mt-3 text-sm leading-7 text-slate-600">برای دریافت مشاوره فنی و برآورد دقیق، جزئیات پروژه را برای ما ارسال کنید.</p>
    <a href="<?php echo esc_url(home_url('/project-request/')); ?>" class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-500">
      ثبت درخواست پروژه
    </a>
  </div>
</aside>
