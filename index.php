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
      'badge'            => 'مطالب',
      'title'            => 'آخرین مطالب',
      'description'      => 'نمایش آخرین نوشته‌ها و محتواهای سایت.',
      'current'          => 'مطالب',
    )
  );
  ?>

  <section class="py-20 lg:py-28">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
      <?php if (have_posts()) : ?>
        <div class="space-y-6">
          <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class('p-7'); ?>>
              <h2 class="text-2xl font-bold text-slate-900"><a href="<?php the_permalink(); ?>" class="transition hover:text-pink-700"><?php the_title(); ?></a></h2>
              <div class="prose prose-slate mt-4 max-w-none">
                <?php the_content(); ?>
              </div>
            </article>
          <?php endwhile; ?>
        </div>
        <div class="mt-12"><?php get_template_part('template-parts/ui/pagination'); ?></div>
      <?php else : ?>
        <?php get_template_part('template-parts/content/content-none'); ?>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php
get_footer();
