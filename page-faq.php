<?php

/* Template Name: پرسش‌های متداول */

get_header();
?>

<main class="bg-white text-slate-900 antialiased" dir="rtl">
  <?php
  get_template_part(
    'template-parts/sections/page-hero',
    null,
    array(
      'current'     => 'پرسش‌های متداول',
      'badge'       => 'FAQ',
      'title'       => 'پاسخ به سوالات رایج قبل از شروع همکاری',
      'description' => 'خدمات طراحی سایت، ووکامرس، افزونه اختصاصی و پشتیبانی را در دسته‌بندی‌های مشخص جستجو کنید یا سوال پرتکرار خود را سریع پیدا کنید.',
      'primary'     => 'ثبت پروژه',
      'primary_url' => home_url('/project-request/'),
      'secondary'   => 'مشاهده تعرفه‌ها',
      'secondary_url' => home_url('/pricing/'),
    )
  );
  ?>

  <?php get_template_part('template-parts/sections/faq-section'); ?>

  <section class="pb-20 lg:pb-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <?php
      get_template_part(
        'template-parts/sections/cta',
        null,
        array(
          'title' => 'سوال دیگری دارید؟',
          'text'  => 'اگر پاسخ موردنظر را پیدا نکردید، کافی است پیام بدهید تا مسیر مناسب را با توجه به هدف و بودجه شما پیشنهاد کنیم.',
        )
      );
      ?>
    </div>
  </section>
</main>

<?php
get_footer();
