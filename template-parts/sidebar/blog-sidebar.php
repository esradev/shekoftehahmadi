<?php

if (! defined('ABSPATH')) {
  exit;
}

$search_action = isset($args['search_action']) ? $args['search_action'] : home_url('/');
$search_value  = isset($args['search_value']) ? $args['search_value'] : get_search_query();
$recent_count  = isset($args['recent_count']) ? absint($args['recent_count']) : 5;
?>

<aside class="space-y-6">
  <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
    <h2 class="text-lg font-bold text-slate-900"><?php esc_html_e('Search the blog', 'romonet'); ?></h2>
    <form role="search" method="get" action="<?php echo esc_url($search_action); ?>" class="mt-4">
      <label for="blog-sidebar-search" class="sr-only"><?php esc_html_e('Search', 'romonet'); ?></label>
      <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-3">
        <input id="blog-sidebar-search" type="search" name="s" value="<?php echo esc_attr($search_value); ?>" placeholder="<?php esc_attr_e('Topic or keyword', 'romonet'); ?>" class="w-full bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400" />
        <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-500"><?php esc_html_e('Go', 'romonet'); ?></button>
      </div>
    </form>
  </div>

  <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
    <h2 class="text-lg font-bold text-slate-900"><?php esc_html_e('Categories', 'romonet'); ?></h2>
    <ul class="mt-4 space-y-3 text-sm text-slate-600">
      <?php
      $categories = get_categories(
        array(
          'orderby'    => 'count',
          'order'      => 'DESC',
          'hide_empty' => true,
        )
      );

      if (! empty($categories)) :
        foreach ($categories as $category) :
      ?>
          <li class="flex items-center justify-between gap-3">
            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="transition hover:text-blue-700">
              <?php echo esc_html($category->name); ?>
            </a>
            <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500"><?php echo esc_html($category->count); ?></span>
          </li>
        <?php endforeach;
      else : ?>
        <li class="text-slate-500"><?php esc_html_e('No categories yet.', 'romonet'); ?></li>
      <?php endif; ?>
    </ul>
  </div>

  <?php
  $recent_posts = new WP_Query(
    array(
      'post_type'           => 'post',
      'post_status'         => 'publish',
      'posts_per_page'      => $recent_count,
      'ignore_sticky_posts' => true,
      'no_found_rows'       => true,
    )
  );

  if ($recent_posts->have_posts()) :
  ?>
    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
      <h2 class="text-lg font-bold text-slate-900"><?php esc_html_e('Latest articles', 'romonet'); ?></h2>
      <ul class="mt-4 space-y-4">
        <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
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

  <?php
  $tags = get_tags(
    array(
      'orderby'    => 'count',
      'order'      => 'DESC',
      'hide_empty' => true,
      'number'     => 12,
    )
  );

  if (! empty($tags)) :
  ?>
    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
      <h2 class="text-lg font-bold text-slate-900"><?php esc_html_e('Popular tags', 'romonet'); ?></h2>
      <div class="mt-4 flex flex-wrap gap-2">
        <?php foreach ($tags as $tag) : ?>
          <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
            <?php echo esc_html($tag->name); ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="rounded-2xl border border-blue-100 bg-linear-to-br from-blue-50 to-cyan-50 p-7 shadow-sm">
    <h2 class="text-lg font-bold text-slate-900"><?php esc_html_e('Need expert help?', 'romonet'); ?></h2>
    <p class="mt-3 text-sm leading-7 text-slate-600"><?php esc_html_e('Turn insights into action. Tell us about your project and we will recommend the right technical path.', 'romonet'); ?></p>
    <a href="<?php echo esc_url(home_url('/project-request/')); ?>" class="mt-5 inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-500">
      <?php esc_html_e('Start a project', 'romonet'); ?>
    </a>
  </div>
</aside>
