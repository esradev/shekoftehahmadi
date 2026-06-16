<?php

/* Template Name: تماس با ما */

get_header();
?>

<main class="bg-white text-slate-900 antialiased">
  <?php
  get_template_part(
    'template-parts/sections/page-hero',
    null,
    array(
      'current'     => 'تماس با ما',
      'badge'       => 'تماس با ما',
      'title'       => 'آماده شروع پروژه بعدی خود هستید؟',
      'description' => 'با تیم متخصص ما در تماس باشید تا در کمتر از ۲۴ ساعت پاسخ دقیق و پیشنهاد فنی دریافت کنید.',
      'primary'     => 'ثبت پروژه',
      'primary_url' => home_url('/project-request/'),
      'secondary'   => 'مشاهده نمونه کارها',
      'secondary_url' => home_url('/portfolio/'),
    )
  );
  ?>

  <section class="relative isolate bg-linear-to-b from-blue-50 to-white py-16 sm:py-20 lg:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <!-- Stats Section -->
      <div class="grid grid-cols-2 gap-8 lg:grid-cols-4 mb-16">
        <div class="text-center">
          <div class="text-4xl font-bold text-blue-600">۱۵۰+</div>
          <div class="mt-2 text-sm text-slate-600">پروژه موفق</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold text-blue-600">۹۸٪</div>
          <div class="mt-2 text-sm text-slate-600">رضایت مشتریان</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold text-blue-600">۲۴/۷</div>
          <div class="mt-2 text-sm text-slate-600">پشتیبانی</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold text-blue-600">۱۰+</div>
          <div class="mt-2 text-sm text-slate-600">سال تجربه</div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Contact Info -->
        <div class="space-y-8">
          <div>
            <h2 class="text-3xl font-bold text-slate-900">راه‌های ارتباطی</h2>
            <p class="mt-4 text-lg text-slate-600">از هر روشی که راحت هستید با ما در تماس باشید. تیم پشتیبانی ما در کمتر از ۲۴ ساعت پاسخ می‌دهد.</p>
          </div>

          <div class="space-y-6">
            <div class="flex items-start gap-4 p-6 rounded-2xl bg-white shadow-sm border border-slate-100 hover:shadow-md transition">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shrink-0">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-slate-900">تلفن تماس</h3>
                <p class="mt-1 text-slate-600">شنبه تا پنجشنبه، ۹ صبح تا ۶ عصر</p>
                <a href="tel:+989121234567" class="mt-2 inline-block text-blue-600 hover:text-blue-700 font-medium">+98 912 123 4567</a>
              </div>
            </div>

            <div class="flex items-start gap-4 p-6 rounded-2xl bg-white shadow-sm border border-slate-100 hover:shadow-md transition">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shrink-0">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-slate-900">ایمیل</h3>
                <p class="mt-1 text-slate-600">پاسخ در کمتر از ۲۴ ساعت</p>
                <a href="mailto:info@example.com" class="mt-2 inline-block text-blue-600 hover:text-blue-700 font-medium">info@example.com</a>
              </div>
            </div>

            <div class="flex items-start gap-4 p-6 rounded-2xl bg-white shadow-sm border border-slate-100 hover:shadow-md transition">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shrink-0">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-slate-900">آدرس دفتر</h3>
                <p class="mt-1 text-slate-600">برای جلسه حضوری هماهنگ کنید</p>
                <p class="mt-2 text-slate-700">تهران، خیابان ولیعصر، پلاک ۱۲۳<br>کدپستی: ۱۹۹۱۹۱</p>
              </div>
            </div>
          </div>

          <!-- Social Links -->
          <div class="pt-6">
            <h3 class="font-semibold text-slate-900 mb-4">ما را در شبکه‌های اجتماعی دنبال کنید</h3>
            <div class="flex gap-4">
              <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-blue-600 hover:text-white transition">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                </svg>
              </a>
              <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-blue-600 hover:text-white transition">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                </svg>
              </a>
              <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-blue-600 hover:text-white transition">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                </svg>
              </a>
              <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-blue-600 hover:text-white transition">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                </svg>
              </a>
            </div>
          </div>
        </div>

        <!-- Contact Form -->
        <div>
          <div class="rounded-3xl bg-white p-8 shadow-xl border border-slate-100">
            <h3 class="text-2xl font-bold text-slate-900 mb-2">پیام بفرستید</h3>
            <p class="text-slate-600 mb-6">فرم زیر را پر کنید، ما در کمتر از ۲۴ ساعت پاسخ می‌دهیم.</p>
            <?php get_template_part('template-parts/forms/contact-form'); ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
get_template_part(
  'template-parts/ui/toast-notification',
  null,
  array(
    'notice_attr' => 'data-romonet-form-notice',
    'close_attr'  => 'data-romonet-form-notice-close',
    'variant'     => 'success',
  )
);
get_footer();
