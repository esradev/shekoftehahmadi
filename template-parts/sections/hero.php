<?php

if (! defined('ABSPATH')) {
  exit;
}

$title          = isset($args['title']) ? $args['title'] : '';
$description    = isset($args['description']) ? $args['description'] : '';
$primary        = isset($args['primary']) ? $args['primary'] : 'درخواست مشاوره';
$primary_url    = isset($args['primary_url']) ? $args['primary_url'] : home_url('/contact/');
$secondary      = isset($args['secondary']) ? $args['secondary'] : 'مشاهده خدمات';
$secondary_url  = isset($args['secondary_url']) ? $args['secondary_url'] : home_url('/services/');

?>

<section class="relative overflow-hidden rounded-4xl bg-neutral-950 px-6 py-16 text-white sm:px-10 lg:px-16">
  <div class="absolute inset-0 opacity-30">
    <div class="absolute left-0 top-0 h-72 w-72 rounded-full bg-primary-500 blur-3xl"></div>
    <div class="absolute bottom-0 right-0 h-72 w-72 rounded-full bg-accent-500 blur-3xl"></div>
  </div>
  <div class="relative grid gap-12 lg:grid-cols-[1.2fr_.8fr] lg:items-center">
    <div class="space-y-6">
      <p class="text-sm font-medium uppercase tracking-[0.35em] text-primary-300">آژانس توسعه وردپرس</p>
      <h1 class="max-w-3xl text-4xl font-black leading-[1.1] sm:text-5xl lg:text-6xl"><?php echo esc_html($title); ?></h1>
      <p class="max-w-2xl text-lg leading-8 text-neutral-200"><?php echo esc_html($description); ?></p>
      <div class="flex flex-col gap-3 sm:flex-row">
        <a href="<?php echo esc_url($primary_url); ?>" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-neutral-950 transition hover:bg-primary-100"><?php echo esc_html($primary); ?></a>
        <a href="<?php echo esc_url($secondary_url); ?>" class="inline-flex items-center justify-center rounded-full border border-white/20 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10"><?php echo esc_html($secondary); ?></a>
      </div>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
      <div class="rounded-3xl bg-white/10 p-6 backdrop-blur">
        <div class="text-3xl font-black">۱۲+</div>
        <p class="mt-2 text-sm leading-7 text-neutral-200">سال تجربه در توسعه سایت‌های حرفه‌ای و مقیاس‌پذیر</p>
      </div>
      <div class="rounded-3xl bg-white/10 p-6 backdrop-blur">
        <div class="text-3xl font-black">۹۸٪</div>
        <p class="mt-2 text-sm leading-7 text-neutral-200">رضایت مشتریان از سرعت تحویل و کیفیت پشتیبانی</p>
      </div>
      <div class="rounded-3xl bg-white/10 p-6 backdrop-blur sm:col-span-2">
        <div class="text-3xl font-black">۲۰۰+</div>
        <p class="mt-2 text-sm leading-7 text-neutral-200">پروژهٔ طراحی، توسعه قالب، افزونه و ووکامرس</p>
      </div>
    </div>
  </div>
</section>
