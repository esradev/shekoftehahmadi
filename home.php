<?php

get_header();

$total_posts    = wp_count_posts('post')->publish;
$categories     = get_categories(array('hide_empty' => true));
$category_count = count($categories);
$sticky_posts   = get_option('sticky_posts');
$featured_id    = ! empty($sticky_posts) ? absint($sticky_posts[0]) : 0;
$blog_url       = get_permalink(get_option('page_for_posts')) ?: home_url('/');
?>

<main class="bg-slate-50 text-slate-900 antialiased">
  <?php
  get_template_part(
    'template-parts/sections/page-hero',
    null,
    array(
      'current'     => 'مقالات آموزشی',
      'badge'       => 'پایگاه دانش گرافیک',
      'title'       => 'آموزش‌های کاربردی گرافیک برای ورود به بازار کار',
      'description' => 'ترفندهای فتوشاپ، ایلوستریتور، طراحی رابط کاربری (UI/UX) و مقالات تخصصی از اساتید آکادمی.',
    )
  );
  ?>

  <section class="border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
      <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
          <p class="text-sm font-semibold text-slate-500">مقالات منتشر شده</p>
          <p class="mt-2 text-3xl font-black text-slate-900"><?php echo esc_html(number_format_i18n($total_posts)); ?></p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
          <p class="text-sm font-semibold text-slate-500">دسته‌بندی‌های آموزشی</p>
          <p class="mt-2 text-3xl font-black text-slate-900"><?php echo esc_html(number_format_i18n($category_count)); ?></p>
        </div>
        <div class="rounded-3xl border border-pink-100 bg-pink-50 p-6">
          <p class="text-sm font-semibold text-pink-700">چه چیزی اینجا یاد می‌گیرید؟</p>
          <p class="mt-2 text-sm leading-7 text-pink-900">آموزش‌های پروژه‌محور، ترفندهای نرم‌افزاری و نکات تخصصی که می‌توانید در پروژه‌های واقعی طراحی استفاده کنید.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <?php if (! empty($categories)) : ?>
        <div class="mb-10 flex flex-wrap gap-2">
          <a href="<?php echo esc_url($blog_url); ?>" class="inline-flex rounded-full bg-pink-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-pink-700">
            همه مقالات
          </a>
          <?php foreach ($categories as $category) : ?>
            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="inline-flex rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-pink-200 hover:text-pink-700">
              <?php echo esc_html($category->name); ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div class="grid gap-10 lg:grid-cols-[1fr_320px]">
        <div class="space-y-8">
          <?php if (have_posts()) : ?>
            <?php
            $shown_featured = false;

            if ($featured_id) :
              $featured_post = get_post($featured_id);
              if ($featured_post && 'publish' === $featured_post->post_status) :
                $shown_featured = true;
                get_template_part(
                  'template-parts/cards/post-card',
                  null,
                  array(
                    'post_id'  => $featured_id,
                    'featured' => true,
                  )
                );
              endif;
            endif;
            ?>

            <div class="grid gap-8 md:grid-cols-2">
              <?php while (have_posts()) : the_post(); ?>
                <?php if ($shown_featured && get_the_ID() === $featured_id) {
                  continue;
                } ?>
                <?php get_template_part('template-parts/cards/post-card'); ?>
              <?php endwhile; ?>
            </div>

            <div class="pt-4"><?php get_template_part('template-parts/ui/pagination'); ?></div>
          <?php else : ?>
            <?php get_template_part('template-parts/content/content-none'); ?>
          <?php endif; ?>
        </div>

        <?php get_template_part('template-parts/sidebar/blog-sidebar'); ?>
      </div>

      <div class="mt-16">
        <?php get_template_part(
          'template-parts/sections/cta',
          null,
          array(
            'title' => 'آماده‌اید مهارت‌های گرافیکی خود را ارتقا دهید؟',
            'text'  => 'در دوره‌های جامع آکادمی شرکت کنید و با انجام پروژه‌های واقعی، برای ورود قدرتمند به بازار کار آماده شوید.'
          )
        ); ?>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
