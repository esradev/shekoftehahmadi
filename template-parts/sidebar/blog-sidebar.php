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
    <h2 class="text-lg font-bold text-slate-900">جستجو در آموزش‌ها</h2>
    <form role="search" method="get" action="<?php echo esc_url($search_action); ?>" class="mt-4">
      <label for="blog-sidebar-search" class="sr-only">جستجو</label>
      <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-3">
        <input id="blog-sidebar-search" type="search" name="s" value="<?php echo esc_attr($search_value); ?>" placeholder="موضوع یا کلمه کلیدی..." class="w-full bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400" />
        <button type="submit" class="rounded-xl bg-pink-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-pink-500">جستجو</button>
      </div>
    </form>
  </div>

  <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
    <h2 class="text-lg font-bold text-slate-900">دسته‌بندی‌های آموزشی</h2>
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
            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="transition hover:text-pink-700">
              <?php echo esc_html($category->name); ?>
            </a>
            <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500"><?php echo esc_html($category->count); ?></span>
          </li>
        <?php endforeach;
      else : ?>
        <li class="text-slate-500">هنوز دسته‌بندی ایجاد نشده است.</li>
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
      <h2 class="text-lg font-bold text-slate-900">جدیدترین مقالات</h2>
      <ul class="mt-4 space-y-4">
        <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
          <li>
            <a href="<?php the_permalink(); ?>" class="group block">
              <p class="text-sm font-semibold text-slate-900 transition group-hover:text-pink-700"><?php the_title(); ?></p>
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
      <h2 class="text-lg font-bold text-slate-900">برچسب‌های پرکاربرد</h2>
      <div class="mt-4 flex flex-wrap gap-2">
        <?php foreach ($tags as $tag) : ?>
          <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-pink-200 hover:bg-pink-50 hover:text-pink-700">
            <?php echo esc_html($tag->name); ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="rounded-2xl border border-pink-100 bg-linear-to-br from-pink-50 to-cyan-50 p-7 shadow-sm">
    <h2 class="text-lg font-bold text-slate-900">نیاز به راهنمایی دارید؟</h2>
    <p class="mt-3 text-sm leading-7 text-slate-600">مسیر یادگیری خود را از همین امروز شروع کنید. برای دریافت مشاوره و انتخاب بهترین دوره آموزشی گرافیک با ما در ارتباط باشید.</p>
    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mt-5 inline-flex items-center justify-center rounded-xl bg-pink-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-pink-500">
      مشاوره رایگان
    </a>
  </div>
</aside>
