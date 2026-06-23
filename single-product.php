<?php

get_header();
?>

<main class="bg-slate-50 text-slate-900 antialiased">
  <?php while (have_posts()) : the_post(); ?>
    <?php
    $product_id = get_the_ID();
    $product = function_exists('wc_get_product') ? wc_get_product($product_id) : null;

    if (! $product) :
    ?>
      <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-white p-8 shadow-sm">
          <?php the_content(); ?>
        </div>
      </section>
      <?php
      continue;
    endif;

    do_action('woocommerce_before_single_product');

    if (post_password_required()) {
      echo get_the_password_form();
      continue;
    }

    $price_html = $product->get_price_html();
    $short_desc = $product->get_short_description();
    $summary = $short_desc ? $short_desc : wp_trim_words(wp_strip_all_tags(get_the_content()), 38);

    $main_image = get_the_post_thumbnail_url($product_id, 'large');
    if (! $main_image) {
      $main_image = $product->get_image_id() ? wp_get_attachment_image_url($product->get_image_id(), 'large') : '';
    }
    if (! $main_image && function_exists('wc_placeholder_img_src')) {
      $main_image = wc_placeholder_img_src();
    }

    $gallery_ids = array_filter($product->get_gallery_image_ids());
    $categories = wc_get_product_category_list($product_id, '، ', '', '');
    $tags = wc_get_product_tag_list($product_id, '', '', '');
    $sku = $product->get_sku();

    $is_virtual = $product->is_virtual();
    $is_downloadable = $product->is_downloadable();
    $download_limit = $product->get_download_limit();
    $download_expiry = $product->get_download_expiry();

    $review_count = (int) $product->get_review_count();
    $average_rating = (float) $product->get_average_rating();
    $rating_html = function_exists('wc_get_rating_html') ? wc_get_rating_html($average_rating, $review_count) : '';

    $digital_type = get_post_meta($product_id, '_romonet_digital_product_type', true);
    $product_version = get_post_meta($product_id, '_romonet_product_version', true);
    $last_update_meta = get_post_meta($product_id, '_romonet_product_last_update', true);
    $file_size = get_post_meta($product_id, '_romonet_product_file_size', true);
    $wp_requirement = get_post_meta($product_id, '_romonet_product_wp_requirement', true);
    $php_requirement = get_post_meta($product_id, '_romonet_product_php_requirement', true);
    $license_type = get_post_meta($product_id, '_romonet_product_license_type', true);
    $developer = get_post_meta($product_id, '_romonet_product_developer', true);
    $demo_url = get_post_meta($product_id, '_romonet_product_demo_url', true);
    $docs_url = get_post_meta($product_id, '_romonet_product_docs_url', true);
    $support_url = get_post_meta($product_id, '_romonet_product_support_url', true);
    $included_items_raw = get_post_meta($product_id, '_romonet_product_included_items', true);
    $changelog = get_post_meta($product_id, '_romonet_product_changelog', true);

    $digital_type_label = function_exists('romonet_get_digital_product_type_label_fa')
      ? romonet_get_digital_product_type_label_fa($digital_type)
      : '';
    $license_label = function_exists('romonet_get_product_license_label_fa')
      ? romonet_get_product_license_label_fa($license_type)
      : '';

    $updated_display = get_the_modified_date('j F Y');
    if ($last_update_meta) {
      $last_update_timestamp = strtotime($last_update_meta);
      $updated_display = $last_update_timestamp ? date_i18n('j F Y', $last_update_timestamp) : $last_update_meta;
    }

    $included_items = array_filter(
      array_map(
        'trim',
        preg_split('/\r\n|\r|\n/', (string) $included_items_raw)
      )
    );

    $compatibility = array_filter(
      array(
        'وردپرس' => $wp_requirement,
        'PHP'    => $php_requirement,
      )
    );

    $hero_highlights = array_filter(
      array(
        $digital_type_label,
        $product_version ? 'نسخه ' . $product_version : '',
        $license_label ? 'لایسنس ' . $license_label : '',
        $file_size,
      )
    );

    $is_in_cart = false;
    $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/');

    if (function_exists('WC') && WC()->cart) {
      foreach (WC()->cart->get_cart() as $cart_item) {
        if (isset($cart_item['product_id']) && absint($cart_item['product_id']) === $product_id) {
          $is_in_cart = true;
          break;
        }
      }
    }

    $download_limit_text = '';
    if ($is_downloadable) {
      if (! empty($download_limit) && intval($download_limit) > 0) {
        $download_limit_text = sprintf('%d بار دانلود', intval($download_limit));
      } else {
        $download_limit_text = 'دانلود نامحدود';
      }
    }

    $download_expiry_text = '';
    if ($is_downloadable) {
      if (! empty($download_expiry) && intval($download_expiry) > 0) {
        $download_expiry_text = sprintf('دسترسی %d روزه', intval($download_expiry));
      } else {
        $download_expiry_text = 'بدون محدودیت زمانی';
      }
    }
    ?>

    <section class="relative overflow-hidden border-b border-slate-200 bg-linear-to-br from-white via-pink-50/40 to-slate-50">
      <div class="pointer-events-none absolute -left-24 top-10 h-72 w-72 rounded-full bg-pink-200/30 blur-3xl" aria-hidden="true"></div>
      <div class="pointer-events-none absolute -right-16 bottom-0 h-64 w-64 rounded-full bg-indigo-200/20 blur-3xl" aria-hidden="true"></div>
      <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgb(37_99_235/0.08)_1px,transparent_0)] bg-size-[24px_24px]" aria-hidden="true"></div>

      <div class="relative mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <?php get_template_part('template-parts/ui/breadcrumbs', null, array('current' => get_the_title(), 'class' => 'mb-8')); ?>

        <div class="grid gap-10 lg:grid-cols-[1.1fr_.9fr] lg:items-start">
          <div class="space-y-6">
            <div class="flex flex-wrap items-center gap-3">
              <?php if ($digital_type_label) : ?>
                <span class="inline-flex items-center rounded-full bg-pink-600 px-4 py-1.5 text-xs font-bold text-white shadow-sm"><?php echo esc_html($digital_type_label); ?></span>
              <?php endif; ?>
              <?php if ($categories) : ?>
                <span class="text-sm font-semibold text-pink-700"><?php echo wp_kses_post($categories); ?></span>
              <?php endif; ?>
            </div>

            <h1 class="text-balance text-3xl font-black leading-tight text-slate-900 sm:text-4xl lg:text-5xl"><?php the_title(); ?></h1>

            <?php if ($developer) : ?>
              <p class="text-sm font-medium text-slate-500">توسعه‌دهنده: <span class="text-slate-800"><?php echo esc_html($developer); ?></span></p>
            <?php endif; ?>

            <p class="max-w-2xl text-base leading-8 text-slate-600 sm:text-lg"><?php echo esc_html($summary); ?></p>

            <?php if (! empty($hero_highlights)) : ?>
              <div class="flex flex-wrap gap-2">
                <?php foreach ($hero_highlights as $item) : ?>
                  <span class="inline-flex items-center rounded-full border border-pink-100 bg-white/80 px-4 py-2 text-xs font-semibold text-pink-800 shadow-sm backdrop-blur-sm sm:text-sm"><?php echo esc_html($item); ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <div class="flex flex-wrap items-center gap-3 text-sm text-slate-600">
              <?php if ($rating_html) : ?>
                <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-2 shadow-sm">
                  <?php echo wp_kses_post($rating_html); ?>
                  <span class="font-medium text-slate-700"><?php echo esc_html(sprintf('%d نظر', $review_count)); ?></span>
                </div>
              <?php endif; ?>

              <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-2 font-medium shadow-sm">
                بروزرسانی: <?php echo esc_html($updated_display); ?>
              </span>

              <?php if ($sku) : ?>
                <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-2 font-medium shadow-sm">
                  کد: <?php echo esc_html($sku); ?>
                </span>
              <?php endif; ?>
            </div>

            <div class="rounded-3xl border border-slate-200/80 bg-white/90 p-6 shadow-lg shadow-pink-100/30 backdrop-blur-sm sm:p-7">
              <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="space-y-2">
                  <p class="text-sm font-semibold text-slate-500">قیمت (تومان)</p>
                  <div class="text-3xl font-black text-slate-900"><?php echo wp_kses_post($price_html); ?></div>
                  <p class="text-xs text-slate-500">پرداخت امن — تحویل فوری پس از خرید</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                  <div class="romonet-product-add-to-cart flex flex-wrap items-center gap-3" data-romonet-product-id="<?php echo esc_attr($product_id); ?>">
                    <div class="romonet-product-action romonet-product-action--in-cart" style="display:<?php echo $is_in_cart ? 'flex' : 'none'; ?>;">
                      <a href="<?php echo esc_url($cart_url); ?>" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-7 py-3 text-sm font-semibold text-white transition hover:bg-slate-700 sm:text-base">مشاهده سبد خرید</a>
                    </div>

                    <div class="romonet-product-action romonet-product-action--add" style="display:<?php echo $is_in_cart ? 'none' : 'block'; ?>;">
                      <?php if ($product->is_type('simple') && $product->is_purchasable() && $product->is_in_stock()) : ?>
                        <form class="grid gap-3 sm:grid-flow-col sm:auto-cols-max" data-romonet-add-to-cart-form method="post" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->add_to_cart_url())); ?>" enctype="multipart/form-data">
                          <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
                          <input type="hidden" name="quantity" value="1">
                          <button type="submit" class="inline-flex items-center justify-center rounded-full bg-pink-600 px-7 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-500 sm:text-base">افزودن به سبد</button>
                        </form>
                      <?php elseif ($product->is_purchasable() && $product->is_in_stock()) : ?>
                        <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="inline-flex items-center justify-center rounded-full bg-pink-600 px-7 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-500 sm:text-base"><?php echo esc_html($product->add_to_cart_text()); ?></a>
                      <?php else : ?>
                        <span class="inline-flex items-center justify-center rounded-full bg-slate-300 px-7 py-3 text-sm font-semibold text-slate-700">ناموجود</span>
                      <?php endif; ?>
                    </div>
                  </div>

                  <a href="#description" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-7 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100 sm:text-base">معرفی محصول</a>
                  <?php if ($demo_url) : ?>
                    <a href="<?php echo esc_url($demo_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-full border border-pink-200 bg-pink-50 px-7 py-3 text-sm font-semibold text-pink-700 transition hover:bg-pink-100 sm:text-base">دمو زنده</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="space-y-4">
            <div class="overflow-hidden rounded-4xl border border-slate-200 bg-white shadow-xl shadow-slate-200/50">
              <img src="<?php echo esc_url($main_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="aspect-4/3 w-full object-cover" />
            </div>

            <?php if (! empty($gallery_ids)) : ?>
              <div class="grid grid-cols-3 gap-3">
                <?php foreach (array_slice($gallery_ids, 0, 3) as $gallery_id) : ?>
                  <?php $thumb_url = wp_get_attachment_image_url($gallery_id, 'medium_large'); ?>
                  <?php if (! $thumb_url) {
                    continue;
                  } ?>
                  <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr(get_post_meta($gallery_id, '_wp_attachment_image_alt', true) ?: get_the_title()); ?>" class="aspect-square w-full object-cover" loading="lazy" />
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <section class="py-14 lg:py-20">
      <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_22rem] lg:px-8">
        <div class="space-y-8">
          <section id="description" class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-2xl font-bold text-slate-900">معرفی کامل محصول</h2>
            <div class="prose prose-slate mt-6 max-w-none prose-headings:font-bold prose-a:text-pink-600">
              <?php the_content(); ?>
            </div>
          </section>

          <?php if (! empty($included_items)) : ?>
            <section class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
              <h2 class="text-2xl font-bold text-slate-900">این بسته شامل چیست؟</h2>
              <ul class="mt-6 grid gap-3 text-sm leading-7 text-slate-700 sm:grid-cols-2 sm:text-base">
                <?php foreach ($included_items as $included_item) : ?>
                  <li class="flex items-start gap-3 rounded-2xl border border-emerald-100 bg-emerald-50/50 px-4 py-3">
                    <span class="mt-1.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-xs text-white">✓</span>
                    <span><?php echo esc_html($included_item); ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </section>
          <?php endif; ?>

          <?php if (! empty($compatibility) || $product->has_attributes()) : ?>
            <section class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
              <h2 class="text-2xl font-bold text-slate-900">مشخصات فنی</h2>

              <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <?php foreach ($compatibility as $label => $value) : ?>
                  <div class="rounded-3xl border border-slate-200 bg-linear-to-br from-slate-50 to-white p-5">
                    <p class="text-sm font-semibold text-slate-500"><?php echo esc_html($label); ?></p>
                    <p class="mt-2 text-base font-semibold text-slate-900"><?php echo esc_html($value); ?></p>
                  </div>
                <?php endforeach; ?>

                <?php if ($license_label) : ?>
                  <div class="rounded-3xl border border-slate-200 bg-linear-to-br from-slate-50 to-white p-5">
                    <p class="text-sm font-semibold text-slate-500">نوع لایسنس</p>
                    <p class="mt-2 text-base font-semibold text-slate-900"><?php echo esc_html($license_label); ?></p>
                  </div>
                <?php endif; ?>

                <?php foreach ($product->get_attributes() as $attribute) : ?>
                  <?php if (! $attribute->get_visible()) {
                    continue;
                  } ?>
                  <?php
                  $attribute_name = wc_attribute_label($attribute->get_name());
                  $attribute_values = '';
                  if ($attribute->is_taxonomy()) {
                    $attribute_terms = wc_get_product_terms($product_id, $attribute->get_name(), array('fields' => 'names'));
                    $attribute_values = ! is_wp_error($attribute_terms) ? implode('، ', $attribute_terms) : '';
                  } else {
                    $attribute_values = implode('، ', $attribute->get_options());
                  }
                  ?>
                  <?php if (! $attribute_values) {
                    continue;
                  } ?>
                  <div class="rounded-3xl border border-slate-200 bg-linear-to-br from-slate-50 to-white p-5">
                    <p class="text-sm font-semibold text-slate-500"><?php echo esc_html($attribute_name); ?></p>
                    <p class="mt-2 text-base font-semibold text-slate-900"><?php echo esc_html($attribute_values); ?></p>
                  </div>
                <?php endforeach; ?>
              </div>
            </section>
          <?php endif; ?>

          <?php if ($changelog) : ?>
            <section class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
              <h2 class="text-2xl font-bold text-slate-900">تغییرات نسخه‌ها</h2>
              <div class="mt-5 whitespace-pre-line rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 font-mono text-sm leading-8 text-slate-700 sm:text-base"><?php echo esc_html($changelog); ?></div>
            </section>
          <?php endif; ?>

          <section id="product-reviews" class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
              <div>
                <h2 class="text-2xl font-bold text-slate-900">نظرات مشتریان</h2>
                <p class="mt-2 text-sm text-slate-600">بازخورد خریدارانی که این محصول را تهیه کرده‌اند.</p>
              </div>
              <?php if ($rating_html) : ?>
                <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                  <?php echo wp_kses_post($rating_html); ?>
                  <span class="font-semibold text-slate-700"><?php echo esc_html(sprintf('%d نظر', $review_count)); ?></span>
                </div>
              <?php endif; ?>
            </div>

            <?php if (comments_open() || $review_count > 0) : ?>
              <?php comments_template(); ?>
            <?php else : ?>
              <p class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">ثبت نظر برای این محصول در حال حاضر غیرفعال است.</p>
            <?php endif; ?>
          </section>
        </div>

        <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
          <section class="rounded-4xl border border-pink-100 bg-linear-to-br from-pink-600 to-indigo-700 p-6 text-white shadow-lg">
            <h2 class="text-lg font-bold">خرید مطمئن از رومونت</h2>
            <ul class="mt-4 space-y-3 text-sm leading-7 text-pink-50">
              <li class="flex gap-2"><span>✓</span><span>تحویل آنی فایل پس از پرداخت</span></li>
              <li class="flex gap-2"><span>✓</span><span>پشتیبانی فنی تیم آژانس</span></li>
              <li class="flex gap-2"><span>✓</span><span>قیمت‌گذاری شفاف به تومان</span></li>
            </ul>
          </section>

          <section class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">اطلاعات سریع</h2>
            <dl class="mt-5 space-y-4 text-sm">
              <?php if ($digital_type_label) : ?>
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                  <dt class="text-slate-500">نوع</dt>
                  <dd class="font-semibold text-slate-900"><?php echo esc_html($digital_type_label); ?></dd>
                </div>
              <?php endif; ?>

              <?php if ($developer) : ?>
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                  <dt class="text-slate-500">توسعه‌دهنده</dt>
                  <dd class="font-semibold text-slate-900"><?php echo esc_html($developer); ?></dd>
                </div>
              <?php endif; ?>

              <?php if ($product_version) : ?>
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                  <dt class="text-slate-500">نسخه</dt>
                  <dd class="font-semibold text-slate-900"><?php echo esc_html($product_version); ?></dd>
                </div>
              <?php endif; ?>

              <?php if ($license_label) : ?>
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                  <dt class="text-slate-500">لایسنس</dt>
                  <dd class="font-semibold text-slate-900"><?php echo esc_html($license_label); ?></dd>
                </div>
              <?php endif; ?>

              <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                <dt class="text-slate-500">آخرین بروزرسانی</dt>
                <dd class="font-semibold text-slate-900"><?php echo esc_html($updated_display); ?></dd>
              </div>

              <?php if ($file_size) : ?>
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                  <dt class="text-slate-500">حجم بسته</dt>
                  <dd class="font-semibold text-slate-900"><?php echo esc_html($file_size); ?></dd>
                </div>
              <?php endif; ?>

              <?php if ($is_downloadable) : ?>
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3">
                  <dt class="text-slate-500">دانلود</dt>
                  <dd class="font-semibold text-slate-900"><?php echo esc_html($download_limit_text); ?></dd>
                </div>
                <div class="flex items-start justify-between gap-4">
                  <dt class="text-slate-500">مدت دسترسی</dt>
                  <dd class="font-semibold text-slate-900"><?php echo esc_html($download_expiry_text); ?></dd>
                </div>
              <?php elseif ($is_virtual) : ?>
                <div class="flex items-start justify-between gap-4">
                  <dt class="text-slate-500">تحویل</dt>
                  <dd class="font-semibold text-slate-900">دسترسی مجازی فوری</dd>
                </div>
              <?php endif; ?>
            </dl>
          </section>

          <?php if ($docs_url || $demo_url || $support_url) : ?>
            <section class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm">
              <h2 class="text-lg font-bold text-slate-900">منابع و لینک‌ها</h2>
              <div class="mt-5 grid gap-3">
                <?php if ($demo_url) : ?>
                  <a href="<?php echo esc_url($demo_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-2xl border border-pink-200 bg-pink-50 px-4 py-3 text-sm font-semibold text-pink-700 transition hover:bg-pink-100">مشاهده دمو زنده</a>
                <?php endif; ?>
                <?php if ($docs_url) : ?>
                  <a href="<?php echo esc_url($docs_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">مطالعه مستندات</a>
                <?php endif; ?>
                <?php if ($support_url) : ?>
                  <a href="<?php echo esc_url($support_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">درخواست پشتیبانی</a>
                <?php endif; ?>
              </div>
            </section>
          <?php endif; ?>

          <?php if ($tags) : ?>
            <section class="rounded-4xl border border-slate-100 bg-white p-6 shadow-sm">
              <h2 class="text-lg font-bold text-slate-900">برچسب‌ها</h2>
              <div class="mt-4 flex flex-wrap gap-2 text-sm"><?php echo wp_kses_post($tags); ?></div>
            </section>
          <?php endif; ?>
        </aside>
      </div>
    </section>

    <?php get_template_part('template-parts/ui/cart-notification'); ?>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('[data-romonet-add-to-cart-form]');
        var notice = document.querySelector('[data-romonet-cart-notice]');
        var closeButton = notice ? notice.querySelector('[data-romonet-cart-notice-close]') : null;

        if (!form || !notice) {
          return;
        }

        function updateMiniCartFragments() {
          return fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
              method: 'POST',
              credentials: 'same-origin',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
              },
              body: 'action=romonet_get_cart_fragments'
            })
            .then(function(response) {
              return response.json();
            })
            .then(function(response) {
              if (!response.success || !response.data) {
                return;
              }

              var badge = document.querySelector('[data-romonet-cart-badge]');
              var count = document.querySelector('[data-romonet-cart-count]');
              var items = document.querySelector('[data-romonet-cart-items]');
              var subtotal = document.querySelector('[data-romonet-cart-subtotal]');

              if (badge) {
                if (response.data.cart_count > 0) {
                  badge.textContent = response.data.cart_count;
                  badge.style.display = 'inline-flex';
                } else {
                  badge.textContent = '';
                  badge.style.display = 'none';
                }
              }

              if (count) {
                count.textContent = response.data.cart_count_label;
              }

              if (items) {
                items.innerHTML = response.data.items_html;
              }

              if (subtotal) {
                subtotal.innerHTML = response.data.cart_subtotal;
              }

              updateProductAddToCartState(response.data.cart_product_ids || []);
            });
        }

        function updateProductAddToCartState(cartProductIds) {
          var productContainer = document.querySelector('[data-romonet-product-id]');
          if (!productContainer) {
            return;
          }

          var productId = parseInt(productContainer.getAttribute('data-romonet-product-id'), 10);
          if (!productId) {
            return;
          }

          var inCart = cartProductIds.indexOf(productId) !== -1;
          var inCartAction = productContainer.querySelector('.romonet-product-action--in-cart');
          var addAction = productContainer.querySelector('.romonet-product-action--add');

          if (inCartAction) {
            inCartAction.style.display = inCart ? 'flex' : 'none';
          }
          if (addAction) {
            addAction.style.display = inCart ? 'none' : 'block';
          }
        }

        window.addEventListener('romonetCartFragmentsUpdated', function(event) {
          updateProductAddToCartState((event.detail && event.detail.cartProductIds) ? event.detail.cartProductIds : []);
        });

        form.addEventListener('submit', function(event) {
          event.preventDefault();

          var data = new FormData(form);
          data.append('action', 'romonet_add_to_cart');

          fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
              method: 'POST',
              body: data,
              credentials: 'same-origin'
            })
            .then(function(response) {
              return response.json();
            })
            .then(function(response) {
              if (response.success) {
                updateMiniCartFragments();
                notice.classList.remove('hidden');
                window.setTimeout(function() {
                  notice.classList.add('hidden');
                }, 5000);
              } else {
                window.alert(response.data && response.data.message ? response.data.message : 'افزودن محصول به سبد با خطا مواجه شد.');
              }
            })
            .catch(function() {
              window.alert('اتصال به سرور برقرار نشد.');
            });
        });

        if (closeButton) {
          closeButton.addEventListener('click', function() {
            notice.classList.add('hidden');
          });
        }
      });
    </script>
  <?php endwhile; ?>
</main>

<?php
get_footer();
