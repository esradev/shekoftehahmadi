<?php

if (! defined('ABSPATH')) {
  exit;
}

$post_type = isset($args['post_type']) ? sanitize_key($args['post_type']) : '';
$config    = function_exists('romonet_get_cpt_archive_config') ? romonet_get_cpt_archive_config($post_type) : array();

if (empty($config)) {
  return;
}

$archive_url   = $config['archive_url'];
$taxonomy      = $config['taxonomy'];
$secondary_taxonomy = isset($config['tech_taxonomy']) ? $config['tech_taxonomy'] : '';
$active_type        = function_exists('romonet_get_active_cpt_filter_slug') ? romonet_get_active_cpt_filter_slug($taxonomy) : '';
$active_secondary   = ($secondary_taxonomy && function_exists('romonet_get_active_cpt_filter_slug')) ? romonet_get_active_cpt_filter_slug($secondary_taxonomy) : '';
$search_value  = function_exists('romonet_get_cpt_search_query') ? romonet_get_cpt_search_query() : '';
$type_links    = function_exists('romonet_get_cpt_term_links') ? romonet_get_cpt_term_links($taxonomy, $archive_url, $active_type) : array();
$secondary_links = ($secondary_taxonomy && function_exists('romonet_get_cpt_term_links')) ? romonet_get_cpt_term_links($secondary_taxonomy, $archive_url, $active_secondary) : array();
$show_featured = in_array($post_type, array('portfolio', 'case_study', 'book'), true);
$show_highlight = 'service' === $post_type;
$is_featured   = ! empty($_GET['featured']);
$is_highlight  = ! empty($_GET['highlight']);
$has_filters   = $active_type || $active_secondary || $search_value || $is_featured || $is_highlight;
$featured_label = 'book' === $post_type ? 'کتاب‌های ویژه' : 'پروژه‌های ویژه';

$build_url = static function ($extra = array()) use ($archive_url, $taxonomy, $secondary_taxonomy, $active_type, $active_secondary, $search_value, $is_featured, $is_highlight) {
  $query = array();

  if ($active_type) {
    $query[$taxonomy] = $active_type;
  }
  if ($secondary_taxonomy && $active_secondary) {
    $query[$secondary_taxonomy] = $active_secondary;
  }
  if ($search_value) {
    $query['q'] = $search_value;
  }
  if ($is_featured) {
    $query['featured'] = '1';
  }
  if ($is_highlight) {
    $query['highlight'] = '1';
  }

  foreach ($extra as $key => $value) {
    if (null === $value) {
      unset($query[$key]);
    } else {
      $query[$key] = $value;
    }
  }

  return romonet_get_cpt_filter_url($archive_url, $query);
};

$all_terms_link_args = array(
  $taxonomy   => null,
  'featured'  => null,
  'highlight' => null,
);
if ($secondary_taxonomy) {
  $all_terms_link_args[$secondary_taxonomy] = null;
}

?>

<div class="mb-10 space-y-6">
  <form method="get" action="<?php echo esc_url($archive_url); ?>" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center">
      <label for="cpt-filter-search-<?php echo esc_attr($post_type); ?>" class="sr-only"><?php echo esc_html($config['search_label']); ?></label>
      <div class="flex flex-1 items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
        <svg class="h-5 w-5 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
          <circle cx="11" cy="11" r="7" />
          <path d="m20 20-3.5-3.5" />
        </svg>
        <input id="cpt-filter-search-<?php echo esc_attr($post_type); ?>" type="search" name="q" value="<?php echo esc_attr($search_value); ?>" placeholder="<?php echo esc_attr($config['search_label']); ?>" class="w-full bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400" />
      </div>

      <?php if ($active_type) : ?>
        <input type="hidden" name="<?php echo esc_attr($taxonomy); ?>" value="<?php echo esc_attr($active_type); ?>" />
      <?php endif; ?>
      <?php if ($secondary_taxonomy && $active_secondary) : ?>
        <input type="hidden" name="<?php echo esc_attr($secondary_taxonomy); ?>" value="<?php echo esc_attr($active_secondary); ?>" />
      <?php endif; ?>
      <?php if ($is_featured) : ?>
        <input type="hidden" name="featured" value="1" />
      <?php endif; ?>
      <?php if ($is_highlight) : ?>
        <input type="hidden" name="highlight" value="1" />
      <?php endif; ?>

      <div class="flex flex-wrap gap-2">
        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-pink-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-pink-500">جستجو</button>
        <?php if ($has_filters) : ?>
          <a href="<?php echo esc_url($archive_url); ?>" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">پاک کردن فیلترها</a>
        <?php endif; ?>
      </div>
    </div>
  </form>

  <?php if (! empty($type_links)) : ?>
    <div class="flex flex-wrap gap-2">
      <a href="<?php echo esc_url($build_url($all_terms_link_args)); ?>" class="inline-flex rounded-full px-4 py-2 text-sm font-semibold transition <?php echo ! $active_type ? 'bg-pink-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-600 hover:border-pink-200 hover:text-pink-700'; ?>">
        <?php echo esc_html($config['all_label']); ?>
      </a>
      <?php foreach ($type_links as $link) : ?>
        <a href="<?php echo esc_url($link['url']); ?>" class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold transition <?php echo $link['active'] ? 'bg-pink-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-600 hover:border-pink-200 hover:text-pink-700'; ?>">
          <?php echo esc_html($link['label']); ?>
          <span class="rounded-full px-2 py-0.5 text-xs <?php echo $link['active'] ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500'; ?>"><?php echo esc_html($link['count']); ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="flex flex-wrap items-center gap-2">
    <?php if ($show_featured) : ?>
      <a href="<?php echo esc_url($build_url(array('featured' => $is_featured ? null : '1'))); ?>" class="inline-flex rounded-full px-4 py-2 text-sm font-semibold transition <?php echo $is_featured ? 'bg-cyan-600 text-white' : 'border border-slate-200 bg-white text-slate-600 hover:border-cyan-200 hover:text-cyan-700'; ?>">
        <?php echo esc_html($featured_label); ?>
      </a>
    <?php endif; ?>

    <?php if ($show_highlight) : ?>
      <a href="<?php echo esc_url($build_url(array('highlight' => $is_highlight ? null : '1'))); ?>" class="inline-flex rounded-full px-4 py-2 text-sm font-semibold transition <?php echo $is_highlight ? 'bg-cyan-600 text-white' : 'border border-slate-200 bg-white text-slate-600 hover:border-cyan-200 hover:text-cyan-700'; ?>">
        خدمات پیشنهادی
      </a>
    <?php endif; ?>

    <?php if (! empty($secondary_links)) : ?>
      <?php foreach ($secondary_links as $link) : ?>
        <a href="<?php echo esc_url($link['url']); ?>" class="inline-flex rounded-full px-3.5 py-1.5 text-xs font-semibold transition <?php echo $link['active'] ? 'bg-slate-900 text-white' : 'border border-slate-200 bg-slate-50 text-slate-600 hover:border-slate-300 hover:text-slate-900'; ?>">
          <?php echo esc_html($link['label']); ?>
        </a>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
