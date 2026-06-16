<?php

get_header();
?>

<main class="bg-slate-50 text-slate-900 antialiased">
  <?php while (have_posts()) : the_post(); ?>
    <?php
    $course_id = get_the_ID();

    $course_price = function_exists('learndash_get_course_price') ? learndash_get_course_price($course_id) : '';
    $course_price_type = function_exists('learndash_get_price_type') ? learndash_get_price_type($course_id) : '';
    $short_desc = get_post_meta($course_id, 'ld_course_short_description', true);
    $summary = $short_desc ? $short_desc : wp_trim_words(wp_strip_all_tags(get_the_content()), 38);

    $main_image = get_the_post_thumbnail_url($course_id, 'large');
    if (! $main_image) {
      $main_image = function_exists('get_stylesheet_directory_uri') ? get_stylesheet_directory_uri() . '/assets/images/course-placeholder.jpg' : '';
    }

    $course_cats = get_the_term_list($course_id, 'ld_course_category', '', '، ', '');
    $course_tags = get_the_term_list($course_id, 'ld_course_tag', '', '، ', '');

    $difficulty = get_post_meta($course_id, 'ld_course_difficulty', true);
    $difficulty_labels = array(
      'beginner'     => 'مبتدی',
      'intermediate' => 'متوسط',
      'advanced'     => 'پیشرفته',
    );
    $difficulty_label = isset($difficulty_labels[$difficulty]) ? $difficulty_labels[$difficulty] : '';

    $course_steps = function_exists('learndash_course_get_steps') ? learndash_course_get_steps($course_id) : array();
    $lesson_count = isset($course_steps['lessons']) ? count($course_steps['lessons']) : 0;
    $topic_count = isset($course_steps['topics']) ? count($course_steps['topics']) : 0;
    $quiz_count = isset($course_steps['quizzes']) ? count($course_steps['quizzes']) : 0;

    $course_duration = get_post_meta($course_id, 'ld_course_duration', true);
    $course_access_duration = get_post_meta($course_id, 'ld_course_access_duration', true);

    $instructor_id = get_post_meta($course_id, 'ld_course_instructor', true);
    $instructor_name = $instructor_id ? get_the_title($instructor_id) : '';
    $instructor_bio = $instructor_id ? get_post_meta($instructor_id, 'description', true) : '';

    $updated_display = get_the_modified_date('j F Y');

    $hero_highlights = array_filter(
      array(
        $difficulty_label ? 'سطح ' . $difficulty_label : '',
        $lesson_count ? sprintf('%d درس', $lesson_count) : '',
        $topic_count ? sprintf('%d موضوع', $topic_count) : '',
        $quiz_count ? sprintf('%d آزمون', $quiz_count) : '',
        $course_duration,
      )
    );

    $is_enrolled = function_exists('learndash_user_enrolled_in_course') ? learndash_user_enrolled_in_course(get_current_user_id(), $course_id) : false;
    $course_progress = ($is_enrolled && function_exists('learndash_course_progress')) ? learndash_course_progress($course_id, get_current_user_id()) : array();
    $progress_percent = isset($course_progress['percentage']) ? (int) $course_progress['percentage'] : 0;

    $certificate_link = '';
    if ($is_enrolled && $progress_percent >= 100) {
      $certificate_link = function_exists('learndash_get_certificate_link') ? learndash_get_certificate_link($course_id, get_current_user_id()) : '';
    }
    ?>

    <section class="relative overflow-hidden border-b border-slate-200 bg-linear-to-br from-white via-purple-50/40 to-slate-50">
      <div class="pointer-events-none absolute -left-24 top-10 h-72 w-72 rounded-full bg-purple-200/30 blur-3xl" aria-hidden="true"></div>
      <div class="pointer-events-none absolute -right-16 bottom-0 h-64 w-64 rounded-full bg-indigo-200/20 blur-3xl" aria-hidden="true"></div>
      <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgb(147_51_234/0.08)_1px,transparent_0)] bg-size-[24px_24px]" aria-hidden="true"></div>

      <div class="relative mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <?php get_template_part('template-parts/ui/breadcrumbs', null, array('current' => get_the_title(), 'class' => 'mb-8')); ?>

        <div class="grid gap-10 lg:grid-cols-[1.1fr_.9fr] lg:items-start">
          <div class="space-y-6">
            <div class="flex flex-wrap items-center gap-3">
              <?php if ($difficulty_label) : ?>
                <span class="inline-flex items-center rounded-full bg-purple-600 px-4 py-1.5 text-xs font-bold text-white shadow-sm"><?php echo esc_html($difficulty_label); ?></span>
              <?php endif; ?>
              <?php if ($course_cats) : ?>
                <span class="text-sm font-semibold text-purple-700"><?php echo wp_kses_post($course_cats); ?></span>
              <?php endif; ?>
            </div>

            <h1 class="text-balance text-3xl font-black leading-tight text-slate-900 sm:text-4xl lg:text-5xl"><?php the_title(); ?></h1>

            <?php if ($instructor_name) : ?>
              <p class="text-sm font-medium text-slate-500">مدرس: <span class="text-slate-800"><?php echo esc_html($instructor_name); ?></span></p>
            <?php endif; ?>

            <p class="max-w-2xl text-base leading-8 text-slate-600 sm:text-lg"><?php echo esc_html($summary); ?></p>

            <?php if (! empty($hero_highlights)) : ?>
              <div class="flex flex-wrap gap-2">
                <?php foreach ($hero_highlights as $item) : ?>
                  <span class="inline-flex items-center rounded-full border border-purple-100 bg-white/80 px-4 py-2 text-xs font-semibold text-purple-800 shadow-sm backdrop-blur-sm sm:text-sm"><?php echo esc_html($item); ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <div class="flex flex-wrap items-center gap-3 text-sm text-slate-600">
              <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-2 font-medium shadow-sm">
                بروزرسانی: <?php echo esc_html($updated_display); ?>
              </span>

              <?php if ($course_access_duration) : ?>
                <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-2 font-medium shadow-sm">
                  دسترسی: <?php echo esc_html($course_access_duration); ?>
                </span>
              <?php endif; ?>
            </div>

            <div class="rounded-3xl border border-slate-200/80 bg-white/90 p-6 shadow-lg shadow-purple-100/30 backdrop-blur-sm sm:p-7">
              <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="space-y-2">
                  <p class="text-sm font-semibold text-slate-500">هزینه دوره</p>
                  <?php if ('free' === $course_price_type || empty($course_price)) : ?>
                    <div class="text-3xl font-black text-emerald-600">رایگان</div>
                  <?php else : ?>
                    <div class="text-3xl font-black text-slate-900"><?php echo esc_html($course_price); ?></div>
                  <?php endif; ?>
                  <p class="text-xs text-slate-500">دسترسی مادام‌العمر به محتوا</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                  <?php if ($is_enrolled) : ?>
                    <?php if ($progress_percent > 0 && $progress_percent < 100) : ?>
                      <div class="flex items-center gap-3">
                        <div class="h-2 w-32 overflow-hidden rounded-full bg-slate-200">
                          <div class="h-full bg-purple-600 transition-all" style="width: <?php echo esc_attr($progress_percent); ?>%;"></div>
                        </div>
                        <span class="text-sm font-semibold text-slate-700"><?php echo esc_html($progress_percent); ?>%</span>
                      </div>
                      <a href="<?php echo esc_url(function_exists('learndash_get_course_step_link') ? learndash_get_course_step_link($course_id, get_current_user_id()) : get_permalink($course_id)); ?>" class="inline-flex items-center justify-center rounded-full bg-purple-600 px-7 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-500 sm:text-base">ادامه دوره</a>
                    <?php elseif ($progress_percent >= 100) : ?>
                      <?php if ($certificate_link) : ?>
                        <a href="<?php echo esc_url($certificate_link); ?>" target="_blank" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-7 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-500 sm:text-base">دریافت گواهی‌نامه</a>
                      <?php endif; ?>
                      <a href="<?php echo esc_url(function_exists('learndash_get_course_step_link') ? learndash_get_course_step_link($course_id, get_current_user_id()) : get_permalink($course_id)); ?>" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-7 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100 sm:text-base">مشاهده مجدد</a>
                    <?php else : ?>
                      <a href="<?php echo esc_url(function_exists('learndash_get_course_step_link') ? learndash_get_course_step_link($course_id, get_current_user_id()) : get_permalink($course_id)); ?>" class="inline-flex items-center justify-center rounded-full bg-purple-600 px-7 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-500 sm:text-base">شروع دوره</a>
                    <?php endif; ?>
                  <?php else : ?>
                    <?php if ('free' === $course_price_type || empty($course_price)) : ?>
                      <a href="<?php echo esc_url(function_exists('learndash_get_course_enroll_url') ? learndash_get_course_enroll_url($course_id) : get_permalink($course_id)); ?>" class="inline-flex items-center justify-center rounded-full bg-purple-600 px-7 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-500 sm:text-base">ثبت‌نام رایگان</a>
                    <?php else : ?>
                      <a href="<?php echo esc_url(function_exists('learndash_get_course_enroll_url') ? learndash_get_course_enroll_url($course_id) : get_permalink($course_id)); ?>" class="inline-flex items-center justify-center rounded-full bg-purple-600 px-7 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-500 sm:text-base">ثبت‌نام در دوره</a>
                    <?php endif; ?>
                  <?php endif; ?>

                  <a href="#curriculum" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-7 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100 sm:text-base">سرفصل‌ها</a>
                </div>
              </div>
            </div>
          </div>

          <div class="space-y-4">
            <div class="overflow-hidden rounded-4xl border border-slate-200 bg-white shadow-xl shadow-slate-200/50">
              <img src="<?php echo esc_url($main_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="aspect-4/3 w-full object-cover" />
            </div>

            <?php if ($is_enrolled && $progress_percent > 0) : ?>
              <div class="rounded-3xl border border-purple-100 bg-purple-50 p-5">
                <p class="text-sm font-semibold text-purple-900">پیشرفت شما در این دوره</p>
                <div class="mt-3 flex items-center gap-3">
                  <div class="h-3 flex-1 overflow-hidden rounded-full bg-purple-200">
                    <div class="h-full bg-purple-600 transition-all" style="width: <?php echo esc_attr($progress_percent); ?>%;"></div>
                  </div>
                  <span class="text-lg font-black text-purple-700"><?php echo esc_html($progress_percent); ?>%</span>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <section class="py-14 lg:py-20">
      <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_22rem] lg:px-8">
        <div class="space-y-8">
          <section id="description" class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-2xl font-bold text-slate-900">معرفی دوره</h2>
            <div class="prose prose-slate mt-6 max-w-none prose-headings:font-bold prose-a:text-purple-600">
              <?php the_content(); ?>
            </div>
          </section>

          <?php if ($instructor_name) : ?>
            <section class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
              <h2 class="text-2xl font-bold text-slate-900">درباره مدرس</h2>
              <div class="mt-6 flex items-start gap-5">
                <?php $instructor_avatar = get_avatar($instructor_id, 80); ?>
                <?php if ($instructor_avatar) : ?>
                  <div class="shrink-0">
                    <?php echo $instructor_avatar; ?>
                  </div>
                <?php endif; ?>
                <div>
                  <h3 class="text-lg font-bold text-slate-900"><?php echo esc_html($instructor_name); ?></h3>
                  <?php if ($instructor_bio) : ?>
                    <p class="mt-2 text-sm leading-7 text-slate-600"><?php echo esc_html($instructor_bio); ?></p>
                  <?php endif; ?>
                </div>
              </div>
            </section>
          <?php endif; ?>

          <section id="curriculum" class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
              <div>
                <h2 class="text-2xl font-bold text-slate-900">سرفصل‌های دوره</h2>
                <p class="mt-2 text-sm text-slate-600">محتوای کامل دوره به تفکیک دروس و موضوعات</p>
              </div>
              <div class="flex gap-2 text-sm">
                <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 font-medium text-slate-700">
                  <?php echo esc_html($lesson_count); ?> درس
                </span>
                <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 font-medium text-slate-700">
                  <?php echo esc_html($topic_count); ?> موضوع
                </span>
                <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 font-medium text-slate-700">
                  <?php echo esc_html($quiz_count); ?> آزمون
                </span>
              </div>
            </div>

            <?php if (! empty($course_steps['lessons'])) : ?>
              <div class="space-y-4">
                <?php foreach ($course_steps['lessons'] as $lesson) : ?>
                  <?php
                  $lesson_id = $lesson->ID;
                  $lesson_title = get_the_title($lesson_id);
                  $lesson_topics = function_exists('learndash_course_get_steps') ? learndash_course_get_steps($course_id, $lesson_id) : array();
                  $lesson_topic_count = isset($lesson_topics['topics']) ? count($lesson_topics['topics']) : 0;
                  $lesson_quiz_count = isset($lesson_topics['quizzes']) ? count($lesson_topics['quizzes']) : 0;
                  $is_lesson_complete = ($is_enrolled && function_exists('learndash_is_lesson_complete')) ? learndash_is_lesson_complete(get_current_user_id(), $lesson_id, $course_id) : false;
                  ?>
                  <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="flex items-start gap-3">
                      <div class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full <?php echo $is_lesson_complete ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-500'; ?>">
                        <?php echo $is_lesson_complete ? '✓' : '●'; ?>
                      </div>
                      <div class="flex-1">
                        <h3 class="font-semibold text-slate-900"><?php echo esc_html($lesson_title); ?></h3>
                        <?php if ($lesson_topic_count > 0 || $lesson_quiz_count > 0) : ?>
                          <p class="mt-1 text-xs text-slate-500">
                            <?php if ($lesson_topic_count > 0) : ?>
                              <?php echo esc_html($lesson_topic_count); ?> موضوع
                            <?php endif; ?>
                            <?php if ($lesson_topic_count > 0 && $lesson_quiz_count > 0) : ?>
                              ،
                            <?php endif; ?>
                            <?php if ($lesson_quiz_count > 0) : ?>
                              <?php echo esc_html($lesson_quiz_count); ?> آزمون
                            <?php endif; ?>
                          </p>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else : ?>
              <p class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">سرفصلی برای این دوره تعریف نشده است.</p>
            <?php endif; ?>
          </section>

          <section id="course-reviews" class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
              <div>
                <h2 class="text-2xl font-bold text-slate-900">نظرات کاربران</h2>
                <p class="mt-2 text-sm text-slate-600">تجربه کاربرانی که این دوره را گذرانده‌اند.</p>
              </div>
            </div>

            <?php if (comments_open()) : ?>
              <?php comments_template(); ?>
            <?php else : ?>
              <p class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">ثبت نظر برای این دوره در حال حاضر غیرفعال است.</p>
            <?php endif; ?>
          </section>
        </div>

        <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
          <section class="rounded-4xl border border-purple-100 bg-linear-to-br from-purple-600 to-indigo-700 p-6 text-white shadow-lg">
            <h2 class="text-lg font-bold">چرا این دوره؟</h2>
            <ul class="mt-4 space-y-3 text-sm leading-7 text-purple-50">
              <li class="flex gap-2"><span>✓</span><span>محتوای به‌روز و کاربردی</span></li>
              <li class="flex gap-2"><span>✓</span><span>مدرس مجرب و متخصص</span></li>
              <li class="flex gap-2"><span>✓</span><span>پشتیبانی پاسخگویی</span></li>
              <li class="flex gap-2"><span>✓</span><span>گواهی‌نامه معتبر</span></li>
              <li class="flex gap-2"><span>✓</span><span>دسترسی مادام‌العمر</span></li>
            </ul>
          </section>

          <section class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">اطلاعات دوره</h2>
            <dl class="mt-5 space-y-4 text-sm">
              <?php if ($difficulty_label) : ?>
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                  <dt class="text-slate-500">سطح</dt>
                  <dd class="font-semibold text-slate-900"><?php echo esc_html($difficulty_label); ?></dd>
                </div>
              <?php endif; ?>

              <?php if ($instructor_name) : ?>
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                  <dt class="text-slate-500">مدرس</dt>
                  <dd class="font-semibold text-slate-900"><?php echo esc_html($instructor_name); ?></dd>
                </div>
              <?php endif; ?>

              <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                <dt class="text-slate-500">تعداد درس</dt>
                <dd class="font-semibold text-slate-900"><?php echo esc_html($lesson_count); ?></dd>
              </div>

              <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                <dt class="text-slate-500">تعداد موضوع</dt>
                <dd class="font-semibold text-slate-900"><?php echo esc_html($topic_count); ?></dd>
              </div>

              <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                <dt class="text-slate-500">تعداد آزمون</dt>
                <dd class="font-semibold text-slate-900"><?php echo esc_html($quiz_count); ?></dd>
              </div>

              <?php if ($course_duration) : ?>
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                  <dt class="text-slate-500">مدت دوره</dt>
                  <dd class="font-semibold text-slate-900"><?php echo esc_html($course_duration); ?></dd>
                </div>
              <?php endif; ?>

              <?php if ($course_access_duration) : ?>
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                  <dt class="text-slate-500">مدت دسترسی</dt>
                  <dd class="font-semibold text-slate-900"><?php echo esc_html($course_access_duration); ?></dd>
                </div>
              <?php endif; ?>

              <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                <dt class="text-slate-500">آخرین بروزرسانی</dt>
                <dd class="font-semibold text-slate-900"><?php echo esc_html($updated_display); ?></dd>
              </div>

              <div class="flex items-start justify-between gap-4">
                <dt class="text-slate-500">زبان</dt>
                <dd class="font-semibold text-slate-900">فارسی</dd>
              </div>
            </dl>
          </section>

          <?php if ($course_tags) : ?>
            <section class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm">
              <h2 class="text-lg font-bold text-slate-900">برچسب‌ها</h2>
              <div class="mt-4 flex flex-wrap gap-2 text-sm"><?php echo wp_kses_post($course_tags); ?></div>
            </section>
          <?php endif; ?>
        </aside>
      </div>
    </section>
  <?php endwhile; ?>
</main>

<?php
get_footer();
