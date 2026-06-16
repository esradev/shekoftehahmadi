<?php

get_header();

$hero_badge       = 'آکادمی آموزشی';
$hero_title       = 'دوره‌های آموزشی';
$hero_description = 'دوره‌های جامع و کاربردی در حوزه‌های مختلف — با محتوای به‌روز، اساتید مجرب و گواهی‌نامه معتبر.';
$hero_current     = 'دوره‌ها';

if (is_tax('ld_course_category')) {
  $term = get_queried_object();
  if ($term instanceof WP_Term) {
    $hero_badge       = 'دسته‌بندی دوره';
    $hero_title       = $term->name;
    $hero_description = $term->description ? wp_trim_words(wp_strip_all_tags($term->description), 28) : $hero_description;
    $hero_current     = $term->name;
  }
} elseif (is_tax('ld_course_tag')) {
  $term = get_queried_object();
  if ($term instanceof WP_Term) {
    $hero_badge       = 'برچسب دوره';
    $hero_title       = $term->name;
    $hero_description = $term->description ? wp_trim_words(wp_strip_all_tags($term->description), 28) : $hero_description;
    $hero_current     = $term->name;
  }
}

$active_level   = isset($_GET['difficulty']) ? sanitize_text_field($_GET['difficulty']) : '';
$level_labels   = array(
  'beginner'   => 'مبتدی',
  'intermediate' => 'متوسط',
  'advanced'   => 'پیشرفته',
);
$archive_url    = get_post_type_archive_link('sfwd-courses');
$found_posts    = $GLOBALS['wp_query']->found_posts;
$search_query   = get_search_query();
$course_cats    = get_terms(array(
  'taxonomy'   => 'ld_course_category',
  'hide_empty' => true,
  'orderby'    => 'name',
  'order'      => 'ASC',
));

if (is_wp_error($course_cats)) {
  $course_cats = array();
}

$current_cat_id = 0;
if (is_tax('ld_course_category')) {
  $queried_term = get_queried_object();
  if ($queried_term instanceof WP_Term) {
    $current_cat_id = (int) $queried_term->term_id;
  }
}

$level_counts = array();
foreach ($level_labels as $level_key => $level_label) {
  $count_query = new WP_Query(array(
    'post_type'      => 'sfwd-courses',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'fields'         => 'ids',
    'meta_query'     => array(
      array(
        'key'     => 'ld_course_difficulty',
        'value'   => $level_key,
        'compare' => '=',
      ),
    ),
  ));
  $level_counts[$level_key] = (int) $count_query->found_posts;
  wp_reset_postdata();
}
?>

