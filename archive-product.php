<?php

get_header();

$hero_badge       = 'فروشگاه دیجیتال';
$hero_title       = 'محصولات و افزونه‌های آماده';
$hero_description = 'قالب‌ها، افزونه‌های المنتور و کروکوبلاک، اسکریپت‌ها و ابزارهای اختصاصی رومونت — با قیمت شفاف به تومان و تحویل فوری.';
$hero_current     = 'محصولات';

if (function_exists('is_product_category') && is_product_category()) {
  $term = get_queried_object();
  if ($term instanceof WP_Term) {
    $hero_badge       = 'دسته‌بندی محصول';
    $hero_title       = $term->name;
    $hero_description = $term->description ? wp_trim_words(wp_strip_all_tags($term->description), 28) : $hero_description;
    $hero_current     = $term->name;
  }
} elseif (function_exists('is_product_tag') && is_product_tag()) {
  $term = get_queried_object();
  if ($term instanceof WP_Term) {
    $hero_badge       = 'برچسب محصول';
    $hero_title       = $term->name;
    $hero_description = $term->description ? wp_trim_words(wp_strip_all_tags($term->description), 28) : $hero_description;
    $hero_current     = $term->name;
  }
}

$active_type    = function_exists('romonet_get_active_digital_type_filter') ? romonet_get_active_digital_type_filter() : '';
$type_labels_fa = function_exists('romonet_get_digital_product_type_labels_fa') ? romonet_get_digital_product_type_labels_fa() : array();
$shop_url       = function_exists('romonet_get_product_archive_base_url') ? romonet_get_product_archive_base_url() : home_url('/shop/');
$found_posts    = $GLOBALS['wp_query']->found_posts;
$search_query   = get_search_query();
$product_cats   = function_exists('get_terms') ? get_terms(array(
  'taxonomy'   => 'product_cat',
  'hide_empty' => true,
  'orderby'    => 'name',
  'order'      => 'ASC',
)) : array();

if (is_wp_error($product_cats)) {
  $product_cats = array();
}

$current_cat_id = 0;
if (function_exists('is_product_category') && is_product_category()) {
  $queried_term = get_queried_object();
  if ($queried_term instanceof WP_Term) {
    $current_cat_id = (int) $queried_term->term_id;
  }
}

$type_counts = array();
foreach (array_keys($type_labels_fa) as $type_key) {
  $count_query = new WP_Query(array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'fields'         => 'ids',
    'meta_query'     => array(
      array(
        'key'     => '_romonet_digital_product_type',
        'value'   => $type_key,
        'compare' => '=',
      ),
    ),
  ));
  $type_counts[$type_key] = (int) $count_query->found_posts;
  wp_reset_postdata();
}
?>

