<?php

get_header();
?>

<main class="bg-white text-slate-900 antialiased">
  <?php
  get_template_part(
    'template-parts/sections/page-hero',
    null,
    array(
      'show_breadcrumbs' => false,
      'badge'            => 'جستجو',
      'title'            => 'نتایج جستجو برای ' . get_search_query(),
      'current'          => 'جستجو',
    )
  );
  ?>

  <section class="py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <?php if (have_posts()) : ?>
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
          <?php while (have_posts()) : the_post(); ?>
            <article class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
              <h2 class="text-xl font-bold text-slate-900"><a href="<?php the_permalink(); ?>" class="transition hover:text-pink-700"><?php the_title(); ?></a></h2>
              <p class="mt-3 text-sm leading-7 text-slate-600"><?php echo esc_html(wp_trim_words(wp_strip_all_tags(get_the_excerpt() ? get_the_excerpt() : get_the_content()), 24)); ?></p>
            </article>
          <?php endwhile; ?>
        </div>
      <?php else : ?>
        <?php get_template_part('template-parts/content/content-none'); ?>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php
get_footer();
