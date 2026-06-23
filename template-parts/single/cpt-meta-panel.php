<?php

if (! defined('ABSPATH')) {
  exit;
}

$variant         = isset($args['variant']) ? sanitize_key($args['variant']) : 'portfolio';
$title           = isset($args['title']) ? $args['title'] : 'جزئیات';
$subtitle        = isset($args['subtitle']) ? $args['subtitle'] : '';
$highlight       = isset($args['highlight']) ? $args['highlight'] : '';
$highlight_label = isset($args['highlight_label']) ? $args['highlight_label'] : '';
$badge           = isset($args['badge']) ? $args['badge'] : '';
$items           = isset($args['items']) && is_array($args['items']) ? $args['items'] : array();
$tags            = isset($args['tags']) && is_array($args['tags']) ? $args['tags'] : array();
$steps           = isset($args['steps']) && is_array($args['steps']) ? $args['steps'] : array();
$external_url    = isset($args['external_url']) ? $args['external_url'] : '';
$external_label  = isset($args['external_label']) ? $args['external_label'] : 'مشاهده وبسایت پروژه';
$primary_cta     = isset($args['primary_cta']) ? $args['primary_cta'] : 'ثبت درخواست پروژه';
$primary_url     = isset($args['primary_url']) ? $args['primary_url'] : home_url('/project-request/');
$secondary_cta   = isset($args['secondary_cta']) ? $args['secondary_cta'] : 'مشاوره رایگان';
$secondary_url   = isset($args['secondary_url']) ? $args['secondary_url'] : home_url('/contact/');
$archive_url     = isset($args['archive_url']) ? $args['archive_url'] : '';
$archive_label   = isset($args['archive_label']) ? $args['archive_label'] : '';

$accent_map = array(
  'portfolio'  => array('header' => 'from-slate-900 via-slate-800 to-pink-900', 'ring' => 'ring-pink-500/20', 'glow' => 'shadow-pink-900/20', 'chip' => 'bg-pink-500/20 text-pink-100'),
  'case_study' => array('header' => 'from-emerald-900 via-teal-900 to-slate-900', 'ring' => 'ring-emerald-500/20', 'glow' => 'shadow-emerald-900/20', 'chip' => 'bg-emerald-500/20 text-emerald-100'),
  'service'    => array('header' => 'from-pink-700 via-pink-600 to-cyan-700', 'ring' => 'ring-cyan-500/20', 'glow' => 'shadow-pink-900/25', 'chip' => 'bg-white/15 text-white'),
  'book'       => array('header' => 'from-violet-900 via-pink-900 to-cyan-800', 'ring' => 'ring-violet-500/20', 'glow' => 'shadow-violet-900/25', 'chip' => 'bg-violet-500/20 text-violet-100'),
);
$accent = isset($accent_map[$variant]) ? $accent_map[$variant] : $accent_map['portfolio'];

$icon_map = array(
  'مشتری'       => '<path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/>',
  'آدرس سایت'   => '<circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
  'وبسایت پروژه' => '<circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
  'فناوری‌ها'   => '<path d="m12 3 1.9 5.8H20l-4.8 3.5 1.9 5.7L12 14.8 6.9 18l1.9-5.7L4 8.8h6.1z"/>',
  'مدت پروژه'   => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
  'مدت زمان'    => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
  'مدت انجام'   => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
  'تاریخ تکمیل' => '<rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
  'تکمیل شده در' => '<rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
  'صنعت هدف'    => '<path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 21v-6h6v6"/>',
  'بازه قیمت'   => '<path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"/>',
  'نویسنده'      => '<path d="M7 4h10a2 2 0 0 1 2 2v14l-7-3-7 3V6a2 2 0 0 1 2-2z"/>',
  'ناشر'        => '<path d="M3 21h18"/><path d="M4 21V7l8-4 8 4v14"/><path d="M12 9v12"/>',
  'سال انتشار'   => '<rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
  'تعداد صفحات'  => '<path d="M6 4h10a2 2 0 0 1 2 2v14a1 1 0 0 1-1.5.86L12 18l-4.5 2.86A1 1 0 0 1 6 20V4z"/>',
  'فرمت فایل'    => '<path d="M14 2H6a2 2 0 0 0-2 2v16l4-2 4 2 4-2 4 2V8z"/><path d="M14 2v6h6"/>',
  'زبان'        => '<path d="M4 5h12"/><path d="M10 5c0 7-2 11-6 13"/><path d="M8 11h6"/><path d="m16 19 4-9 4 9"/><path d="M18 16h4"/>',
  'شابک'        => '<rect width="18" height="14" x="3" y="5" rx="2"/><path d="M7 9h2M7 13h10"/>',
  'سطح مطالعه'   => '<path d="M4 18h16"/><path d="M7 18V9l5-3 5 3v9"/><path d="M10 13h4"/>',
  'نوع دسترسی'   => '<rect width="18" height="12" x="3" y="8" rx="2"/><path d="M8 8V6a4 4 0 0 1 8 0v2"/>',
);
$default_icon = '<circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>';

$visible_items = array_filter(
  $items,
  static function ($item) {
    return ! empty($item['label']) && ! empty($item['value']);
  }
);

if (empty($visible_items) && ! $highlight && empty($tags) && empty($steps)) {
  return;
}

?>

