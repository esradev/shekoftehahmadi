<?php

if (! defined('ABSPATH')) {
  exit;
}

$quote = isset($args['quote']) ? $args['quote'] : '';
$name  = isset($args['name']) ? $args['name'] : '';
$role  = isset($args['role']) ? $args['role'] : '';

?>

<blockquote class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
  <div class="mb-4 flex gap-1 text-accent-500" aria-hidden="true">★★★★★</div>
  <p class="text-sm leading-8 text-neutral-700"><?php echo esc_html($quote); ?></p>
  <footer class="mt-5">
    <div class="font-semibold text-neutral-900"><?php echo esc_html($name); ?></div>
    <div class="text-xs text-neutral-500"><?php echo esc_html($role); ?></div>
  </footer>
</blockquote>
