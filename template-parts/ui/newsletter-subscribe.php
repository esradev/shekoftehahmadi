<?php

/**
 * Newsletter subscribe form template part.
 *
 * @package Romonet
 *
 * Args:
 * - fields (string)      'email', 'phone', or 'both'. Default 'email'.
 * - title (string)       Section heading.
 * - description (string) Short description below the heading.
 * - layout (string)      'inline' or 'stacked'. Default 'inline'.
 * - form_id (string)     Form element ID.
 * - source (string)      Submission source identifier for admin tracking.
 * - show_consent (bool)  Whether to show consent checkbox. Default true.
 * - class (string)       Extra wrapper classes.
 */

if (! defined('ABSPATH')) {
  exit;
}

$args = isset($args) && is_array($args) ? $args : array();

$fields = $args['fields'] ?? 'email';

if (! in_array($fields, array('email', 'phone', 'both'), true)) {
  $fields = 'email';
}

$title         = $args['title'] ?? 'عضویت در خبرنامه';
$description   = $args['description'] ?? 'از آخرین مقالات، آموزش‌ها و پیشنهادهای ویژه باخبر شوید.';
$layout        = $args['layout'] ?? 'inline';
$form_id       = $args['form_id'] ?? 'newsletter-subscribe-form';
$source        = $args['source'] ?? 'footer';
$show_consent  = array_key_exists('show_consent', $args) ? (bool) $args['show_consent'] : true;
$wrapper_class = $args['class'] ?? '';

$show_email = $fields === 'email' || $fields === 'both';
$show_phone = $fields === 'phone' || $fields === 'both';

$input_class = 'w-full rounded-xl border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 outline-none transition focus:border-pink-400 focus:bg-white/15 focus:ring-4 focus:ring-pink-500/20';
$form_class  = $layout === 'inline'
  ? 'mt-6 flex flex-col gap-3 lg:flex-row lg:items-end'
  : 'mt-6 grid gap-3';
$fields_class = $layout === 'inline'
  ? 'flex flex-1 flex-col gap-3 sm:flex-row'
  : 'grid gap-3';
?>

<div class="newsletter-subscribe <?php echo esc_attr($wrapper_class); ?>" data-newsletter-fields="<?php echo esc_attr($fields); ?>">
  <?php if ($title) : ?>
    <h3 class="text-lg font-bold text-white sm:text-xl"><?php echo esc_html($title); ?></h3>
  <?php endif; ?>

  <?php if ($description) : ?>
    <p class="mt-2 max-w-xl text-sm leading-7 text-slate-400"><?php echo esc_html($description); ?></p>
  <?php endif; ?>

  <form
    id="<?php echo esc_attr($form_id); ?>"
    class="<?php echo esc_attr($form_class); ?>"
    data-form-type="newsletter"
    data-newsletter-source="<?php echo esc_attr($source); ?>"
    novalidate
  >
    <input type="hidden" name="fields_mode" value="<?php echo esc_attr($fields); ?>">
    <input type="hidden" name="source" value="<?php echo esc_attr($source); ?>">

    <div class="<?php echo esc_attr($fields_class); ?>">
      <?php if ($show_email) : ?>
        <label class="grid flex-1 gap-2 text-sm font-medium text-slate-300">
          <span class="sr-only">ایمیل</span>
          <input
            type="email"
            name="email"
            <?php echo $show_email && ! $show_phone ? 'required' : ''; ?>
            class="<?php echo esc_attr($input_class); ?>"
            placeholder="ایمیل شما"
            autocomplete="email"
            dir="ltr"
          >
        </label>
      <?php endif; ?>

      <?php if ($show_phone) : ?>
        <label class="grid flex-1 gap-2 text-sm font-medium text-slate-300">
          <span class="sr-only">شماره تماس</span>
          <input
            type="tel"
            name="phone"
            <?php echo $show_phone && ! $show_email ? 'required' : ''; ?>
            class="<?php echo esc_attr($input_class); ?>"
            placeholder="شماره موبایل"
            autocomplete="tel"
            dir="ltr"
          >
        </label>
      <?php endif; ?>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
      <?php if ($show_consent) : ?>
        <label class="flex flex-1 items-start gap-2 text-xs leading-6 text-slate-400 sm:max-w-xs">
          <input
            type="checkbox"
            name="consent"
            required
            class="mt-0.5 h-4 w-4 shrink-0 rounded border-white/20 bg-white/10 text-pink-500 focus:ring-pink-500/30"
          >
          <span>با دریافت خبرنامه و پیام‌های اطلاع‌رسانی موافقم.</span>
        </label>
      <?php endif; ?>

      <button
        type="submit"
        class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-pink-600/20 transition hover:bg-pink-500 disabled:cursor-not-allowed disabled:opacity-60"
      >
        <span data-newsletter-submit-label>عضویت</span>
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
        </svg>
      </button>
    </div>

    <div
      id="<?php echo esc_attr($form_id); ?>-message"
      class="hidden rounded-xl px-4 py-3 text-sm"
      role="status"
      aria-live="polite"
    ></div>
  </form>
</div>
