<?php

get_header();

// کوئری جایگزین برای دریافت جدیدترین پست‌های وردپرس
$latest_posts_query = new WP_Query(array(
    'post_type'           => 'post',
    'posts_per_page'      => 6,
    'ignore_sticky_posts' => true
));

$home_products_query    = romonet_get_home_products_query(3);
$shop_url               = romonet_get_home_shop_url();

// دریافت آدرس صفحه وبلاگ (نوشته‌ها)
$blog_archive_url       = get_option('page_for_posts') ? get_permalink(get_option('page_for_posts')) : home_url('/blog/');
?>

<main class="bg-white text-slate-900 antialiased">
  <section class="relative overflow-hidden border-b border-slate-200 bg-slate-50">
    <div
      class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgb(37_99_235/0.12)_1px,transparent_0)] bg-size-[22px_22px]"
      aria-hidden="true"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
      <div class="grid items-center gap-12 lg:grid-cols-2">
        <div>
          <span
            class="inline-flex items-center gap-2 rounded-full border border-pink-100 bg-pink-50 px-3.5 py-1.5 text-sm font-medium text-pink-700">
            <span class="h-2 w-2 rounded-full bg-cyan-500"></span>
            بیش از ۱۲ سال تجربه آموزش دوره های گرافیکی
          </span>
          <h1
            class="mt-6 text-balance text-4xl font-extrabold leading-tight tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
            یادگیری که به <span class="text-pink-600">مسیر شغلی شما</span> کمک خواهد کرد.
          </h1>
          <p class="mt-5 max-w-xl text-pretty text-lg leading-8 text-slate-600">
            ما آموزش‌های تخصصی فتوشاپ، ایلوستریتور، ایندیزاین و طراحی رابط کاربری (UI/UX) را با رویکردی پروژه‌محور و
            ویژه ورود به بازار کار ارائه می‌دهیم.
          </p>
          <div class="mt-8 flex flex-wrap items-center gap-3">
            <a href="<?php echo esc_url(home_url('/courses/')); ?>"
              class="inline-flex items-center gap-2 rounded-xl bg-pink-600 px-6 py-3.5 text-base font-semibold text-white shadow-sm transition hover:bg-pink-700">
              شروع یادگیری
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M19 12H5" />
                <path d="m12 19-7-7 7-7" />
              </svg>
            </a>

          </div>
          <dl class="mt-10 grid max-w-lg grid-cols-3 gap-6 border-t border-slate-200 pt-8">
            <div>
              <dt class="text-3xl font-extrabold text-slate-900">+۴۰۰</dt>
              <dd class="mt-1 text-sm text-slate-500">دانشجوی موفق</dd>
            </div>
            <div>
              <dt class="text-3xl font-extrabold text-slate-900">۹۸٪</dt>
              <dd class="mt-1 text-sm text-slate-500">رضایت دانشجویان</dd>
            </div>
            <div>
              <dt class="text-3xl font-extrabold text-slate-900">۲۴/۷</dt>
              <dd class="mt-1 text-sm text-slate-500">پشتیبانی آموزشی</dd>
            </div>
          </dl>
        </div>
        <div class="relative">
          <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-pink-100/40">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/hero-dashboard.png'); ?>"
              alt="محیط یادگیری و نرم‌افزارهای گرافیکی" class="h-full w-full object-cover" width="900" height="700" />
          </div>
          <div
            class="absolute -bottom-5 -left-5 hidden rounded-2xl border border-slate-200 bg-white p-4 shadow-xl shadow-pink-100/40 sm:block">
            <div class="flex items-center gap-3">
              <span class="grid h-11 w-11 place-items-center rounded-xl bg-cyan-50 text-cyan-600">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  aria-hidden="true">
                  <path d="M12 2l3 6 6 1-4 4 1 6-6-3-6 3 1-6-4-4 6-1z" />
                </svg>
              </span>
              <div>
                <p class="text-sm font-bold text-slate-900">ارائه مدرک معتبر</p>
                <p class="text-xs text-slate-500">دوره‌های پروژه‌محور و عملی</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- بخش آخرین مقالات (جایگزین شده با بخش خدمات) -->
  <section class="py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-2xl text-center">
        <span class="text-sm font-bold uppercase tracking-wider text-pink-600">مقالات و آموزش‌ها</span>
        <h2 class="mt-3 text-balance text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">به‌روزترین
          آموزش‌های دنیای گرافیک</h2>
        <p class="mt-4 text-pretty text-lg leading-8 text-slate-600">جدیدترین ترفندها، اخبار و مقالات آموزشی
          نرم‌افزارهای طراحی را در وبلاگ ما بخوانید.</p>
      </div>

      <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php if ($latest_posts_query->have_posts()) : ?>
        <?php while ($latest_posts_query->have_posts()) : $latest_posts_query->the_post(); ?>
        <a href="<?php the_permalink(); ?>"
          class="group rounded-2xl border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:border-pink-200 hover:shadow-xl hover:shadow-pink-100/40">
          <span
            class="grid h-12 w-12 place-items-center rounded-xl bg-pink-50 text-pink-600 transition group-hover:bg-pink-600 group-hover:text-white">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
              aria-hidden="true">
              <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </span>
          <h3 class="mt-5 text-lg font-bold text-slate-900"><?php the_title(); ?></h3>
          <p class="mt-2 text-sm leading-7 text-slate-600">
            <?php echo esc_html(romonet_get_post_summary(get_the_ID(), 20)); ?></p>
          <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-pink-600">مطالعه مقاله
            <svg class="h-4 w-4 transition group-hover:-translate-x-1" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M19 12H5" />
              <path d="m12 19-7-7 7-7" />
            </svg>
          </span>
        </a>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
        <?php endif; ?>
      </div>

      <?php if ($latest_posts_query->post_count > 0) : ?>
      <div class="mt-10 text-center">
        <a href="<?php echo esc_url($blog_archive_url); ?>"
          class="inline-flex items-center gap-1.5 text-sm font-semibold text-pink-600 hover:text-pink-700">مشاهده همه
          مقالات
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            aria-hidden="true">
            <path d="M19 12H5" />
            <path d="m12 19-7-7 7-7" />
          </svg>
        </a>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <section class="border-y border-slate-200 bg-slate-50 py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="grid items-center gap-14 lg:grid-cols-2">
        <div>
          <span class="text-sm font-bold uppercase tracking-wider text-pink-600">چرا آکادمی ما</span>
          <h2 class="mt-3 text-balance text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">آموزش اصولی،
            پروژه‌محور، پشتیبانی واقعی</h2>
          <p class="mt-4 text-pretty text-lg leading-8 text-slate-600">ما فقط نرم‌افزار آموزش نمی‌دهیم؛ شما را برای ورود
            به بازار کار طراحی گرافیک آماده می‌کنیم. تمرکز ما بر مهارت‌آموزی، خلاقیت و رشد حرفه‌ای شماست.</p>
          <ul class="mt-8 space-y-4">
            <li class="flex items-start gap-3">
              <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-cyan-100 text-cyan-700"><svg
                  class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                  aria-hidden="true">
                  <path d="m20 6-11 11-5-5" />
                </svg></span>
              <p class="text-slate-600"><span class="font-bold text-slate-900">اساتید مجرب:</span> تدریس توسط طراحان
                حرفه‌ای با سابقه کار در صنعت.</p>
            </li>
            <li class="flex items-start gap-3">
              <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-cyan-100 text-cyan-700"><svg
                  class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                  aria-hidden="true">
                  <path d="m20 6-11 11-5-5" />
                </svg></span>
              <p class="text-slate-600"><span class="font-bold text-slate-900">پروژه‌محور:</span> یادگیری از طریق انجام
                پروژه‌های واقعی و کاربردی.</p>
            </li>
            <li class="flex items-start gap-3">
              <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-cyan-100 text-cyan-700"><svg
                  class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                  aria-hidden="true">
                  <path d="m20 6-11 11-5-5" />
                </svg></span>
              <p class="text-slate-600"><span class="font-bold text-slate-900">پشتیبانی آموزشی:</span> رفع اشکال و
                راهنمایی مستمر در طول دوره.</p>
            </li>
            <li class="flex items-start gap-3">
              <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-cyan-100 text-cyan-700"><svg
                  class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                  aria-hidden="true">
                  <path d="m20 6-11 11-5-5" />
                </svg></span>
              <p class="text-slate-600"><span class="font-bold text-slate-900">ارائه مدرک:</span> دریافت گواهینامه معتبر
                پس از پایان دوره.</p>
            </li>
          </ul>
        </div>
        <div class="grid grid-cols-2 gap-5">
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-4xl font-extrabold text-pink-600">۴۰۰+</p>
            <p class="mt-2 text-sm leading-6 text-slate-600">دانشجوی وارد شده به بازار کار</p>
          </div>
          <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-4xl font-extrabold text-pink-600">۱۲</p>
            <p class="mt-2 text-sm leading-6 text-slate-600">سال تجربه تخصصی در آموزش گرافیک</p>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-4xl font-extrabold text-pink-600">۲۴h</p>
            <p class="mt-2 text-sm leading-6 text-slate-600">پاسخگویی و رفع اشکال دانشجویان</p>
          </div>
          <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-4xl font-extrabold text-pink-600">۹۸٪</p>
            <p class="mt-2 text-sm leading-6 text-slate-600">نرخ رضایت دانشجویان از دوره‌ها</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-2xl text-center">
        <span class="text-sm font-bold uppercase tracking-wider text-pink-600">مسیر یادگیری شما</span>
        <h2 class="mt-3 text-balance text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">از صفر تا ورود
          به بازار کار</h2>
      </div>
      <div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm"><span
            class="text-sm font-extrabold text-pink-600">۰۱</span>
          <h3 class="mt-3 text-lg font-bold text-slate-900">مشاوره و ثبت‌نام</h3>
          <p class="mt-2 text-sm leading-7 text-slate-600">بررسی سطح شما و انتخاب بهترین دوره آموزشی.</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm"><span
            class="text-sm font-extrabold text-pink-600">۰۲</span>
          <h3 class="mt-3 text-lg font-bold text-slate-900">آموزش و تمرین</h3>
          <p class="mt-2 text-sm leading-7 text-slate-600">شرکت در کلاس‌ها و انجام تمرین‌های عملی نرم‌افزار.</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm"><span
            class="text-sm font-extrabold text-pink-600">۰۳</span>
          <h3 class="mt-3 text-lg font-bold text-slate-900">انجام پروژه</h3>
          <p class="mt-2 text-sm leading-7 text-slate-600">پیاده‌سازی یک پروژه جامع برای ساخت پورتفولیو.</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm"><span
            class="text-sm font-extrabold text-pink-600">۰۴</span>
          <h3 class="mt-3 text-lg font-bold text-slate-900">ورود به بازار کار</h3>
          <p class="mt-2 text-sm leading-7 text-slate-600">دریافت مدرک و مشاوره برای استخدام یا فریلنسری.</p>
        </div>
      </div>
    </div>
  </section>

  <?php if ($home_products_query->have_posts()) : ?>
  <section class="border-y border-slate-200 bg-slate-50 py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end">
        <div class="max-w-xl">
          <span class="text-sm font-bold uppercase tracking-wider text-pink-600">ابزارهای گرافیکی</span>
          <h2 class="mt-3 text-balance text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">فایل‌های
            لایه‌باز و منابع طراحی</h2>
          <p class="mt-4 text-pretty text-lg leading-8 text-slate-600">مجموعه‌ای از براش‌ها، موکاپ‌ها و ابزارهای مورد
            نیاز برای طراحان.</p>
        </div>
        <a href="<?php echo esc_url($shop_url); ?>"
          class="inline-flex items-center gap-1.5 text-sm font-semibold text-pink-600 hover:text-pink-700">مشاهده
          فروشگاه
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            aria-hidden="true">
            <path d="M19 12H5" />
            <path d="m12 19-7-7 7-7" />
          </svg>
        </a>
      </div>
      <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php while ($home_products_query->have_posts()) : $home_products_query->the_post(); ?>
        <?php
            $product_card_args = function_exists('romonet_get_product_card_args')
              ? romonet_get_product_card_args(get_the_ID())
              : array();
            if (! empty($product_card_args)) {
              $product_card_args['compact'] = true;
              get_template_part('template-parts/cards/product-card', null, $product_card_args);
            }
            ?>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <section class="pb-20 lg:pb-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div
        class="relative overflow-hidden rounded-3xl bg-pink-700 px-6 py-14 text-center shadow-xl shadow-pink-200/50 sm:px-12 lg:py-20">
        <div
          class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgb(255_255_255/0.25)_1px,transparent_0)] bg-size-[20px_20px] opacity-20"
          aria-hidden="true"></div>
        <div class="relative mx-auto max-w-2xl">
          <h2 class="text-balance text-3xl font-extrabold tracking-tight text-white sm:text-4xl">آماده‌اید مسیر حرفه‌ای
            خود را در گرافیک شروع کنید؟</h2>
          <p class="mt-4 text-pretty text-lg leading-8 text-pink-100">همین حالا در دوره‌های ما ثبت‌نام کنید و مهارت‌های
            خود را به سطح بعدی ببرید.</p>
          <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <a href="<?php echo esc_url(home_url('/consultation/')); ?>"
              class="rounded-xl bg-white px-6 py-3.5 text-base font-semibold text-pink-700 shadow-sm transition hover:bg-pink-50">مشاوره
              رایگان</a>
            <a href="<?php echo esc_url(home_url('/courses/')); ?>"
              class="rounded-xl border border-white/30 px-6 py-3.5 text-base font-semibold text-white transition hover:bg-white/10">مشاهده
              دوره‌ها</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
