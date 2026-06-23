<?php

if (! defined('ABSPATH')) {
  exit;
}

?>

<form id="contact-form" class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-7 shadow-sm sm:p-8" data-form-type="contact">
  <div class="grid gap-4 sm:grid-cols-2">
    <label class="grid gap-2 text-sm font-medium text-slate-700">
      <span>نام و نام خانوادگی</span>
      <input type="text" name="name" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100" placeholder="مثلاً: علی رضایی">
    </label>
    <label class="grid gap-2 text-sm font-medium text-slate-700">
      <span>شماره تماس</span>
      <input type="tel" name="phone" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100" placeholder="0912 123 4567">
    </label>
  </div>
  <label class="grid gap-2 text-sm font-medium text-slate-700">
    <span>ایمیل</span>
    <input type="email" name="email" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100" placeholder="name@example.com">
  </label>
  <label class="grid gap-2 text-sm font-medium text-slate-700">
    <span>نام شرکت (اختیاری)</span>
    <input type="text" name="company" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100" placeholder="نام شرکت یا سازمان">
  </label>
  <label class="grid gap-2 text-sm font-medium text-slate-700">
    <span>موضوع</span>
    <select name="subject" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100">
      <option value="">انتخاب کنید</option>
      <option value="consultation">مشاوره رایگان</option>
      <option value="quote">درخواست قیمت</option>
      <option value="support">پشتیبانی فنی</option>
      <option value="partnership">همکاری</option>
      <option value="other">سایر موارد</option>
    </select>
  </label>
  <label class="grid gap-2 text-sm font-medium text-slate-700">
    <span>پیام شما</span>
    <textarea name="message" rows="5" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-pink-500 focus:ring-4 focus:ring-pink-100" placeholder="نیازها، زمان‌بندی و اهداف پروژه را بنویسید"></textarea>
  </label>
  <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
    <label class="flex items-center gap-3 text-sm text-slate-600">
      <input type="checkbox" name="consent" required class="h-4 w-4 rounded border-slate-300 text-pink-600 focus:ring-pink-500">
      <span>با تماس کارشناسان ما موافقم</span>
    </label>
    <button type="submit" class="rounded-xl bg-pink-600 px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 disabled:opacity-50 disabled:cursor-not-allowed">ارسال درخواست</button>
  </div>
  <div id="contact-form-message" class="hidden rounded-xl p-4 text-sm"></div>
</form>
