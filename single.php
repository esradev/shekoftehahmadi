<?php

get_header();
?>

<main class="bg-slate-50 text-slate-900 antialiased">
  <?php while (have_posts()) : the_post(); ?>
    <?php
    $post_id   = get_the_ID();
    $meta      = romonet_get_post_meta_bundle($post_id);
    $summary   = get_the_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content()), 38);
    $categories = get_the_category();
    $tags      = get_the_tags();
    $author_id = (int) get_the_author_meta('ID');
    $comment_count = get_comments_number($post_id);

    $hero_highlights = array_filter(
      array(
        $meta['article_type_label'] ? sprintf('نوع آموزش: %s', $meta['article_type_label']) : '',
        $meta['difficulty_label'] ? sprintf('سطح: %s', $meta['difficulty_label']) : '',
        sprintf('%d دقیقه مطالعه', $meta['reading_time']),
      )
    );

    $related_query = romonet_get_related_posts($post_id, 3);
    ?>

    <section class="relative overflow-hidden border-b border-slate-200 bg-white">
      <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgb(37_99_235/0.12)_1px,transparent_0)] bg-size-[22px_22px]" aria-hidden="true"></div>
      <div class="relative mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <?php get_template_part('template-parts/ui/breadcrumbs', null, array('current' => get_the_title(), 'class' => 'mb-8')); ?>

        <div class="grid gap-10 lg:grid-cols-[1.15fr_.85fr] lg:items-start">
          <div class="space-y-6">
            <?php if (! empty($categories)) : ?>
              <div class="flex flex-wrap gap-2 text-sm font-semibold uppercase tracking-[0.2em] text-pink-600">
                <?php foreach ($categories as $category) : ?>
                  <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="transition hover:text-pink-800"><?php echo esc_html($category->name); ?></a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <h1 class="text-balance text-3xl font-black leading-tight text-slate-900 sm:text-4xl lg:text-5xl"><?php the_title(); ?></h1>

            <p class="max-w-2xl text-base leading-8 text-slate-600 sm:text-lg"><?php echo esc_html($summary); ?></p>

            <?php if (! empty($hero_highlights)) : ?>
              <div class="flex flex-wrap gap-2">
                <?php foreach ($hero_highlights as $item) : ?>
                  <span class="inline-flex items-center rounded-full border border-pink-100 bg-pink-50 px-4 py-2 text-xs font-semibold text-pink-700 sm:text-sm"><?php echo esc_html($item); ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <div class="flex flex-wrap items-center gap-3 text-sm text-slate-600">
              <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-2 font-medium">
                <?php echo esc_html(get_the_date()); ?>
              </span>

              <?php if ($meta['audience']) : ?>
                <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-2 font-medium">
                  <?php echo esc_html(sprintf('مخاطب: %s', $meta['audience'])); ?>
                </span>
              <?php endif; ?>

              <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-2 font-medium">
                <?php echo esc_html(sprintf('%d دیدگاه', $comment_count)); ?>
              </span>
            </div>

            <div class="flex items-center gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-5">
              <?php echo get_avatar($author_id, 56, '', '', array('class' => 'rounded-full')); ?>
              <div>
                <p class="text-sm font-semibold text-slate-900"><?php the_author(); ?></p>
                <?php if ($meta['author_title']) : ?>
                  <p class="text-sm text-slate-500"><?php echo esc_html($meta['author_title']); ?></p>
                <?php endif; ?>
              </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
              <a href="#article-content" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-7 py-3 text-sm font-semibold text-white transition hover:bg-slate-700 sm:text-base">مطالعه آموزش</a>
              <?php if ($meta['related_url']) : ?>
                <a href="<?php echo esc_url($meta['related_url']); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-full border border-pink-200 bg-pink-50 px-7 py-3 text-sm font-semibold text-pink-700 transition hover:bg-pink-100 sm:text-base">
                  <?php echo esc_html($meta['related_url_label'] ? $meta['related_url_label'] : 'منبع مرتبط'); ?>
                </a>
              <?php endif; ?>
              <a href="#article-comments" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-7 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100 sm:text-base">شرکت در بحث</a>
            </div>
          </div>

          <div class="overflow-hidden rounded-4xl border border-slate-200 bg-white shadow-sm">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('large', array('class' => 'aspect-4/3 w-full object-cover', 'alt' => esc_attr(get_the_title()))); ?>
            <?php else : ?>
              <div class="flex aspect-4/3 items-center justify-center bg-slate-100 text-slate-400">
                <svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <rect x="3" y="3" width="18" height="18" rx="2" />
                  <path d="M3 9h18" />
                  <path d="M9 21V9" />
                </svg>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <section class="py-14 lg:py-20">
      <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_21rem] lg:px-8">
        <div class="space-y-8">
          <?php if (! empty($meta['key_takeaways'])) : ?>
            <section class="rounded-4xl bg-white p-6 shadow-sm sm:p-8">
              <h2 class="text-2xl font-bold text-slate-900">آنچه یاد می‌گیرید</h2>
              <ul class="mt-6 grid gap-3 text-sm leading-7 text-slate-700 sm:text-base">
                <?php foreach ($meta['key_takeaways'] as $takeaway) : ?>
                  <li class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                    <span class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-pink-500"></span>
                    <span><?php echo esc_html($takeaway); ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </section>
          <?php endif; ?>

          <?php if (! empty($meta['prerequisites'])) : ?>
            <section class="rounded-4xl bg-white p-6 shadow-sm sm:p-8">
              <h2 class="text-2xl font-bold text-slate-900">پیشنیازها</h2>
              <ul class="mt-6 space-y-3 text-sm leading-7 text-slate-700 sm:text-base">
                <?php foreach ($meta['prerequisites'] as $prerequisite) : ?>
                  <li class="flex items-start gap-3">
                    <span class="mt-2 inline-flex h-2 w-2 rounded-full bg-cyan-500"></span>
                    <span><?php echo esc_html($prerequisite); ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </section>
          <?php endif; ?>

          <section id="article-content" class="rounded-4xl bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-2xl font-bold text-slate-900">متن آموزش</h2>
            <div class="prose prose-slate mt-6 max-w-none">
              <?php the_content(); ?>
            </div>
          </section>

          <?php if (! empty($meta['technologies'])) : ?>
            <section class="rounded-4xl bg-white p-6 shadow-sm sm:p-8">
              <h2 class="text-2xl font-bold text-slate-900">نرم‌افزارها و ابزارها</h2>
              <div class="mt-5 flex flex-wrap gap-2">
                <?php foreach ($meta['technologies'] as $technology) : ?>
                  <span class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700"><?php echo esc_html($technology); ?></span>
                <?php endforeach; ?>
              </div>
            </section>
          <?php endif; ?>

          <section id="article-comments" class="rounded-4xl bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
              <div>
                <h2 class="text-2xl font-bold text-slate-900">نظرات دانشجویان</h2>
                <p class="mt-2 text-sm text-slate-600">سوالات، رفع اشکال و تجربیات هنرجویان آکادمی.</p>
              </div>
              <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700">
                <?php echo esc_html(sprintf('%d دیدگاه', $comment_count)); ?>
              </div>
            </div>

            <?php if (comments_open() || $comment_count > 0) : ?>
              <?php comments_template(); ?>
            <?php else : ?>
              <p class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">بخش نظرات برای این مقاله غیرفعال است.</p>
            <?php endif; ?>
          </section>

          <?php if ($related_query->have_posts()) : ?>
            <section class="rounded-4xl bg-white p-6 shadow-sm sm:p-8">
              <h2 class="text-2xl font-bold text-slate-900">آموزش‌های مرتبط</h2>
              <div class="mt-8 grid gap-6 md:grid-cols-2">
                <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                  <?php get_template_part('template-parts/cards/post-card'); ?>
                <?php endwhile; ?>
              </div>
            </section>
            <?php wp_reset_postdata(); ?>
          <?php endif; ?>
        </div>

        <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
          <section class="rounded-4xl bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">جزئیات آموزش</h2>
            <dl class="mt-5 space-y-4 text-sm">
              <?php if ($meta['article_type_label']) : ?>
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                  <dt class="text-slate-500">فرمت</dt>
                  <dd class="font-semibold text-slate-900"><?php echo esc_html($meta['article_type_label']); ?></dd>
                </div>
              <?php endif; ?>

              <?php if ($meta['difficulty_label']) : ?>
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                  <dt class="text-slate-500">سطح آموزش</dt>
                  <dd class="font-semibold text-slate-900"><?php echo esc_html($meta['difficulty_label']); ?></dd>
                </div>
              <?php endif; ?>

              <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                <dt class="text-slate-500">زمان مطالعه</dt>
                <dd class="font-semibold text-slate-900"><?php echo esc_html(sprintf('%d دقیقه', $meta['reading_time'])); ?></dd>
              </div>

              <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                <dt class="text-slate-500">تاریخ انتشار</dt>
                <dd class="font-semibold text-slate-900"><?php echo esc_html(get_the_date()); ?></dd>
              </div>

              <div class="flex items-start justify-between gap-4">
                <dt class="text-slate-500">آخرین بروزرسانی</dt>
                <dd class="font-semibold text-slate-900"><?php echo esc_html(get_the_modified_date()); ?></dd>
              </div>
            </dl>
          </section>

          <section class="rounded-4xl bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">جستجو در آموزش‌ها</h2>
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="mt-4">
              <label for="single-post-search" class="sr-only">جستجو</label>
              <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-3">
                <input id="single-post-search" type="search" name="s" placeholder="موضوع یا کلمه کلیدی..." class="w-full bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400" />
                <button type="submit" class="rounded-xl bg-pink-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-pink-500">بگرد</button>
              </div>
            </form>
          </section>

          <?php if (! empty($categories)) : ?>
            <section class="rounded-4xl bg-white p-6 shadow-sm">
              <h2 class="text-lg font-bold text-slate-900">دسته‌بندی‌ها</h2>
              <ul class="mt-4 space-y-3 text-sm text-slate-600">
                <?php foreach ($categories as $category) : ?>
                  <li>
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="transition hover:text-pink-700"><?php echo esc_html($category->name); ?></a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </section>
          <?php endif; ?>

          <?php if ($tags) : ?>
            <section class="rounded-4xl bg-white p-6 shadow-sm">
              <h2 class="text-lg font-bold text-slate-900">برچسب‌ها</h2>
              <div class="mt-4 flex flex-wrap gap-2">
                <?php foreach ($tags as $tag) : ?>
                  <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-pink-200 hover:bg-pink-50 hover:text-pink-700">
                    <?php echo esc_html($tag->name); ?>
                  </a>
                <?php endforeach; ?>
              </div>
            </section>
          <?php endif; ?>

          <section class="rounded-4xl border border-pink-100 bg-linear-to-br from-pink-50 to-cyan-50 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">نیاز به راهنمایی بیشتر دارید؟</h2>
            <p class="mt-3 text-sm leading-7 text-slate-600">برای یادگیری اصولی و عملی این مباحث، می‌توانید در دوره‌های جامع آکادمی ما شرکت کنید.</p>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mt-5 inline-flex w-full items-center justify-center rounded-2xl bg-pink-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-pink-500">
              مشاوره و ثبت‌نام دوره‌ها
            </a>
          </section>
        </aside>
      </div>
    </section>
  <?php endwhile; ?>
</main>

<?php
get_footer();
