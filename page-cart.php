<?php

/**
 * Cart page template for WooCommerce cart page.
 * This ensures the cart page uses the custom cart layout instead of the old default UI.
 */

get_header();
?>

<main class="bg-white text-slate-900 antialiased">
  <?php if (function_exists('is_cart') && is_cart()) : ?>
    <?php get_template_part('template-parts/sections/page-hero', null, array(
      'current'     => 'سبد خرید',
      'badge'       => 'سبد خرید',
      'title'       => 'سبد خرید شما',
      'description' => 'خلاصه سفارش‌های شما در این صفحه نمایش داده می‌شود. برای پرداخت نهایی یا ادامه خرید آماده شوید.',
    )); ?>

    <section class="py-20 lg:py-28">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <?php wc_get_template('cart/cart.php'); ?>
      </div>
    </section>
  <?php else : ?>
    <?php while (have_posts()) : the_post(); ?>
      <?php
      $desc = wp_trim_words(wp_strip_all_tags(get_the_excerpt() ? get_the_excerpt() : ''), 26);

      get_template_part(
        'template-parts/sections/page-hero',
        null,
        array(
          'current'     => get_the_title(),
          'badge'       => 'صفحه',
          'title'       => get_the_title(),
          'description' => $desc,
        )
      );
      ?>

      <section class="py-20 lg:py-28">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
          <article class="p-7 sm:p-10">
            <?php get_template_part('template-parts/content/content', null, array('show_title' => false)); ?>
          </article>
        </div>
      </section>
    <?php endwhile; ?>
  <?php endif; ?>
</main>

<?php get_footer();
