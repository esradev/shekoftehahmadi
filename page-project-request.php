<?php

/* Template Name: درخواست پروژه */

get_header();
?>

<main class="bg-white text-slate-900 antialiased">
  <?php
  get_template_part(
    'template-parts/sections/page-hero',
    null,
    array(
      'current'     => 'درخواست پروژه',
      'badge'       => 'درخواست پروژه',
      'title'       => 'جزئیات پروژه را بفرستید تا برآورد دقیق ارائه کنیم',
      'description' => 'هرچه اطلاعات بیشتری بدهید، پیشنهاد فنی و زمان‌بندی ما دقیق‌تر می‌شود.',
    )
  );
  ?>

  <section class="relative isolate bg-linear-to-b from-pink-50 to-white py-16 sm:py-20 lg:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Left Side - Info -->
        <div class="lg:col-span-4 space-y-8">
          <div>
            <h2 class="text-3xl font-bold text-slate-900">چرا فرم چند مرحله‌ای؟</h2>
            <p class="mt-4 text-lg text-slate-600">با پاسخ به سوالات مرحله به مرحله، ما می‌توانیم پیشنهاد دقیق‌تر و حرفه‌ای‌تری برای پروژه شما ارائه دهیم.</p>
          </div>

          <div class="space-y-4">
            <div class="flex items-start gap-4 p-4 rounded-2xl bg-white shadow-sm border border-slate-100">
              <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-pink-100 text-pink-600 shrink-0">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-slate-900">دقت بیشتر</h3>
                <p class="mt-1 text-sm text-slate-600">اطلاعات دقیق‌تر = پیشنهاد بهتر</p>
              </div>
            </div>

            <div class="flex items-start gap-4 p-4 rounded-2xl bg-white shadow-sm border border-slate-100">
              <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-pink-100 text-pink-600 shrink-0">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-slate-900">صرفه‌جویی در زمان</h3>
                <p class="mt-1 text-sm text-slate-600">فقط ۳ دقیقه برای تکمیل</p>
              </div>
            </div>

            <div class="flex items-start gap-4 p-4 rounded-2xl bg-white shadow-sm border border-slate-100">
              <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-pink-100 text-pink-600 shrink-0">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-slate-900">شفافیت کامل</h3>
                <p class="mt-1 text-sm text-slate-600">بدون هزینه‌های پنهان</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Side - Multi-step Form -->
        <div class="lg:col-span-8">
          <div class="rounded-3xl bg-white p-8 shadow-xl border border-slate-100">
            <!-- Progress Steps -->
            <div class="mb-8">
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="step-indicator flex h-10 w-10 items-center justify-center rounded-full bg-pink-600 text-white font-semibold" data-step="1">۱</div>
                  <div class="ml-2 text-sm font-medium text-pink-600">اطلاعات تماس</div>
                </div>
                <div class="flex-1 mx-4 h-1 bg-slate-200">
                  <div class="progress-bar h-full bg-pink-600 transition-all duration-300" style="width: 0%"></div>
                </div>
                <div class="flex items-center">
                  <div class="step-indicator flex h-10 w-10 items-center justify-center rounded-full bg-slate-200 text-slate-600 font-semibold" data-step="2">۲</div>
                  <div class="ml-2 text-sm font-medium text-slate-600">جزئیات پروژه</div>
                </div>
                <div class="flex-1 mx-4 h-1 bg-slate-200">
                  <div class="progress-bar h-full bg-pink-600 transition-all duration-300" style="width: 0%"></div>
                </div>
                <div class="flex items-center">
                  <div class="step-indicator flex h-10 w-10 items-center justify-center rounded-full bg-slate-200 text-slate-600 font-semibold" data-step="3">۳</div>
                  <div class="ml-2 text-sm font-medium text-slate-600">بودجه و زمان</div>
                </div>
              </div>
            </div>

            <form id="project-request-form" class="grid gap-6" data-form-type="project">
              <!-- Step 1: Contact Information -->
              <div class="form-step active" data-step="1">
                <h3 class="text-xl font-semibold text-slate-900 mb-4">اطلاعات تماس</h3>
                <div class="grid gap-6 sm:grid-cols-2">
                  <label class="grid gap-2 text-sm font-medium text-slate-700">
                    <span>نام و نام خانوادگی</span>
                    <input type="text" name="contact_name" required class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100" placeholder="مثلاً سارا رضایی" />
                  </label>
                  <label class="grid gap-2 text-sm font-medium text-slate-700">
                    <span>نام سازمان (اختیاری)</span>
                    <input type="text" name="company_name" class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100" placeholder="نام شرکت یا سازمان" />
                  </label>
                  <label class="grid gap-2 text-sm font-medium text-slate-700">
                    <span>ایمیل</span>
                    <input type="email" name="email" required class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100" placeholder="name@example.com" />
                  </label>
                  <label class="grid gap-2 text-sm font-medium text-slate-700">
                    <span>شماره تماس</span>
                    <input type="tel" name="phone" required class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100" placeholder="0912 123 4567" />
                  </label>
                </div>
                <div class="mt-6 flex justify-end">
                  <button type="button" class="next-step-btn inline-flex justify-center rounded-2xl bg-pink-600 px-8 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700">مرحله بعد</button>
                </div>
              </div>

              <!-- Step 2: Project Details -->
              <div class="form-step hidden" data-step="2">
                <h3 class="text-xl font-semibold text-slate-900 mb-4">جزئیات پروژه</h3>
                <div class="grid gap-6">
                  <label class="grid gap-2 text-sm font-medium text-slate-700">
                    <span>نوع پروژه</span>
                    <select name="project_type" required class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100">
                      <option value="">انتخاب کنید</option>
                      <option value="website">سایت شرکتی</option>
                      <option value="ecommerce">فروشگاه ووکامرس</option>
                      <option value="plugin">افزونه اختصاصی</option>
                      <option value="theme">قالب اختصاصی</option>
                      <option value="integration">یکپارچه‌سازی سیستم‌ها</option>
                      <option value="support">پشتیبانی و نگهداری</option>
                      <option value="custom">سایر موارد</option>
                    </select>
                  </label>
                  <label class="grid gap-2 text-sm font-medium text-slate-700">
                    <span>آدرس سایت فعلی یا نمونه (اختیاری)</span>
                    <input type="url" name="website_url" class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100" placeholder="https://example.com" />
                  </label>
                  <label class="grid gap-2 text-sm font-medium text-slate-700">
                    <span>توضیحات کامل پروژه</span>
                    <textarea name="project_details" rows="6" required class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100" placeholder="اهداف، امکانات مورد نیاز، مخاطبان هدف و هر نکته مهم دیگر را بنویسید"></textarea>
                  </label>
                  <div class="grid gap-2 text-sm font-medium text-slate-700">
                    <span>امکانات مورد نیاز (انتخاب چندگانه)</span>
                    <div class="grid grid-cols-2 gap-3 mt-2">
                      <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="features[]" value="responsive" class="h-4 w-4 rounded border-slate-300 text-pink-600 focus:ring-pink-500">
                        طراحی واکنش‌گرا
                      </label>
                      <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="features[]" value="seo" class="h-4 w-4 rounded border-slate-300 text-pink-600 focus:ring-pink-500">
                        سئو بهینه
                      </label>
                      <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="features[]" value="multilingual" class="h-4 w-4 rounded border-slate-300 text-pink-600 focus:ring-pink-500">
                        چند زبانه
                      </label>
                      <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="features[]" value="analytics" class="h-4 w-4 rounded border-slate-300 text-pink-600 focus:ring-pink-500">
                        آنالیتیکس
                      </label>
                      <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="features[]" value="payment" class="h-4 w-4 rounded border-slate-300 text-pink-600 focus:ring-pink-500">
                        درگاه پرداخت
                      </label>
                      <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="features[]" value="admin" class="h-4 w-4 rounded border-slate-300 text-pink-600 focus:ring-pink-500">
                        پنل مدیریت
                      </label>
                    </div>
                  </div>
                </div>
                <div class="mt-6 flex justify-between">
                  <button type="button" class="prev-step-btn inline-flex justify-center rounded-2xl border border-slate-300 bg-white px-8 py-3.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">مرحله قبل</button>
                  <button type="button" class="next-step-btn inline-flex justify-center rounded-2xl bg-pink-600 px-8 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700">مرحله بعد</button>
                </div>
              </div>

              <!-- Step 3: Budget and Timeline -->
              <div class="form-step hidden" data-step="3">
                <h3 class="text-xl font-semibold text-slate-900 mb-4">بودجه و زمان‌بندی</h3>
                <div class="grid gap-6 sm:grid-cols-2">
                  <label class="grid gap-2 text-sm font-medium text-slate-700">
                    <span>بودجه تقریبی</span>
                    <select name="budget" required class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100">
                      <option value="">انتخاب کنید</option>
                      <option value="under_10m">کمتر از ۱۰ میلیون تومان</option>
                      <option value="10m_30m">۱۰ تا ۳۰ میلیون تومان</option>
                      <option value="30m_50m">۳۰ تا ۵۰ میلیون تومان</option>
                      <option value="50m_100m">۵۰ تا ۱۰۰ میلیون تومان</option>
                      <option value="over_100m">بیش از ۱۰۰ میلیون تومان</option>
                      <option value="flexible">انعطاف‌پذیر</option>
                    </select>
                  </label>
                  <label class="grid gap-2 text-sm font-medium text-slate-700">
                    <span>زمان‌بندی مورد انتظار</span>
                    <select name="timeline" required class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100">
                      <option value="">انتخاب کنید</option>
                      <option value="urgent">فوری (کمتر از ۱ ماه)</option>
                      <option value="1_3_months">۱ تا ۳ ماه</option>
                      <option value="3_6_months">۳ تا ۶ ماه</option>
                      <option value="6_12_months">۶ تا ۱۲ ماه</option>
                      <option value="flexible">انعطاف‌پذیر</option>
                    </select>
                  </label>
                </div>
                <label class="grid gap-2 text-sm font-medium text-slate-700 mt-6">
                  <span>سوالات اضافی یا توضیحات (اختیاری)</span>
                  <textarea name="additional_notes" rows="4" class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100" placeholder="هر نکته دیگری که فکر می‌کنید مهم است"></textarea>
                </label>
                <div class="mt-6">
                  <label class="flex items-start gap-3 text-sm text-slate-600">
                    <input type="checkbox" name="consent" required class="mt-1 h-4 w-4 rounded border-slate-300 text-pink-600 focus:ring-pink-500" />
                    <span>موافق دریافت پیگیری و مشاوره از طریق تماس یا ایمیل هستم و قوانین و مقررات را می‌پذیرم.</span>
                  </label>
                </div>
                <div class="mt-6 flex justify-between">
                  <button type="button" class="prev-step-btn inline-flex justify-center rounded-2xl border border-slate-300 bg-white px-8 py-3.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">مرحله قبل</button>
                  <button type="submit" class="inline-flex justify-center rounded-2xl bg-pink-600 px-8 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 disabled:opacity-50 disabled:cursor-not-allowed">ارسال درخواست</button>
                </div>
              </div>

              <div id="project-form-message" class="hidden rounded-xl p-4 text-sm"></div>
            </form>
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
