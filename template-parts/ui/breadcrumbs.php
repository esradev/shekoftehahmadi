<?php

if (! defined('ABSPATH')) {
  exit;
}

?>

<?php

$class = isset($args['class']) ? (string) $args['class'] : 'mb-6';

?>

<nav class="<?php echo esc_attr($class); ?> text-sm text-slate-500" aria-label="مسیر صفحه">
  <ol class="flex flex-wrap items-center gap-2">
    <li><a href="<?php echo esc_url(home_url('/')); ?>" class="transition hover:text-blue-700">خانه</a></li>
    <li class="text-slate-300">/</li>
    <li class="text-slate-700"><?php echo esc_html(isset($args['current']) ? $args['current'] : get_the_title()); ?></li>
  </ol>
</nav>