<main class="bg-slate-50 text-slate-900 antialiased">
  <?php
  get_template_part(
    'template-parts/sections/page-hero',
    null,
    array(
      'current'     => $hero_current,
      'badge'       => $hero_badge,
      'title'       => $hero_title,
      'description' => $hero_description,
      'primary'     => 'مشاوره رایگان',
      'primary_url' => home_url('/contact/'),
    )
  );
  ?>

  <section class="border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-purple-100 bg-purple-50/60 px-5 py-4">
          <p class="text-2xl font-black text-purple-700"><?php echo esc_html($found_posts); ?></p>
          <p class="mt-1 text-sm text-slate-600">دوره آموزشی فعال</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4">
          <p class="text-2xl font-black text-slate-900"><?php echo esc_html(count($course_cats)); ?></p>
          <p class="mt-1 text-sm text-slate-600">دسته‌بندی تخصصی</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4">
          <p class="text-2xl font-black text-slate-900">ساعت</p>
          <p class="mt-1 text-sm text-slate-600">محتوای ویدیویی با کیفیت</p>
        </div>
        <div class="rounded-2xl border border-amber-100 bg-amber-50/60 px-5 py-4">
          <p class="text-2xl font-black text-amber-700">گواهی‌نامه</p>
          <p class="mt-1 text-sm text-slate-600">مدرک معتبر پس از اتمام</p>
        </div>
      </div>
    </div>
  </section>

  <section class="py-16 lg:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="grid gap-10 lg:grid-cols-[1fr_300px]">
        <div class="space-y-8">
          <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-col gap-5">
              <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm font-bold text-slate-900">فیلتر بر اساس سطح دوره</p>
                  <p class="mt-1 text-sm text-slate-600">
                    <?php
                    if ($active_level && isset($level_labels[$active_level])) {
                      echo esc_html(sprintf('نمایش دوره‌های %1$s — %2$d دوره', $level_labels[$active_level], $found_posts));
                    } else {
                      echo esc_html(sprintf('%d دوره یافت شد', $found_posts));
                    }
                    ?>
                  </p>
                </div>
                <?php if ($search_query) : ?>
                  <p class="text-sm text-purple-700">جستجو: «<?php echo esc_html($search_query); ?>»</p>
                <?php endif; ?>
              </div>

              <div class="flex flex-wrap gap-2">
                <?php
                $all_active = '' === $active_level;
                $all_classes = $all_active
                  ? 'bg-purple-600 text-white shadow-md shadow-purple-200'
                  : 'border border-slate-200 bg-white text-slate-700 hover:border-purple-200 hover:bg-purple-50 hover:text-purple-700';
                ?>
                <a href="<?php echo esc_url(remove_query_arg('difficulty', $archive_url)); ?>" class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold transition <?php echo esc_attr($all_classes); ?>">
                  همه
                </a>

                <?php foreach ($level_labels as $level_key => $level_label) : ?>
                  <?php
                  $is_active = $active_level === $level_key;
                  $chip_classes = $is_active
                    ? 'bg-purple-600 text-white shadow-md shadow-purple-200'
                    : 'border border-slate-200 bg-white text-slate-700 hover:border-purple-200 hover:bg-purple-50 hover:text-purple-700';
                  $level_count = isset($level_counts[$level_key]) ? $level_counts[$level_key] : 0;
                  ?>
                  <a href="<?php echo esc_url(add_query_arg('difficulty', $level_key, $archive_url)); ?>" class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold transition <?php echo esc_attr($chip_classes); ?>">
                    <?php echo esc_html($level_label); ?>
                    <span class="text-xs opacity-75">(<?php echo esc_html($level_count); ?>)</span>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <?php if (have_posts()) : ?>
            <div class="grid gap-6 md:grid-cols-2">
              <?php while (have_posts()) : the_post(); ?>
                <?php
                $course_id = get_the_ID();
                $course_price = function_exists('learndash_get_course_price') ? learndash_get_course_price($course_id) : '';
                $course_price_type = function_exists('learndash_get_price_type') ? learndash_get_price_type($course_id) : '';
                $course_steps = function_exists('learndash_course_get_steps') ? learndash_course_get_steps($course_id) : array();
                $lesson_count = isset($course_steps['lessons']) ? count($course_steps['lessons']) : 0;
                $difficulty = get_post_meta($course_id, 'ld_course_difficulty', true);
                $difficulty_label = isset($level_labels[$difficulty]) ? $level_labels[$difficulty] : '';

                $card_args = array(
                  'id' => $course_id,
                  'title' => get_the_title(),
                  'excerpt' => get_the_excerpt(),
                  'thumbnail' => get_the_post_thumbnail_url($course_id, 'medium_large'),
                  'price' => $course_price,
                  'price_type' => $course_price_type,
                  'lesson_count' => $lesson_count,
                  'difficulty' => $difficulty_label,
                  'permalink' => get_permalink($course_id),
                );

                get_template_part('template-parts/cards/course-card', null, $card_args);
                ?>
              <?php endwhile; ?>
            </div>

            <div class="mt-12"><?php get_template_part('template-parts/ui/pagination'); ?></div>
          <?php else : ?>
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center">
              <p class="text-lg font-bold text-slate-900">دوره‌ای یافت نشد</p>
              <p class="mt-2 text-sm text-slate-600">فیلتر دیگری امتحان کنید یا با تیم پشتیبانی برای راهنمایی تماس بگیرید.</p>
              <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mt-6 inline-flex items-center justify-center rounded-full bg-purple-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-purple-500">مشاوره رایگان</a>
            </div>
          <?php endif; ?>
        </div>

        <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">جستجو در دوره‌ها</h2>
            <form role="search" method="get" action="<?php echo esc_url($archive_url); ?>" class="mt-4">
              <label for="course-sidebar-search" class="sr-only">جستجو</label>
              <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-3">
                <input id="course-sidebar-search" type="search" name="s" value="<?php echo esc_attr($search_query); ?>" placeholder="نام دوره، مدرس یا کلیدواژه..." class="w-full bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400" />
                <input type="hidden" name="post_type" value="sfwd-courses" />
                <?php if ($active_level) : ?>
                  <input type="hidden" name="difficulty" value="<?php echo esc_attr($active_level); ?>" />
                <?php endif; ?>
                <button type="submit" class="shrink-0 rounded-xl bg-purple-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-purple-500">جستجو</button>
              </div>
            </form>
          </div>

          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">دسته‌بندی‌ها</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
              <?php
              $all_courses_url = $archive_url;
              if ($active_level) {
                $all_courses_url = add_query_arg('difficulty', $active_level, $all_courses_url);
              }
              ?>
              <li>
                <a href="<?php echo esc_url($all_courses_url); ?>" class="<?php echo 0 === $current_cat_id ? 'font-semibold text-purple-700' : 'transition hover:text-purple-700'; ?>">
                  همه دوره‌ها
                </a>
              </li>

              <?php if (! empty($course_cats)) : ?>
                <?php foreach ($course_cats as $course_cat) : ?>
                  <?php
                  $cat_link = get_term_link($course_cat);
                  if (is_wp_error($cat_link)) {
                    continue;
                  }
                  if ($active_level) {
                    $cat_link = add_query_arg('difficulty', $active_level, $cat_link);
                  }
                  $is_current = $current_cat_id === (int) $course_cat->term_id;
                  ?>
                  <li>
                    <a href="<?php echo esc_url($cat_link); ?>" class="<?php echo $is_current ? 'font-semibold text-purple-700' : 'transition hover:text-purple-700'; ?>">
                      <?php echo esc_html($course_cat->name); ?>
                      <span class="text-slate-400">(<?php echo esc_html($course_cat->count); ?>)</span>
                    </a>
                  </li>
                <?php endforeach; ?>
              <?php else : ?>
                <li class="text-slate-500">دسته‌ای موجود نیست.</li>
              <?php endif; ?>
            </ul>
          </div>

          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">سطح دوره</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
              <?php foreach ($level_labels as $level_key => $level_label) : ?>
                <?php
                $level_url = add_query_arg('difficulty', $level_key, $archive_url);
                $is_current_level = $active_level === $level_key;
                $level_count = isset($level_counts[$level_key]) ? $level_counts[$level_key] : 0;
                ?>
                <li>
                  <a href="<?php echo esc_url($level_url); ?>" class="flex items-center justify-between <?php echo $is_current_level ? 'font-semibold text-purple-700' : 'transition hover:text-purple-700'; ?>">
                    <span><?php echo esc_html($level_label); ?></span>
                    <span class="text-slate-400"><?php echo esc_html($level_count); ?></span>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <div class="rounded-2xl border border-purple-100 bg-linear-to-br from-purple-50 to-indigo-50 p-6">
            <h2 class="text-lg font-bold text-slate-900">در انتخاب دوره مردد هستید؟</h2>
            <p class="mt-3 text-sm leading-7 text-slate-600">سطح فعلی و اهداف خود را بگویید تا مناسب‌ترین دوره آموزشی را پیشنهاد دهیم.</p>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-purple-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-purple-500">
              مشاوره رایگان
            </a>
          </div>
        </aside>
      </div>

      <div class="mt-16">
        <?php get_template_part('template-parts/sections/cta', null, array(
          'title' => 'برای انتخاب دوره مطمئن نیستید؟',
          'text'  => 'نیازتان را بگویید تا بهترین دوره آموزشی متناسب با سطح و اهداف شما را پیشنهاد کنیم.',
        )); ?>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
