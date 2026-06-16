<?php

get_header();
?>

<main class="bg-white text-slate-900 antialiased">
  <?php
  get_template_part(
    'template-parts/sections/page-hero',
    null,
    array(
      'show_breadcrumbs' => false,
      'badge'            => '404',
      'title'            => 'صفحه پیدا نشد',
      'description'      => 'آدرس موردنظر وجود ندارد یا جابه‌جا شده است. از مسیرهای اصلی استفاده کنید.',
      'current'          => '404',
      'primary'          => 'بازگشت به خانه',
      'primary_url'      => home_url('/'),
      'secondary'        => 'تماس با ما',
      'secondary_url'    => home_url('/contact/'),
    )
  );
  ?>

  <section class="py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <?php get_template_part('template-parts/sections/cta', null, array('title' => 'اگر لینک خراب است، به ما خبر دهید', 'text' => 'با یک پیام کوتاه مشکل را گزارش کنید تا سریع اصلاح کنیم.')); ?>
    </div>
  </section>
</main>

<?php
get_footer();
