<?php

/**
 * Generic content template part.
 */

if (! defined('ABSPATH')) {
  exit;
}
?>

<?php

$show_title = isset($args['show_title']) ? (bool) $args['show_title'] : true;

?>

<article <?php post_class('prose prose-slate max-w-none'); ?>>
  <?php if ($show_title) : ?>
    <header class="mb-10">
      <?php the_title('<h1 class="text-balance text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">', '</h1>'); ?>
    </header>
  <?php endif; ?>

  <div class="space-y-6 text-[1.05rem] leading-8 text-slate-700">
    <?php the_content(); ?>
  </div>
</article>
