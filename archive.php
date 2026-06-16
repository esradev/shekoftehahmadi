<?php

get_header();

$is_category = is_category();
$is_tag      = is_tag();
$archive_title = wp_strip_all_tags(get_the_archive_title());
$archive_desc  = wp_strip_all_tags(get_the_archive_description());
$blog_url      = get_permalink(get_option('page_for_posts')) ?: home_url('/');
$categories    = get_categories(array('hide_empty' => true));
?>

<main class="bg-slate-50 text-slate-900 antialiased">
  <?php
  get_template_part(
    'template-parts/sections/page-hero',
    null,
    array(
      'current'     => $archive_title,
      'badge'       => $is_tag ? __('Tag', 'romonet') : ($is_category ? __('Category', 'romonet') : __('Archive', 'romonet')),
      'title'       => $archive_title,
      'description' => $archive_desc ? wp_trim_words($archive_desc, 30) : __('Browse articles from our agency knowledge base.', 'romonet'),
    )
  );
  ?>

  <section class="py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <?php if (! empty($categories)) : ?>
        <div class="mb-10 flex flex-wrap gap-2">
          <a href="<?php echo esc_url($blog_url); ?>" class="inline-flex rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-blue-200 hover:text-blue-700">
            <?php esc_html_e('All topics', 'romonet'); ?>
          </a>
          <?php foreach ($categories as $category) : ?>
            <?php $is_active = $is_category && (int) get_queried_object_id() === (int) $category->term_id; ?>
            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="inline-flex rounded-full px-4 py-2 text-sm font-semibold transition <?php echo $is_active ? 'bg-blue-600 text-white' : 'border border-slate-200 bg-white text-slate-600 hover:border-blue-200 hover:text-blue-700'; ?>">
              <?php echo esc_html($category->name); ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div class="grid gap-10 lg:grid-cols-[1fr_320px]">
        <div class="space-y-8">
          <?php if (have_posts()) : ?>
            <div class="grid gap-8 md:grid-cols-2">
              <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/cards/post-card'); ?>
              <?php endwhile; ?>
            </div>
            <div class="pt-4"><?php get_template_part('template-parts/ui/pagination'); ?></div>
          <?php else : ?>
            <?php get_template_part('template-parts/content/content-none'); ?>
          <?php endif; ?>
        </div>

        <?php get_template_part('template-parts/sidebar/blog-sidebar'); ?>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
