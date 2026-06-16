<?php

get_header();

$home_services_query    = romonet_get_home_services_query(6);
$home_services_count    = $home_services_query->post_count;
$home_portfolio_query   = romonet_get_home_featured_query('portfolio', 3);
$home_case_study_query  = romonet_get_home_featured_query('case_study', 3);
$home_products_query    = romonet_get_home_products_query(3);
$home_testimonials      = romonet_get_home_testimonials(3);
$home_client_names      = romonet_get_home_client_names(6);

$services_archive_url   = romonet_get_home_archive_url('service');
$portfolio_archive_url  = romonet_get_home_archive_url('portfolio');
$case_study_archive_url = romonet_get_home_archive_url('case_study');
$shop_url               = romonet_get_home_shop_url();
?>

<main class="bg-white text-slate-900 antialiased">
  <section class="relative overflow-hidden border-b border-slate-200 bg-slate-50">
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgb(37_99_235/0.12)_1px,transparent_0)] bg-size-[22px_22px]" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
      <div class="grid items-center gap-12 lg:grid-cols-2">
        <div>
          <span class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3.5 py-1.5 text-sm font-medium text-blue-700">
            <span class="h-2 w-2 rounded-full bg-cyan-500"></span>
            بیش از ۱۲ سال تجربه تخصصی وردپرس
          </span>
          <h1 class="mt-6 text-balance text-4xl font-extrabold leading-tight tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
            سایت وردپرسی که <span class="text-blue-600">کسب‌وکار شما</span> را جلو می‌برد
          </h1>
          <p class="mt-5 max-w-xl text-pretty text-lg leading-8 text-slate-600">
            ما طراحی سایت، فروشگاه ووکامرس، افزونه و قالب اختصاصی، یکپارچه‌سازی پیامک و نگهداری وردپرس را با کیفیتی حرفه‌ای و قابل اتکا انجام می‌دهیم.
          </p>
          <div class="mt-8 flex flex-wrap items-center gap-3">
            <a href="<?php echo esc_url(home_url('/project-request/')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-3.5 text-base font-semibold text-white shadow-sm transition hover:bg-blue-700">
              شروع پروژه
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M19 12H5" />
                <path d="m12 19-7-7 7-7" />
              </svg>
            </a>
            <a href="<?php echo esc_url($portfolio_archive_url); ?>" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-6 py-3.5 text-base font-semibold text-slate-900 transition hover:bg-slate-50">
              مشاهده نمونه‌کارها
            </a>
          </div>
          <dl class="mt-10 grid max-w-lg grid-cols-3 gap-6 border-t border-slate-200 pt-8">
            <div>
              <dt class="text-3xl font-extrabold text-slate-900">+۴۰۰</dt>
              <dd class="mt-1 text-sm text-slate-500">پروژه موفق</dd>
            </div>
            <div>
              <dt class="text-3xl font-extrabold text-slate-900">۹۸٪</dt>
              <dd class="mt-1 text-sm text-slate-500">رضایت مشتری</dd>
            </div>
            <div>
              <dt class="text-3xl font-extrabold text-slate-900">۲۴/۷</dt>
              <dd class="mt-1 text-sm text-slate-500">پشتیبانی</dd>
            </div>
          </dl>
        </div>
        <div class="relative">
          <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-blue-100/40">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/hero-dashboard.png'); ?>" alt="نمونه داشبورد مدیریت و سایت طراحی‌شده با وردپرس" class="h-full w-full object-cover" width="900" height="700" />
          </div>
          <div class="absolute -bottom-5 -left-5 hidden rounded-2xl border border-slate-200 bg-white p-4 shadow-xl shadow-blue-100/40 sm:block">
            <div class="flex items-center gap-3">
              <span class="grid h-11 w-11 place-items-center rounded-xl bg-cyan-50 text-cyan-600">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path d="m12 3 1.9 5.8H20l-4.9 3.6 1.9 5.8L12 14.6 7 18.2l1.9-5.8L4 8.8h6.1z" />
                </svg>
              </span>
              <div>
                <p class="text-sm font-bold text-slate-900">امتیاز سرعت ۹۸</p>
                <p class="text-xs text-slate-500">Core Web Vitals سبز</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php if (! empty($home_client_names)) : ?>
        <div class="mt-16 border-t border-slate-200 pt-8">
          <p class="text-center text-sm font-medium text-slate-500">مورد اعتماد برندها و کسب‌وکارهای پیشرو</p>
          <div class="mt-6 flex flex-wrap items-center justify-center gap-x-10 gap-y-4 opacity-70">
            <?php foreach ($home_client_names as $client_name) : ?>
              <span class="text-xl font-extrabold tracking-tight text-slate-400"><?php echo esc_html($client_name); ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <section class="py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-2xl text-center">
        <span class="text-sm font-bold uppercase tracking-wider text-blue-600">خدمات ما</span>
        <h2 class="mt-3 text-balance text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">هر آنچه برای موفقیت در وردپرس نیاز دارید</h2>
        <p class="mt-4 text-pretty text-lg leading-8 text-slate-600">از ایده تا اجرا و نگهداری؛ تیم ما تمام چرخه عمر پروژه وردپرسی شما را پوشش می‌دهد.</p>
      </div>

      <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php if ($home_services_query->have_posts()) : ?>
          <?php while ($home_services_query->have_posts()) : $home_services_query->the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="group rounded-2xl border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-100/40">
              <span class="grid h-12 w-12 place-items-center rounded-xl bg-blue-50 text-blue-600 transition group-hover:bg-blue-600 group-hover:text-white">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              </span>
              <h3 class="mt-5 text-lg font-bold text-slate-900"><?php the_title(); ?></h3>
              <p class="mt-2 text-sm leading-7 text-slate-600"><?php echo esc_html(romonet_get_post_summary(get_the_ID(), 20)); ?></p>
              <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600">اطلاعات بیشتر
                <svg class="h-4 w-4 transition group-hover:-translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path d="M19 12H5" />
                  <path d="m12 19-7-7 7-7" />
                </svg>
              </span>
            </a>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php endif; ?>
      </div>

      <?php if ($home_services_count > 0) : ?>
        <div class="mt-10 text-center">
          <a href="<?php echo esc_url($services_archive_url); ?>" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700">مشاهده همه خدمات
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
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
          <span class="text-sm font-bold uppercase tracking-wider text-blue-600">چرا رومونت</span>
          <h2 class="mt-3 text-balance text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">کدِ تمیز، تحویل به‌موقع، پشتیبانی واقعی</h2>
          <p class="mt-4 text-pretty text-lg leading-8 text-slate-600">ما فقط سایت نمی‌سازیم؛ شریک فنی بلندمدت شما هستیم. تمرکز ما بر کیفیت کد، امنیت و رشد پایدار کسب‌وکار شماست.</p>
          <ul class="mt-8 space-y-4">
            <li class="flex items-start gap-3">
              <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-cyan-100 text-cyan-700"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
                  <path d="m20 6-11 11-5-5" />
                </svg></span>
              <p class="text-slate-600"><span class="font-bold text-slate-900">کدنویسی استاندارد:</span> رعایت استانداردهای رسمی وردپرس و کد قابل نگهداری.</p>
            </li>
            <li class="flex items-start gap-3">
              <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-cyan-100 text-cyan-700"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
                  <path d="m20 6-11 11-5-5" />
                </svg></span>
              <p class="text-slate-600"><span class="font-bold text-slate-900">سرعت و سئو:</span> بهینه‌سازی Core Web Vitals و ساختار فنی سئو.</p>
            </li>
            <li class="flex items-start gap-3">
              <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-cyan-100 text-cyan-700"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
                  <path d="m20 6-11 11-5-5" />
                </svg></span>
              <p class="text-slate-600"><span class="font-bold text-slate-900">امنیت چندلایه:</span> سخت‌سازی، پشتیبان‌گیری منظم و مانیتورینگ مداوم.</p>
            </li>
            <li class="flex items-start gap-3">
              <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-cyan-100 text-cyan-700"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
                  <path d="m20 6-11 11-5-5" />
                </svg></span>
              <p class="text-slate-600"><span class="font-bold text-slate-900">شفافیت کامل:</span> گزارش پیشرفت منظم و ارتباط مستقیم با تیم فنی.</p>
            </li>
          </ul>
        </div>
        <div class="grid grid-cols-2 gap-5">
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-4xl font-extrabold text-blue-600">۴۰۰+</p>
            <p class="mt-2 text-sm leading-6 text-slate-600">پروژه تحویل‌شده در صنایع مختلف</p>
          </div>
          <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-4xl font-extrabold text-blue-600">۱۲</p>
            <p class="mt-2 text-sm leading-6 text-slate-600">سال تجربه تخصصی در اکوسیستم وردپرس</p>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-4xl font-extrabold text-blue-600">۲۴h</p>
            <p class="mt-2 text-sm leading-6 text-slate-600">میانگین زمان پاسخ‌گویی پشتیبانی</p>
          </div>
          <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-4xl font-extrabold text-blue-600">۹۸٪</p>
            <p class="mt-2 text-sm leading-6 text-slate-600">نرخ رضایت و بازگشت مشتریان</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-2xl text-center">
        <span class="text-sm font-bold uppercase tracking-wider text-blue-600">فرایند همکاری</span>
        <h2 class="mt-3 text-balance text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">از گفت‌وگو تا تحویل، شفاف و حرفه‌ای</h2>
      </div>
      <div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm"><span class="text-sm font-extrabold text-blue-600">۰۱</span>
          <h3 class="mt-3 text-lg font-bold text-slate-900">مشاوره و کشف نیاز</h3>
          <p class="mt-2 text-sm leading-7 text-slate-600">بررسی اهداف، مخاطب و الزامات فنی پروژه شما.</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm"><span class="text-sm font-extrabold text-blue-600">۰۲</span>
          <h3 class="mt-3 text-lg font-bold text-slate-900">طراحی و معماری</h3>
          <p class="mt-2 text-sm leading-7 text-slate-600">طراحی رابط کاربری و معماری فنی متناسب با مقیاس کار.</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm"><span class="text-sm font-extrabold text-blue-600">۰۳</span>
          <h3 class="mt-3 text-lg font-bold text-slate-900">توسعه و تست</h3>
          <p class="mt-2 text-sm leading-7 text-slate-600">کدنویسی، تست کیفیت و بازبینی در محیط آزمایشی.</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm"><span class="text-sm font-extrabold text-blue-600">۰۴</span>
          <h3 class="mt-3 text-lg font-bold text-slate-900">تحویل و پشتیبانی</h3>
          <p class="mt-2 text-sm leading-7 text-slate-600">انتشار نهایی، آموزش و پشتیبانی مستمر پس از تحویل.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="border-y border-slate-200 bg-slate-50 py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end">
        <div class="max-w-xl">
          <span class="text-sm font-bold uppercase tracking-wider text-blue-600">نمونه‌کارها</span>
          <h2 class="mt-3 text-balance text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">پروژه‌هایی که به آن‌ها افتخار می‌کنیم</h2>
        </div>
        <a href="<?php echo esc_url($portfolio_archive_url); ?>" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700">مشاهده همه
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="M19 12H5" />
            <path d="m12 19-7-7 7-7" />
          </svg>
        </a>
      </div>
      <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php if ($home_portfolio_query->have_posts()) : ?>
          <?php
          $portfolio_index = 0;
          while ($home_portfolio_query->have_posts()) :
            $home_portfolio_query->the_post();
            $portfolio_image = get_the_post_thumbnail_url(get_the_ID(), 'romonet-card');
            if (! $portfolio_image) {
              $portfolio_image = romonet_get_portfolio_fallback_image($portfolio_index);
            }
            $portfolio_index++;
          ?>
            <a href="<?php the_permalink(); ?>" class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-xl hover:shadow-blue-100/40">
              <div class="aspect-4/3 overflow-hidden bg-slate-100">
                <img src="<?php echo esc_url($portfolio_image); ?>" alt="<?php the_title_attribute(); ?>" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" />
              </div>
              <div class="p-6">
                <span class="text-xs font-semibold text-cyan-600"><?php echo esc_html(romonet_get_portfolio_term_label()); ?></span>
                <h3 class="mt-1.5 text-lg font-bold text-slate-900"><?php the_title(); ?></h3>
                <p class="mt-1 text-sm text-slate-600"><?php echo esc_html(romonet_get_post_summary(get_the_ID(), 16)); ?></p>
              </div>
            </a>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php if ($home_case_study_query->have_posts()) : ?>
    <section class="py-20 lg:py-28">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end">
          <div class="max-w-xl">
            <span class="text-sm font-bold uppercase tracking-wider text-blue-600">مطالعات موردی</span>
            <h2 class="mt-3 text-balance text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">نتایج واقعی برای کسب‌وکارهای ایرانی</h2>
          </div>
          <a href="<?php echo esc_url($case_study_archive_url); ?>" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700">مشاهده همه
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M19 12H5" />
              <path d="m12 19-7-7 7-7" />
            </svg>
          </a>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          <?php while ($home_case_study_query->have_posts()) : $home_case_study_query->the_post(); ?>
            <?php
            get_template_part(
              'template-parts/cards/case-study-card',
              null,
              array(
                'title' => get_the_title(),
                'text'  => romonet_get_post_summary(get_the_ID(), 18),
                'url'   => get_permalink(),
              )
            );
            ?>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php if ($home_products_query->have_posts()) : ?>
    <section class="border-y border-slate-200 bg-slate-50 py-20 lg:py-28">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end">
          <div class="max-w-xl">
            <span class="text-sm font-bold uppercase tracking-wider text-blue-600">محصولات دیجیتال</span>
            <h2 class="mt-3 text-balance text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">قالب، افزونه و ابزار آماده وردپرس</h2>
            <p class="mt-4 text-pretty text-lg leading-8 text-slate-600">محصولات تست‌شده با پشتیبانی فارسی؛ برای شروع سریع‌تر پروژه‌های شما.</p>
          </div>
          <a href="<?php echo esc_url($shop_url); ?>" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700">مشاهده فروشگاه
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
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

  <?php if (! empty($home_testimonials)) : ?>
  <section class="py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-2xl text-center">
        <span class="text-sm font-bold uppercase tracking-wider text-blue-600">نظر مشتریان</span>
        <h2 class="mt-3 text-balance text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">چرا کسب‌وکارها به ما اعتماد می‌کنند</h2>
      </div>
        <div class="mt-14 grid gap-6 lg:grid-cols-3">
          <?php foreach ($home_testimonials as $testimonial_post) : ?>
            <?php
            $quote         = get_post_meta($testimonial_post->ID, 'testimonial', true);
            $client_name   = get_post_meta($testimonial_post->ID, 'client_name', true);
            $project_title = get_the_title($testimonial_post);
            $display_name  = $client_name ?: $project_title;
            $display_role  = $client_name ? $project_title : 'مشتری رومونت';
            ?>
            <figure class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
              <div class="flex gap-1 text-amber-400" aria-hidden="true">
                <?php for ($star = 0; $star < 5; $star++) : ?>
                  <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="m12 3 2.5 6.5L21 10l-5 4 1.5 7L12 17l-5.5 4L8 14l-5-4 6.5-.5z" />
                  </svg>
                <?php endfor; ?>
              </div>
              <blockquote class="mt-4 text-pretty leading-8 text-slate-600">&laquo;<?php echo esc_html($quote); ?>&raquo;</blockquote>
              <figcaption class="mt-6 flex items-center gap-3">
                <span class="grid h-11 w-11 place-items-center rounded-full bg-blue-50 font-bold text-blue-700"><?php echo esc_html(romonet_get_persian_initials($display_name)); ?></span>
                <div>
                  <p class="text-sm font-bold text-slate-900"><?php echo esc_html($display_name); ?></p>
                  <p class="text-xs text-slate-500"><?php echo esc_html($display_role); ?></p>
                </div>
              </figcaption>
            </figure>
          <?php endforeach; ?>
        </div>
    </div>
  </section>
  <?php endif; ?>

  <section class="pb-20 lg:pb-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="relative overflow-hidden rounded-3xl bg-blue-700 px-6 py-14 text-center shadow-xl shadow-blue-200/50 sm:px-12 lg:py-20">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgb(255_255_255/0.25)_1px,transparent_0)] bg-size-[20px_20px] opacity-20" aria-hidden="true"></div>
        <div class="relative mx-auto max-w-2xl">
          <h2 class="text-balance text-3xl font-extrabold tracking-tight text-white sm:text-4xl">آماده‌اید پروژه وردپرسی‌تان را شروع کنیم؟</h2>
          <p class="mt-4 text-pretty text-lg leading-8 text-blue-100">همین حالا درخواست خود را ثبت کنید؛ کارشناسان ما در کمتر از ۲۴ ساعت با شما تماس می‌گیرند.</p>
          <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <a href="<?php echo esc_url(home_url('/project-request/')); ?>" class="rounded-xl bg-white px-6 py-3.5 text-base font-semibold text-blue-700 shadow-sm transition hover:bg-blue-50">ثبت درخواست پروژه</a>
            <a href="<?php echo esc_url(home_url('/pricing/')); ?>" class="rounded-xl border border-white/30 px-6 py-3.5 text-base font-semibold text-white transition hover:bg-white/10">مشاهده تعرفه‌ها</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
