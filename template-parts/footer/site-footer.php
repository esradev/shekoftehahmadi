<?php

/**
 * Site footer template part.
 */

if (! defined('ABSPATH')) {
  exit;
}
?>

<footer class="border-t border-slate-200 bg-neutral-950 text-slate-300">
  <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-5">
      <div class="lg:col-span-2">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2.5" aria-label="رومونت">
          <span class="grid h-10 w-10 place-items-center rounded-xl bg-pink-600 text-white">
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M3 12a9 9 0 1 0 18 0 9 9 0 0 0-18 0Z" />
              <path d="m4 9 4.5 11L12 9l3.5 11L20 9" />
            </svg>
          </span>
          <span class="text-lg font-extrabold text-white">رومونت</span>
        </a>
        <p class="mt-4 max-w-sm text-sm leading-7 text-slate-400">
          استودیو تخصصی توسعه وردپرس؛ از طراحی سایت و فروشگاه ووکامرس تا افزونه و قالب اختصاصی، یکپارچه‌سازی پیامک و نگهداری حرفه‌ای.
        </p>
        <div class="mt-6 flex items-center gap-3">
          <a href="#" aria-label="لینکدین" class="grid h-10 w-10 place-items-center rounded-xl border border-white/10 text-slate-300 transition hover:border-white/30 hover:text-white">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M4.98 3.5A2.5 2.5 0 1 1 0 3.5a2.5 2.5 0 0 1 4.98 0ZM.5 8h4V24h-4V8Zm7.5 0h3.8v2.2h.05c.53-1 1.83-2.2 3.77-2.2 4.03 0 4.78 2.65 4.78 6.1V24h-4v-7.1c0-1.7-.03-3.9-2.38-3.9-2.38 0-2.75 1.86-2.75 3.78V24h-4V8Z" />
            </svg>
          </a>
          <a href="#" aria-label="تلگرام" class="grid h-10 w-10 place-items-center rounded-xl border border-white/10 text-slate-300 transition hover:border-white/30 hover:text-white">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M21.9 4.3 18.6 19.9c-.25 1.1-.9 1.37-1.83.85l-5.05-3.72-2.44 2.35c-.27.27-.5.5-1.02.5l.36-5.16 9.4-8.49c.4-.36-.09-.56-.63-.2L5.16 13.1.16 11.5c-1.08-.34-1.1-1.08.23-1.6L20.5 2.7c.9-.33 1.69.2 1.4 1.6Z" />
            </svg>
          </a>
          <a href="#" aria-label="اینستاگرام" class="grid h-10 w-10 place-items-center rounded-xl border border-white/10 text-slate-300 transition hover:border-white/30 hover:text-white">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <rect x="3" y="3" width="18" height="18" rx="5" />
              <circle cx="12" cy="12" r="4" />
              <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
            </svg>
          </a>
          <a href="#" aria-label="گیت‌هاب" class="grid h-10 w-10 place-items-center rounded-xl border border-white/10 text-slate-300 transition hover:border-white/30 hover:text-white">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M12 2C6.48 2 2 6.58 2 12.25c0 4.53 2.87 8.37 6.84 9.73.5.1.68-.22.68-.49v-1.7c-2.78.62-3.37-1.22-3.37-1.22-.46-1.18-1.11-1.5-1.11-1.5-.91-.64.07-.62.07-.62 1 .07 1.53 1.06 1.53 1.06.9 1.57 2.36 1.12 2.94.85.09-.67.35-1.12.63-1.38-2.22-.26-4.55-1.14-4.55-5.07 0-1.12.39-2.03 1.03-2.75-.1-.26-.45-1.3.1-2.7 0 0 .84-.28 2.75 1.05a9.4 9.4 0 0 1 5 0c1.91-1.33 2.75-1.05 2.75-1.05.55 1.4.2 2.44.1 2.7.64.72 1.03 1.63 1.03 2.75 0 3.94-2.34 4.8-4.57 5.06.36.32.68.94.68 1.9v2.82c0 .27.18.6.69.49A10.02 10.02 0 0 0 22 12.25C22 6.58 17.52 2 12 2Z" />
            </svg>
          </a>
        </div>
      </div>

      <div>
        <h3 class="text-sm font-bold text-white">خدمات</h3>
        <ul class="mt-4 space-y-3 text-sm">
          <?php
          $service_posts = get_posts(
            array(
              'post_type'      => 'service',
              'posts_per_page' => 6,
              'post_status'    => 'publish',
              'orderby'        => 'date',
              'order'          => 'DESC',
            )
          );

          if ($service_posts) :
            foreach ($service_posts as $post) :
              setup_postdata($post);
          ?>
              <li><a href="<?php echo esc_url(get_permalink($post)); ?>" class="text-slate-400 transition hover:text-white"><?php echo esc_html(get_the_title($post)); ?></a></li>
            <?php
            endforeach;
            wp_reset_postdata();
          else :
            ?>
            <li><a href="<?php echo esc_url(home_url('/services/')); ?>" class="text-slate-400 transition hover:text-white">طراحی سایت وردپرس</a></li>
            <li><a href="<?php echo esc_url(home_url('/services/')); ?>" class="text-slate-400 transition hover:text-white">توسعه افزونه اختصاصی</a></li>
            <li><a href="<?php echo esc_url(home_url('/services/')); ?>" class="text-slate-400 transition hover:text-white">طراحی قالب اختصاصی</a></li>
            <li><a href="<?php echo esc_url(home_url('/services/')); ?>" class="text-slate-400 transition hover:text-white">فروشگاه ووکامرس</a></li>
            <li><a href="<?php echo esc_url(home_url('/services/')); ?>" class="text-slate-400 transition hover:text-white">یکپارچه‌سازی پیامک</a></li>
            <li><a href="<?php echo esc_url(home_url('/services/')); ?>" class="text-slate-400 transition hover:text-white">نگهداری و بهینه‌سازی</a></li>
          <?php endif; ?>
        </ul>
      </div>

      <div>
        <h3 class="text-sm font-bold text-white">شرکت</h3>
        <?php if (has_nav_menu('footer')) : ?>
          <?php
          add_filter('nav_menu_link_attributes', 'romonet_footer_nav_menu_link_attributes', 10, 4);
          wp_nav_menu(
            array(
              'theme_location' => 'footer',
              'container'      => false,
              'menu_class'     => 'mt-4 space-y-3 text-sm',
              'fallback_cb'    => false,
              'depth'          => 1,
            )
          );
          remove_filter('nav_menu_link_attributes', 'romonet_footer_nav_menu_link_attributes', 10, 4);
          ?>
        <?php else : ?>
          <ul class="mt-4 space-y-3 text-sm">
            <li><a href="<?php echo esc_url(home_url('/about/')); ?>" class="text-slate-400 transition hover:text-white">درباره ما</a></li>
            <li><a href="<?php echo esc_url(home_url('/portfolio/')); ?>" class="text-slate-400 transition hover:text-white">نمونه‌کارها</a></li>
            <li><a href="<?php echo esc_url(home_url('/case_study/')); ?>" class="text-slate-400 transition hover:text-white">مطالعات موردی</a></li>
            <li><a href="<?php echo esc_url(home_url('/pricing/')); ?>" class="text-slate-400 transition hover:text-white">تعرفه‌ها</a></li>
            <li><a href="<?php echo esc_url(home_url('/blog/')); ?>" class="text-slate-400 transition hover:text-white">وبلاگ</a></li>
            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>" class="text-slate-400 transition hover:text-white">تماس با ما</a></li>
          </ul>
        <?php endif; ?>
      </div>

      <div>
        <h3 class="text-sm font-bold text-white">منابع</h3>
        <?php if (has_nav_menu('legal')) : ?>
          <?php
          add_filter('nav_menu_link_attributes', 'romonet_footer_nav_menu_link_attributes', 10, 4);
          wp_nav_menu(
            array(
              'theme_location' => 'legal',
              'container'      => false,
              'menu_class'     => 'mt-4 space-y-3 text-sm',
              'fallback_cb'    => false,
              'depth'          => 1,
            )
          );
          remove_filter('nav_menu_link_attributes', 'romonet_footer_nav_menu_link_attributes', 10, 4);
          ?>
        <?php else : ?>
          <ul class="mt-4 space-y-3 text-sm">
            <li><a href="<?php echo esc_url(home_url('/faq/')); ?>" class="text-slate-400 transition hover:text-white">سوالات متداول</a></li>
            <li><a href="<?php echo esc_url(home_url('/documentation/')); ?>" class="text-slate-400 transition hover:text-white">مستندات</a></li>
            <li><a href="<?php echo esc_url(home_url('/shop/')); ?>" class="text-slate-400 transition hover:text-white">محصولات آماده</a></li>
            <li><a href="<?php echo esc_url(home_url('/project-request/')); ?>" class="text-slate-400 transition hover:text-white">درخواست پروژه</a></li>
          </ul>
        <?php endif; ?>
      </div>
    </div>

    <div class="mt-12 overflow-hidden rounded-3xl border border-white/10 bg-linear-to-br from-slate-900 via-slate-900 to-pink-950 p-8 sm:p-10">
      <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.2fr)] lg:items-center">
        <div>
          <span class="inline-flex items-center gap-2 rounded-full border border-pink-500/30 bg-pink-500/10 px-3 py-1 text-xs font-semibold text-pink-300">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
            </svg>
            خبرنامه رومونت
          </span>
          <p class="mt-4 text-sm leading-7 text-slate-400">
            هر هفته نکات فنی وردپرس، به‌روزرسانی‌های محصول و پیشنهادهای ویژه را دریافت کنید.
          </p>
        </div>

        <?php
        get_template_part(
          'template-parts/ui/newsletter-subscribe',
          null,
          array(
            'fields'       => 'phone',
            'title'        => 'عضویت در خبرنامه',
            'description'  => '',
            'layout'       => 'stacked',
            'form_id'      => 'footer-newsletter-form',
            'source'       => 'footer',
            'show_consent' => true,
            'class'        => 'lg:justify-self-end lg:w-full lg:max-w-xl',
          )
        );
        ?>
      </div>
    </div>

    <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-6 text-sm text-slate-500 sm:flex-row">
      <p>© <?php echo esc_html(date_i18n('Y')); ?> رومونت. تمامی حقوق محفوظ است.</p>
      <div class="flex items-center gap-5">
        <a href="<?php echo esc_url(home_url('/terms/')); ?>" class="transition hover:text-white">قوانین و مقررات</a>
        <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" class="transition hover:text-white">حریم خصوصی</a>
      </div>
    </div>
  </div>
</footer>
