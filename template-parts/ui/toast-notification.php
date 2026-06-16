<?php

if (! defined('ABSPATH')) {
  exit;
}

$notice_attr   = $args['notice_attr'] ?? 'data-romonet-toast';
$close_attr    = $args['close_attr'] ?? 'data-romonet-toast-close';
$message       = $args['message'] ?? '';
$actions       = $args['actions'] ?? array();
$variant       = $args['variant'] ?? 'default';
$variant_class = $variant === 'success' ? 'ring-green-200' : 'ring-slate-200';
?>

<div <?php echo esc_attr($notice_attr); ?> class="pointer-events-none fixed left-6 bottom-6 z-50 hidden" role="status" aria-live="polite">
  <div class="pointer-events-auto max-w-sm rounded-3xl bg-white p-6 ring-1 <?php echo esc_attr($variant_class); ?> shadow-lg" data-romonet-toast-panel>
    <div class="flex items-start justify-between gap-4">
      <div class="min-w-0">
        <p data-romonet-toast-message class="text-sm leading-6 text-slate-900"><?php echo esc_html($message); ?></p>
        <div data-romonet-toast-tracking class="<?php echo $message ? 'mt-3' : ''; ?> hidden rounded-2xl bg-slate-50 px-4 py-3">
          <p class="text-xs font-medium text-slate-500">کد پیگیری</p>
          <p data-romonet-toast-tracking-code class="mt-1 font-mono text-sm font-semibold tracking-wide text-slate-900" dir="ltr"></p>
        </div>
        <?php if (! empty($actions)) : ?>
          <div data-romonet-toast-actions class="mt-4 flex flex-wrap gap-3">
            <?php foreach ($actions as $action) : ?>
              <?php
              $label   = $action['label'] ?? '';
              $url     = $action['url'] ?? '';
              $primary = ! empty($action['primary']);
              $classes = $primary
                ? 'rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800'
                : 'rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-100';
              ?>
              <a href="<?php echo esc_url($url); ?>" class="<?php echo esc_attr($classes); ?>"><?php echo esc_html($label); ?></a>
            <?php endforeach; ?>
          </div>
        <?php else : ?>
          <div data-romonet-toast-actions class="mt-4 hidden flex-wrap gap-3"></div>
        <?php endif; ?>
      </div>
      <button type="button" <?php echo esc_attr($close_attr); ?> class="shrink-0 text-xl leading-none text-slate-400 hover:text-slate-600" aria-label="بستن">×</button>
    </div>
  </div>
</div>