<div class="lg:sticky lg:top-28 lg:z-10 lg:self-start">
  <aside class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl <?php echo esc_attr($accent['glow']); ?>">
    <div class="relative overflow-hidden bg-linear-to-br <?php echo esc_attr($accent['header']); ?> px-6 pb-8 pt-6 text-white">
      <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgb(255_255_255/0.12)_1px,transparent_0)] bg-size-[18px_18px]" aria-hidden="true"></div>
      <div class="pointer-events-none absolute -end-8 -top-8 h-32 w-32 rounded-full bg-white/10 blur-2xl" aria-hidden="true"></div>

      <div class="relative">
        <?php if ($badge) : ?>
          <span class="mb-4 inline-flex rounded-full <?php echo esc_attr($accent['chip']); ?> px-3 py-1 text-xs font-bold backdrop-blur-sm"><?php echo esc_html($badge); ?></span>
        <?php endif; ?>

        <p class="text-xs font-bold uppercase tracking-[0.25em] text-white/70"><?php echo esc_html($title); ?></p>

        <?php if ($subtitle) : ?>
          <h2 class="mt-2 text-lg font-bold leading-8 text-white"><?php echo esc_html($subtitle); ?></h2>
        <?php endif; ?>

        <?php if ($highlight) : ?>
          <div class="mt-5 rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm">
            <?php if ($highlight_label) : ?>
              <p class="text-xs font-semibold text-white/75"><?php echo esc_html($highlight_label); ?></p>
            <?php endif; ?>
            <p class="mt-1 text-2xl font-extrabold tracking-tight text-white"><?php echo esc_html($highlight); ?></p>
          </div>
        <?php endif; ?>

        <?php if (! empty($tags)) : ?>
          <div class="mt-4 flex flex-wrap gap-2">
            <?php foreach ($tags as $tag) :
              $tag_name = is_object($tag) ? $tag->name : (string) $tag;
            ?>
              <span class="rounded-full border border-white/20 bg-white/10 px-2.5 py-1 text-xs font-semibold text-white/90"><?php echo esc_html($tag_name); ?></span>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="space-y-5 p-6">
      <?php if (! empty($visible_items)) : ?>
        <div class="grid gap-3">
          <?php foreach ($visible_items as $item) :
            $icon_path = isset($item['icon']) ? $item['icon'] : (isset($icon_map[$item['label']]) ? $icon_map[$item['label']] : $default_icon);
          ?>
            <div class="group flex gap-3 rounded-2xl border border-slate-100 bg-slate-50/80 p-4 transition hover:border-pink-100 hover:bg-pink-50/50">
              <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-pink-600 shadow-sm ring-1 ring-slate-200/80 transition group-hover:ring-pink-200">
                <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><?php echo $icon_path; ?></svg>
              </span>
              <div class="min-w-0 flex-1">
                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500"><?php echo esc_html($item['label']); ?></p>
                <?php if (! empty($item['url'])) : ?>
                  <a href="<?php echo esc_url($item['url']); ?>" target="_blank" rel="noreferrer noopener" class="mt-1 block truncate text-sm font-semibold text-pink-600 transition hover:text-pink-700" dir="ltr"><?php echo esc_html($item['value']); ?></a>
                <?php else : ?>
                  <p class="mt-1 text-sm font-semibold leading-7 text-slate-800"><?php echo esc_html($item['value']); ?></p>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if (! empty($steps)) : ?>
        <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
          <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">مراحل اجرا</p>
          <ol class="mt-3 space-y-2.5">
            <?php foreach (array_slice($steps, 0, 4) as $index => $step) : ?>
              <li class="flex items-start gap-2.5 text-sm text-slate-700">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-pink-600 text-[11px] font-bold text-white"><?php echo esc_html($index + 1); ?></span>
                <span class="leading-6"><?php echo esc_html($step); ?></span>
              </li>
            <?php endforeach; ?>
          </ol>
          <?php if (count($steps) > 4) : ?>
            <p class="mt-3 text-xs text-slate-500">+ <?php echo esc_html(count($steps) - 4); ?> مرحله دیگر در محتوای صفحه</p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <div class="space-y-2.5 pt-1">
        <?php if ($external_url) : ?>
          <a href="<?php echo esc_url($external_url); ?>" target="_blank" rel="noreferrer noopener" class="flex w-full items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-semibold text-slate-800 shadow-sm transition hover:border-pink-200 hover:bg-pink-50 hover:text-pink-700">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
            <?php echo esc_html($external_label); ?>
          </a>
        <?php endif; ?>

        <a href="<?php echo esc_url($primary_url); ?>" class="flex w-full items-center justify-center gap-2 rounded-2xl bg-pink-600 px-4 py-3.5 text-sm font-semibold text-white shadow-lg shadow-pink-600/25 transition hover:bg-pink-500">
          <?php echo esc_html($primary_cta); ?>
        </a>

        <a href="<?php echo esc_url($secondary_url); ?>" class="flex w-full items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-white">
          <?php echo esc_html($secondary_cta); ?>
        </a>
      </div>

      <?php if ($archive_url && $archive_label) : ?>
        <a href="<?php echo esc_url($archive_url); ?>" class="flex items-center justify-center gap-1.5 text-xs font-semibold text-slate-500 transition hover:text-pink-600">
          <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
          <?php echo esc_html($archive_label); ?>
        </a>
      <?php endif; ?>
    </div>
  </aside>
</div>
