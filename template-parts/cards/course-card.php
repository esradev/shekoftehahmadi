<?php

if (! defined('ABSPATH')) {
  exit;
}

// Extract variables passed from the archive loop
$id           = isset($args['id']) ? $args['id'] : 0;
$title        = isset($args['title']) ? $args['title'] : '';
$excerpt      = isset($args['excerpt']) ? $args['excerpt'] : '';
$thumbnail    = isset($args['thumbnail']) ? $args['thumbnail'] : '';
$price        = isset($args['price']) ? $args['price'] : '';
$price_type   = isset($args['price_type']) ? $args['price_type'] : '';
$lesson_count = isset($args['lesson_count']) ? (int) $args['lesson_count'] : 0;
$difficulty   = isset($args['difficulty']) ? $args['difficulty'] : '';
$url          = isset($args['permalink']) ? $args['permalink'] : '#';

// Fallback image if no thumbnail is set
if (! $thumbnail) {
    $thumbnail = function_exists('get_stylesheet_directory_uri') ? get_stylesheet_directory_uri() . '/assets/images/course-placeholder.jpg' : '';
}

// Get course categories for the card
$course_cats = get_the_terms($id, 'ld_course_category');
$primary_cat = ($course_cats && ! is_wp_error($course_cats)) ? $course_cats[0]->name : '';

// Get instructor if available
$instructor_id = get_post_meta($id, 'ld_course_instructor', true);
$instructor_name = $instructor_id ? get_the_title($instructor_id) : '';

// Determine if course is free
$is_free = ($price_type === 'free' || empty($price));

?>

<a href="<?php echo esc_url($url); ?>"
  class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-purple-200 hover:shadow-xl hover:shadow-purple-100/50">
  <div class="relative">
    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>"
      class="aspect-4/3 w-full rounded-t-2xl bg-linear-to-br from-slate-100 to-purple-50 object-cover transition duration-500 group-hover:scale-[1.02]"
      loading="lazy" />

    <?php if ($difficulty) : ?>
    <span
      class="absolute top-4 right-4 inline-flex items-center rounded-full bg-purple-600 px-3 py-1 text-xs font-semibold text-white shadow-sm"><?php echo esc_html($difficulty); ?></span>
    <?php endif; ?>

    <?php if ($is_free) : ?>
    <span
      class="absolute top-4 left-4 inline-flex items-center rounded-full border border-white/70 bg-white/90 px-3 py-1 text-xs font-semibold text-emerald-600 backdrop-blur-sm">رایگان</span>
    <?php endif; ?>

    <div class="absolute inset-0 flex items-end p-4 opacity-0 transition-opacity duration-200 group-hover:opacity-100"
      aria-hidden="true">
      <div
        class="w-full rounded-xl bg-white/90 px-4 py-2.5 text-center text-sm font-semibold text-slate-900 backdrop-blur-sm">
        مشاهده جزئیات دوره</div>
    </div>
  </div>

  <div class="flex flex-1 flex-col p-6 sm:p-7">
    <?php if ($primary_cat) : ?>
    <p class="text-xs font-semibold tracking-wide text-purple-600"><?php echo esc_html($primary_cat); ?></p>
    <?php endif; ?>

    <div class="mt-2 flex items-start justify-between gap-4">
      <h3 class="text-lg font-bold leading-7 text-slate-900 transition group-hover:text-purple-700">
        <?php echo esc_html($title); ?></h3>

      <?php if (! $is_free) : ?>
      <p class="shrink-0 text-base font-bold text-slate-900"><?php echo esc_html($price); ?></p>
      <?php else : ?>
      <p class="shrink-0 text-base font-bold text-emerald-600">رایگان</p>
      <?php endif; ?>
    </div>

    <?php if ($excerpt) : ?>
    <p class="mt-3 flex-1 text-sm leading-7 text-slate-600">
      <?php echo esc_html(wp_trim_words(wp_strip_all_tags($excerpt), 18, '...')); ?>
    </p>
    <?php endif; ?>

    <div class="mt-5 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-4">
      <?php if ($lesson_count > 0) : ?>
      <span
        class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600">
        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <?php echo esc_html(sprintf('%d درس', $lesson_count)); ?>
      </span>
      <?php endif; ?>

      <?php if ($instructor_name) : ?>
      <span
        class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600">
        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        مدرس: <?php echo esc_html($instructor_name); ?>
      </span>
      <?php endif; ?>
    </div>

    <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-purple-600">شروع یادگیری
      <svg class="h-4 w-4 transition group-hover:-translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" aria-hidden="true">
        <path d="M19 12H5" />
        <path d="m12 19-7-7 7-7" />
      </svg>
    </span>
  </div>
</a>