<main class="bg-slate-50 text-slate-900 antialiased">
  <?php
  get_template_part(
    'template-parts/sections/page-hero',
    null,
    array(
      'current'     => $hero_current,
      'badge'       => $hero_badge,
      'title'       => $hero_title,
      'description' => $hero_description,
      'primary'     => 'مشاوره رایگان',
      'primary_url' => home_url('/contact/'),
    )
  );
  ?>

  <section class="border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-pink-100 bg-pink-50/60 px-5 py-4">
          <p class="text-2xl font-black text-pink-700"><?php echo esc_html($found_posts); ?></p>
          <p class="mt-1 text-sm text-slate-600">محصول در این نمایش</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4">
          <p class="text-2xl font-black text-slate-900"><?php echo esc_html(count($product_cats)); ?></p>
          <p class="mt-1 text-sm text-slate-600">دسته‌بندی فعال</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4">
          <p class="text-2xl font-black text-slate-900">تومان</p>
          <p class="mt-1 text-sm text-slate-600">ارز فروشگاه — قیمت شفاف</p>
        </div>
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/60 px-5 py-4">
          <p class="text-2xl font-black text-emerald-700">فوری</p>
          <p class="mt-1 text-sm text-slate-600">تحویل دیجیتال پس از پرداخت</p>
        </div>
      </div>
    </div>
  </section>

  <section class="py-16 lg:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="grid gap-10 lg:grid-cols-[1fr_300px]">
        <div class="space-y-8">
          <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-col gap-5">
              <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm font-bold text-slate-900">فیلتر بر اساس نوع محصول</p>
                  <p class="mt-1 text-sm text-slate-600">
                    <?php
                    if ($active_type && isset($type_labels_fa[$active_type])) {
                      echo esc_html(sprintf('نمایش %1$s — %2$d محصول', $type_labels_fa[$active_type], $found_posts));
                    } else {
                      echo esc_html(sprintf('%d محصول یافت شد', $found_posts));
                    }
                    ?>
                  </p>
                </div>
                <?php if ($search_query) : ?>
                  <p class="text-sm text-pink-700">جستجو: «<?php echo esc_html($search_query); ?>»</p>
                <?php endif; ?>
              </div>

              <div class="flex flex-wrap gap-2">
                <?php
                $all_active = '' === $active_type;
                $all_classes = $all_active
                  ? 'bg-pink-600 text-white shadow-md shadow-pink-200'
                  : 'border border-slate-200 bg-white text-slate-700 hover:border-pink-200 hover:bg-pink-50 hover:text-pink-700';
                ?>
                <a href="<?php echo esc_url(function_exists('romonet_get_product_archive_filter_url') ? romonet_get_product_archive_filter_url(array('digital_type' => '')) : $shop_url); ?>" class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold transition <?php echo esc_attr($all_classes); ?>">
                  همه
                </a>

                <?php foreach ($type_labels_fa as $type_key => $type_label) : ?>
                  <?php
                  $is_active = $active_type === $type_key;
                  $chip_classes = $is_active
                    ? 'bg-pink-600 text-white shadow-md shadow-pink-200'
                    : 'border border-slate-200 bg-white text-slate-700 hover:border-pink-200 hover:bg-pink-50 hover:text-pink-700';
                  $type_count = isset($type_counts[$type_key]) ? $type_counts[$type_key] : 0;
                  ?>
                  <a href="<?php echo esc_url(function_exists('romonet_get_product_archive_filter_url') ? romonet_get_product_archive_filter_url(array('digital_type' => $type_key)) : add_query_arg('digital_type', $type_key, $shop_url)); ?>" class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold transition <?php echo esc_attr($chip_classes); ?>">
                    <?php echo esc_html($type_label); ?>
                    <span class="text-xs opacity-75">(<?php echo esc_html($type_count); ?>)</span>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <?php if (have_posts()) : ?>
            <div class="grid gap-6 md:grid-cols-2">
              <?php while (have_posts()) : the_post(); ?>
                <?php
                $card_args = function_exists('romonet_get_product_card_args')
                  ? romonet_get_product_card_args(get_the_ID())
                  : array();

                if (! empty($card_args)) {
                  get_template_part('template-parts/cards/product-card', null, $card_args);
                }
                ?>
              <?php endwhile; ?>
            </div>

            <div class="mt-12"><?php get_template_part('template-parts/ui/pagination'); ?></div>
          <?php else : ?>
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center">
              <p class="text-lg font-bold text-slate-900">محصولی یافت نشد</p>
              <p class="mt-2 text-sm text-slate-600">فیلتر دیگری امتحان کنید یا با تیم رومونت برای پیشنهاد اختصاصی تماس بگیرید.</p>
              <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mt-6 inline-flex items-center justify-center rounded-full bg-pink-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-pink-500">مشاوره رایگان</a>
            </div>
          <?php endif; ?>
        </div>

        <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">جستجو در محصولات</h2>
            <form role="search" method="get" action="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="mt-4">
              <label for="product-sidebar-search" class="sr-only">جستجو</label>
              <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-3">
                <input id="product-sidebar-search" type="search" name="s" value="<?php echo esc_attr($search_query); ?>" placeholder="نام محصول، افزونه یا کلیدواژه..." class="w-full bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400" />
                <input type="hidden" name="post_type" value="product" />
                <?php if ($active_type) : ?>
                  <input type="hidden" name="digital_type" value="<?php echo esc_attr($active_type); ?>" />
                <?php endif; ?>
                <button type="submit" class="shrink-0 rounded-xl bg-pink-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-pink-500">جستجو</button>
              </div>
            </form>
          </div>

          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">دسته‌بندی‌ها</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
              <?php
              $all_shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
              if ($active_type) {
                $all_shop_url = add_query_arg('digital_type', $active_type, $all_shop_url);
              }
              ?>
              <li>
                <a href="<?php echo esc_url($all_shop_url); ?>" class="<?php echo 0 === $current_cat_id ? 'font-semibold text-pink-700' : 'transition hover:text-pink-700'; ?>">
                  همه محصولات
                </a>
              </li>

              <?php if (! empty($product_cats)) : ?>
                <?php foreach ($product_cats as $product_cat) : ?>
                  <?php
                  $cat_link = get_term_link($product_cat);
                  if (is_wp_error($cat_link)) {
                    continue;
                  }
                  if ($active_type) {
                    $cat_link = add_query_arg('digital_type', $active_type, $cat_link);
                  }
                  $is_current = $current_cat_id === (int) $product_cat->term_id;
                  ?>
                  <li>
                    <a href="<?php echo esc_url($cat_link); ?>" class="<?php echo $is_current ? 'font-semibold text-pink-700' : 'transition hover:text-pink-700'; ?>">
                      <?php echo esc_html($product_cat->name); ?>
                      <span class="text-slate-400">(<?php echo esc_html($product_cat->count); ?>)</span>
                    </a>
                  </li>
                <?php endforeach; ?>
              <?php else : ?>
                <li class="text-slate-500">دسته‌ای موجود نیست.</li>
              <?php endif; ?>
            </ul>
          </div>

          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">نوع محصول</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
              <?php foreach ($type_labels_fa as $type_key => $type_label) : ?>
                <?php
                $type_url = function_exists('romonet_get_product_archive_filter_url')
                  ? romonet_get_product_archive_filter_url(array('digital_type' => $type_key))
                  : add_query_arg('digital_type', $type_key, $shop_url);
                $is_current_type = $active_type === $type_key;
                $type_count = isset($type_counts[$type_key]) ? $type_counts[$type_key] : 0;
                ?>
                <li>
                  <a href="<?php echo esc_url($type_url); ?>" class="flex items-center justify-between <?php echo $is_current_type ? 'font-semibold text-pink-700' : 'transition hover:text-pink-700'; ?>">
                    <span><?php echo esc_html($type_label); ?></span>
                    <span class="text-slate-400"><?php echo esc_html($type_count); ?></span>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <div class="rounded-2xl border border-pink-100 bg-linear-to-br from-pink-50 to-indigo-50 p-6">
            <h2 class="text-lg font-bold text-slate-900">در انتخاب مردد هستید؟</h2>
            <p class="mt-3 text-sm leading-7 text-slate-600">نیاز پروژه خود را بگویید تا مناسب‌ترین قالب، افزونه المنتور یا بسته کروکوبلاک را پیشنهاد دهیم.</p>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-pink-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-pink-500">
              مشاوره رایگان
            </a>
          </div>
        </aside>
      </div>

      <div class="mt-16">
        <?php get_template_part('template-parts/sections/cta', null, array(
          'title' => 'برای انتخاب محصول مطمئن نیستید؟',
          'text'  => 'نیازتان را بگویید تا بهترین گزینه — از Elementor Pro تا قالب اختصاصی — را پیشنهاد کنیم.',
        )); ?>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
