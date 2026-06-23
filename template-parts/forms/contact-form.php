<?php

if (! defined('ABSPATH')) {
  exit;
}

?>

<form id="contact-form" class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-7 shadow-sm sm:p-8" data-form-type="academic-contact">
  <div class="grid gap-4 sm:grid-cols-2">
    <label class="grid gap-2 text-sm font-medium text-slate-700">
      <span>نام و نام خانوادگی هنرجو</span>
      <input type="text" name="name" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="مثلاً: علی رضایی">
    </label>
    <label class="grid gap-2 text-sm font-medium text-slate-700">
      <span>شماره تماس</span>
      <input type="tel" name="phone" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="0912 123 4567">
    </label>
  </div>

  <div class="grid gap-4 sm:grid-cols-2">
    <label class="grid gap-2 text-sm font-medium text-slate-700">
      <span>ایمیل</span>
      <input type="email" name="email" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="name@example.com">
    </label>
    <label class="grid gap-2 text-sm font-medium text-slate-700">
      <span>دوره آموزشی مدنظر (اختیاری)</span>
      <input type="text" name="course" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="مثلاً: آموزش جامع فتوشاپ، طراحی UI/UX">
    </label>
  </div>

  <label class="grid gap-2 text-sm font-medium text-slate-700">
    <span>موضوع پیام</span>
    <select name="subject" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
      <option value="">لطفاً یک مورد را انتخاب کنید</option>
      <option value="course_consultation">مشاوره پیش از ثبت‌نام و تعیین سطح</option>
      <option value="student_support">پشتیبانی دوره‌ها و رفع اشکال تمرین‌ها</option>
      <option value="certificate">امور مربوط به دریافت گواهینامه و مدرک</option>
      <option value="teaching_request">درخواست همکاری به عنوان مدرس</option>
      <option value="other">سایر موارد</option>
    </select>
  </label>

  <label class="grid gap-2 text-sm font-medium text-slate-700">
    <span>لینک پورتفولیو یا نمونه‌کارها (برای ارزیابی سطح - اختیاری)</span>
    <input type="url" name="portfolio" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="آدرس لینک Dribbble, Behance یا گوگل درایو">
  </label>

  <label class="grid gap-2 text-sm font-medium text-slate-700">
    <span>پیام شما</span>
    <textarea name="message" rows="5" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="سوالات خود درباره پیش‌نیازهای دوره‌، هدف یادگیری یا مشکلات مربوط به پروژه‌ها را بنویسید..."></textarea>
  </label>

  <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
    <label class="flex items-center gap-3 text-sm text-slate-600">
      <input type="checkbox" name="consent" required class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
      <span>با تماس مشاوران آموزشی آکادمی جهت راهنمایی موافقم</span>
    </label>
    <button type="submit" class="rounded-xl bg-indigo-600 px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed">ارسال پیام</button>
  </div>

  <div id="contact-form-message" class="hidden rounded-xl p-4 text-sm"></div>
</form>
