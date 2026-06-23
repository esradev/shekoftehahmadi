<?php

/* Template Name: درباره ما */

get_header();
?>

<main class="bg-white text-slate-900 antialiased" dir="rtl">
  <?php
  get_template_part(
    'template-parts/sections/page-hero',
    null,
    array(
      'current'     => 'درباره دپارتمان',
      'badge'       => 'درباره ما',
      'title'       => 'دپارتمانی با تمرکز بر هنر، پژوهش و خلاقیت بصری',
      'description' => 'ما در دانشکده گرافیک، طراحی را نه صرفاً یک خروجی بصری، بلکه زبانی برای اندیشه و ارتباطات عمیق فرهنگی می‌دانیم.',
    )
  );
  ?>

  <section class="relative isolate overflow-hidden py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-2xl gap-x-14 lg:mx-0 lg:flex lg:max-w-none lg:items-center">
        <div class="relative w-full lg:max-w-xl lg:shrink-0 xl:max-w-2xl">
          <h2 class="text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">مرجع آموزش و پژوهش در هنرهای تجسمی</h2>
          <p class="mt-8 text-lg leading-8 text-slate-600 sm:max-w-md lg:max-w-none">دپارتمان ارتباط تصویری ما، تلفیقی از آموزش مبانی هنری، تفکر انتقادی و تکنیک‌های نوین دیزاین است. ما به دانشجویان کمک می‌کنیم تا در دنیای هنر معاصر صدای منحصر‌به‌فرد خود را پیدا کنند و آثاری با پشتوانه علمی و آکادمیک خلق کنند.</p>
          <p class="mt-6 max-w-xl text-base leading-7 text-slate-700">از یادگیری اصول کلاسیک زیبایی‌شناسی تا تسلط بر رسانه‌های نوین، هر دوره تحصیلی ما یک مسیر روشن و پژوهش‌محور دارد. تمرکز ما روی تربیت طراحانی است که هم از نظر تئوری غنی باشند و هم مهارت‌های عملی بالایی برای ورود به عرصه حرفه‌ای داشته باشند.</p>
        </div>

        <div class="mt-14 flex justify-end gap-8 sm:-mt-44 sm:justify-start sm:pr-20 lg:mt-0 lg:pr-0">
          <div class="mr-auto w-44 flex-none space-y-8 pt-32 sm:mr-0 sm:pt-80 lg:order-first lg:pt-36 xl:order-0 xl:pt-80">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-4.0.3&auto=format&fit=crop&h=528&q=80" alt="کارگاه طراحی گرافیک" class="aspect-2/3 w-full rounded-xl bg-slate-100 object-cover shadow-lg">
              <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-slate-900/10 ring-inset"></div>
            </div>
          </div>
          <div class="ml-auto w-44 flex-none space-y-8 sm:ml-0 sm:pt-52 lg:pt-36">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1485217988980-11786ced9454?ixlib=rb-4.0.3&auto=format&fit=crop&h=528&q=80" alt="هم‌اندیشی دانشجویان هنر" class="aspect-2/3 w-full rounded-xl bg-slate-100 object-cover shadow-lg">
              <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-slate-900/10 ring-inset"></div>
            </div>
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?ixlib=rb-4.0.3&auto=format&fit=crop&crop=focalpoint&fp-x=.4&w=396&h=528&q=80" alt="جلسه ژوژمان و نقد اثر" class="aspect-2/3 w-full rounded-xl bg-slate-100 object-cover shadow-lg">
              <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-slate-900/10 ring-inset"></div>
            </div>
          </div>
          <div class="w-44 flex-none space-y-8 pt-32 sm:pt-0">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1670272504528-790c24957dda?ixlib=rb-4.0.3&auto=format&fit=crop&crop=left&w=400&h=528&q=80" alt="تایپوگرافی و چاپ" class="aspect-2/3 w-full rounded-xl bg-slate-100 object-cover shadow-lg">
              <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-slate-900/10 ring-inset"></div>
            </div>
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1670272505284-8faba1c31f7d?ixlib=rb-4.0.3&auto=format&fit=crop&h=528&q=80" alt="گرافیک دیزاین معاصر" class="aspect-2/3 w-full rounded-xl bg-slate-100 object-cover shadow-lg">
              <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-slate-900/10 ring-inset"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
      <h2 class="text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">رسالت آکادمیک ما</h2>
      <div class="mt-6 flex flex-col gap-x-8 gap-y-20 lg:flex-row">
        <div class="lg:w-full lg:max-w-2xl lg:flex-auto">
          <p class="text-xl leading-8 text-slate-600">ما با ارائه برنامه‌های آموزشی جامع در مقاطع مختلف تحصیلی، بستری فراهم می‌کنیم تا دانشجویان دانش بصری و توانمندی‌های هنری خود را در سطحی جهانی توسعه دهند.</p>
          <p class="mt-10 max-w-xl text-base leading-7 text-slate-700">هیئت علمی ما با تمرکز بر پرورش خلاقیت، نقد هنری و هدایت پروژه‌های دانشگاهی، محیطی می‌سازند که همواره الهام‌بخش است و ظرفیت دانشجویان را برای ورود به عرصه‌های فرهنگی، پژوهشی و بازار کار گرافیک ارتقا می‌دهد.</p>
        </div>
        <div class="lg:flex lg:flex-auto lg:justify-center">
          <dl class="w-64 space-y-8 xl:w-80">
            <div class="flex flex-col-reverse gap-y-4">
              <dt class="text-base leading-7 text-slate-600">دانش‌آموختگان فعال</dt>
              <dd class="text-5xl font-semibold tracking-tight text-slate-900">850+</dd>
            </div>
            <div class="flex flex-col-reverse gap-y-4">
              <dt class="text-base leading-7 text-slate-600">اعضای هیئت علمی</dt>
              <dd class="text-5xl font-semibold tracking-tight text-slate-900">34</dd>
            </div>
            <div class="flex flex-col-reverse gap-y-4">
              <dt class="text-base leading-7 text-slate-600">کارگاه‌ها و آتلیه‌ها</dt>
              <dd class="text-5xl font-semibold tracking-tight text-slate-900">12+</dd>
            </div>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-32 sm:mt-40 xl:mx-auto xl:max-w-7xl xl:px-8">
    <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?ixlib=rb-4.0.3&auto=format&fit=crop&w=2832&q=80" alt="پردیس هنرهای زیبا" class="aspect-5/2 w-full object-cover xl:rounded-3xl">
  </div>

  <div class="mx-auto mt-32 max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-2xl lg:mx-0">
      <h2 class="text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">ارزش‌های بنیادین ما</h2>
      <p class="mt-6 text-lg leading-8 text-slate-600">ما روی آموزش نوآورانه، پژوهش‌های نظری هنر و پرورش استعدادهای نوظهور تمرکز می‌کنیم تا دانشجویان در عرصه ارتباط تصویری سرآمد باشند.</p>
    </div>
    <dl class="mx-auto my-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-6 text-base leading-7 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
      <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
        <dt class="font-semibold text-slate-900">خلاقیت و نوآوری بصری</dt>
        <dd class="mt-3 text-slate-600">همواره دانشجویان را به شکستن مرزهای سنتی و کشف رویکردهای بدیع در طراحی گرافیک تشویق می‌کنیم.</dd>
      </div>
      <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
        <dt class="font-semibold text-slate-900">تعالی و دقت آکادمیک</dt>
        <dd class="mt-3 text-slate-600">ارائه سرفصل‌های آموزشی مطابق با استانداردهای جهانی و ارزیابی دقیق و علمی پروژه‌های دانشجویی.</dd>
      </div>
      <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
        <dt class="font-semibold text-slate-900">پژوهشِ هنر‌محور</dt>
        <dd class="mt-3 text-slate-600">حمایت مستمر از پایان‌نامه‌ها و مقالاتی که به بررسی تاریخ، نظریه و نقد در حوزه ارتباط تصویری می‌پردازند.</dd>
      </div>
      <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
        <dt class="font-semibold text-slate-900">آموزش مهارت‌محور</dt>
        <dd class="mt-3 text-slate-600">ایجاد پیوند موثر بین تئوری‌های دانشگاهی و مهارت‌های فنی مورد نیاز در آتلیه‌ها و صنعت روز دنیا.</dd>
      </div>
      <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
        <dt class="font-semibold text-slate-900">گفتمان و نقد هنری</dt>
        <dd class="mt-3 text-slate-600">برگزاری منظم جلسات ژوژمان، نمایشگاه‌ها و نشست‌های نقد اثر برای تقویت دیدگاه تحلیلی دانشجویان.</dd>
      </div>
      <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
        <dt class="font-semibold text-slate-900">تعهد به فرهنگ و جامعه</dt>
        <dd class="mt-3 text-slate-600">تربیت طراحانی که با خلق آثار ارزشمند، به حل مسائل فرهنگی و ارتقای سواد بصری جامعه کمک کنند.</dd>
      </div>
    </dl>
  </div>
</main>

<?php
get_footer();
