<?php

/**
 * WooCommerce integration hooks and compatibility.
 */

if (! defined('ABSPATH')) {
  exit;
}

if (! function_exists('romonet_woocommerce_setup')) {
  function romonet_woocommerce_setup()
  {
    add_theme_support(
      'woocommerce',
      array(
        'thumbnail_image_width' => 480,
        'single_image_width'    => 800,
        'product_grid'          => array(
          'default_rows'    => 3,
          'min_rows'        => 2,
          'max_rows'        => 6,
          'default_columns' => 3,
          'min_columns'     => 2,
          'max_columns'     => 4,
        ),
      )
    );
  }
}
add_action('after_setup_theme', 'romonet_woocommerce_setup');

if (! function_exists('romonet_woocommerce_content_width')) {
  function romonet_woocommerce_content_width()
  {
    $GLOBALS['content_width'] = 1200;
  }
}
add_action('after_setup_theme', 'romonet_woocommerce_content_width', 0);

if (! function_exists('romonet_ajax_add_to_cart')) {
  function romonet_ajax_add_to_cart()
  {
    if (! class_exists('WooCommerce') || ! function_exists('WC')) {
      wp_send_json_error(array('message' => 'WooCommerce بارگذاری نشده است.'));
    }

    $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
    $quantity   = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;

    if (! $product_id || $quantity < 1) {
      wp_send_json_error(array('message' => 'داده‌های محصول معتبر نیستند.'));
    }

    $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity);

    if ($cart_item_key) {
      wp_send_json_success(array(
        'cart_url'     => wc_get_cart_url(),
        'checkout_url' => wc_get_checkout_url(),
      ));
    }

    wp_send_json_error(array('message' => 'افزودن محصول به سبد با خطا مواجه شد.'));
  }
}

add_filter('the_content', 'romonet_custom_cart_page_content', 20);

if (! function_exists('romonet_custom_cart_page_content')) {
  function romonet_custom_cart_page_content($content)
  {
    if (! function_exists('is_cart') || ! is_cart() || ! is_main_query()) {
      return $content;
    }

    ob_start();
    wc_get_template('cart/cart.php');
    return ob_get_clean();
  }
}

add_filter('woocommerce_form_field_args', 'romonet_woocommerce_checkout_form_field_args', 10, 3);

if (! function_exists('romonet_woocommerce_checkout_form_field_args')) {
  function romonet_woocommerce_checkout_form_field_args($args, $key, $value)
  {
    if (is_admin() || ! function_exists('is_checkout') || ! is_checkout()) {
      return $args;
    }

    if (is_string($args['label_class'])) {
      $args['label_class'] = array($args['label_class']);
    }

    if (is_string($args['input_class'])) {
      $args['input_class'] = array($args['input_class']);
    }

    if (is_string($args['class'])) {
      $args['class'] = array($args['class']);
    }

    $args['label_class'][] = 'romonet-checkout-label';
    $args['input_class'][] = 'romonet-checkout-input';
    $args['class'][] = 'romonet-checkout-row';

    return $args;
  }
}

add_filter('woocommerce_checkout_fields', 'romonet_woocommerce_checkout_fields');
if (! function_exists('romonet_woocommerce_checkout_fields')) {
  function romonet_woocommerce_checkout_fields($fields)
  {
    if (is_admin() || ! function_exists('is_checkout') || ! is_checkout()) {
      return $fields;
    }

    // Keep only a single full-name field plus phone and email.
    $fields['billing'] = array(
      'billing_full_name' => array(
        'type'        => 'text',
        'label'       => __('Full name', 'romonet'),
        'placeholder' => __('First and last name', 'romonet'),
        'required'    => true,
        'class'       => array('form-row-wide'),
        'priority'    => 10,
        'autocomplete' => 'name',
      ),
      'billing_phone' => array(
        'type'        => 'tel',
        'label'       => __('Phone', 'romonet'),
        'placeholder' => __('Phone number', 'romonet'),
        'required'    => true,
        'class'       => array('form-row-wide'),
        'priority'    => 20,
        'autocomplete' => 'tel',
      ),
      'billing_email' => array(
        'type'        => 'email',
        'label'       => __('Email', 'romonet'),
        'placeholder' => __('Email address (optional)', 'romonet'),
        'required'    => false,
        'class'       => array('form-row-wide'),
        'priority'    => 30,
        'autocomplete' => 'email',
      ),
    );

    // Remove shipping and order fields, but keep account fields for registration.
    unset($fields['shipping'], $fields['order']);

    return $fields;
  }
}

add_action('woocommerce_checkout_process', 'romonet_woocommerce_checkout_process_full_name');
if (! function_exists('romonet_woocommerce_checkout_process_full_name')) {
  function romonet_woocommerce_checkout_process_full_name()
  {
    if (! isset($_POST['billing_full_name'])) {
      return;
    }

    $full_name = sanitize_text_field(wp_unslash($_POST['billing_full_name']));
    $parts = preg_split('/\s+/', trim($full_name));
    $first_name = $parts ? array_shift($parts) : '';
    $last_name = $parts ? implode(' ', $parts) : '';

    $_POST['billing_first_name'] = $first_name;
    $_POST['billing_last_name']  = $last_name;
  }
}

add_action('wp_ajax_romonet_add_to_cart', 'romonet_ajax_add_to_cart');
add_action('wp_ajax_nopriv_romonet_add_to_cart', 'romonet_ajax_add_to_cart');

if (! function_exists('romonet_get_mini_cart_items_markup')) {
  function romonet_get_mini_cart_items_markup()
  {
    if (! class_exists('WooCommerce') || ! function_exists('WC') || ! WC()->cart) {
      return '';
    }

    $cart_items = WC()->cart->get_cart();

    if (empty($cart_items)) {
      return '<div class="rounded-3xl bg-slate-900 px-4 py-5 text-center text-slate-300">سبد خرید شما خالی است.</div>';
    }

    ob_start();

    foreach ($cart_items as $cart_item_key => $cart_item) :
      $product = $cart_item['data'];
      if (! $product || ! $product->exists()) {
        continue;
      }

      $product_name = $product->get_name();
      $product_qty  = intval($cart_item['quantity']);
      $product_price = wc_price(WC()->cart->get_product_subtotal($product, $product_qty));
      $product_permalink = $product->is_visible() ? $product->get_permalink() : '';
?>
      <div class="flex items-start gap-3 border-b border-white/10 py-3 last:border-b-0">
        <button type="button" data-romonet-remove-cart-item="<?php echo esc_attr($cart_item_key); ?>" class="inline-flex h-8 w-8 flex-none items-center justify-center rounded-full border border-white/10 bg-slate-900 text-slate-400 transition hover:bg-slate-800 hover:text-white" aria-label="حذف محصول">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7V5.5a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5V7" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 11.25v6.75m3.75-6.75v6.75m3.75-6.75v6.75" />
          </svg>
        </button>
        <div class="min-w-11 overflow-hidden rounded-2xl bg-slate-900">
          <?php echo wp_kses_post($product->get_image(array(80, 80))); ?>
        </div>
        <div class="min-w-0 flex-1">
          <?php if ($product_permalink) : ?>
            <a href="<?php echo esc_url($product_permalink); ?>" class="block truncate text-sm font-semibold text-white hover:text-blue-400"><?php echo esc_html($product_name); ?></a>
          <?php else : ?>
            <div class="block truncate text-sm font-semibold text-white"><?php echo esc_html($product_name); ?></div>
          <?php endif; ?>
          <div class="mt-1 flex items-center gap-2 text-xs text-slate-400">
            <span>تعداد: <?php echo esc_html($product_qty); ?></span>
            <span>قیمت: <?php echo wp_kses_post($product_price); ?></span>
          </div>
        </div>
      </div>
<?php endforeach;

    return ob_get_clean();
  }
}

if (! function_exists('romonet_ajax_get_cart_fragments')) {
  function romonet_ajax_get_cart_fragments()
  {
    if (! class_exists('WooCommerce') || ! function_exists('WC')) {
      wp_send_json_error(array('message' => 'WooCommerce بارگذاری نشده است.'));
    }

    $cart_count = WC()->cart->get_cart_contents_count();
    $cart_product_ids = array();
    foreach (WC()->cart->get_cart() as $cart_item) {
      if (isset($cart_item['product_id'])) {
        $cart_product_ids[] = absint($cart_item['product_id']);
      }
    }
    $cart_product_ids = array_values(array_unique($cart_product_ids));

    wp_send_json_success(array(
      'cart_count' => $cart_count,
      'cart_count_label' => sprintf(_n('%d آیتم', '%d آیتم', $cart_count, 'romonet'), $cart_count),
      'cart_subtotal' => wp_kses_post(WC()->cart->get_cart_subtotal()),
      'items_html' => romonet_get_mini_cart_items_markup(),
      'cart_product_ids' => $cart_product_ids,
    ));
  }
}

if (! function_exists('romonet_ajax_remove_cart_item')) {
  function romonet_ajax_remove_cart_item()
  {
    if (! class_exists('WooCommerce') || ! function_exists('WC')) {
      wp_send_json_error(array('message' => 'WooCommerce بارگذاری نشده است.'));
    }

    $cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field(wp_unslash($_POST['cart_item_key'])) : '';

    if (! $cart_item_key || ! WC()->cart->remove_cart_item($cart_item_key)) {
      wp_send_json_error(array('message' => 'آیتم سبد خرید پیدا نشد یا حذف امکان‌پذیر نیست.'));
    }

    $cart_count = WC()->cart->get_cart_contents_count();
    $cart_product_ids = array();
    foreach (WC()->cart->get_cart() as $cart_item) {
      if (isset($cart_item['product_id'])) {
        $cart_product_ids[] = absint($cart_item['product_id']);
      }
    }
    $cart_product_ids = array_values(array_unique($cart_product_ids));

    wp_send_json_success(array(
      'cart_count' => $cart_count,
      'cart_count_label' => sprintf(_n('%d آیتم', '%d آیتم', $cart_count, 'romonet'), $cart_count),
      'cart_subtotal' => wp_kses_post(WC()->cart->get_cart_subtotal()),
      'items_html' => romonet_get_mini_cart_items_markup(),
      'cart_product_ids' => $cart_product_ids,
    ));
  }
}

add_action('wp_ajax_romonet_remove_cart_item', 'romonet_ajax_remove_cart_item');
add_action('wp_ajax_nopriv_romonet_remove_cart_item', 'romonet_ajax_remove_cart_item');

add_action('wp_ajax_romonet_get_cart_fragments', 'romonet_ajax_get_cart_fragments');
add_action('wp_ajax_nopriv_romonet_get_cart_fragments', 'romonet_ajax_get_cart_fragments');

// Remove default WooCommerce coupon form from checkout
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);

if (! function_exists('romonet_get_usd_toman_rate')) {
  function romonet_get_usd_toman_rate()
  {
    return 150000;
  }
}

if (! function_exists('romonet_woocommerce_currency')) {
  function romonet_woocommerce_currency($currency)
  {
    return 'IRT';
  }
}
add_filter('woocommerce_currency', 'romonet_woocommerce_currency');

if (! function_exists('romonet_woocommerce_currencies')) {
  function romonet_woocommerce_currencies($currencies)
  {
    $currencies['IRT'] = 'تومان ایران';

    return $currencies;
  }
}
add_filter('woocommerce_currencies', 'romonet_woocommerce_currencies');

if (! function_exists('romonet_woocommerce_currency_symbol')) {
  function romonet_woocommerce_currency_symbol($symbol, $currency)
  {
    if ('IRT' === $currency) {
      return 'تومان';
    }

    return $symbol;
  }
}
add_filter('woocommerce_currency_symbol', 'romonet_woocommerce_currency_symbol', 10, 2);

if (! function_exists('romonet_woocommerce_price_num_decimals')) {
  function romonet_woocommerce_price_num_decimals($decimals)
  {
    return 0;
  }
}
add_filter('woocommerce_price_num_decimals', 'romonet_woocommerce_price_num_decimals');

if (! function_exists('romonet_woocommerce_price_format')) {
  function romonet_woocommerce_price_format($format)
  {
    return '%2$s %1$s';
  }
}
add_filter('woocommerce_price_format', 'romonet_woocommerce_price_format');

if (! function_exists('romonet_get_digital_product_meta_fields')) {
  function romonet_get_digital_product_meta_fields()
  {
    return array(
      '_romonet_digital_product_type' => array(
        'label'       => 'نوع محصول دیجیتال',
        'type'        => 'select',
        'description' => 'نوع محصول را انتخاب کنید (قالب، افزونه، اسکریپت و ...).',
        'options'     => array(
          ''             => 'انتخاب نوع',
          'theme'        => 'قالب',
          'plugin'       => 'افزونه',
          'script'       => 'اسکریپت',
          'template-kit' => 'کیت قالب',
          'other'        => 'سایر',
        ),
      ),
      '_romonet_product_version' => array(
        'label'       => 'نسخه فعلی',
        'type'        => 'text',
        'description' => 'مثال: 2.4.1',
      ),
      '_romonet_product_last_update' => array(
        'label'       => 'تاریخ آخرین بروزرسانی',
        'type'        => 'date',
        'description' => 'تاریخ نمایش‌داده‌شده در صفحه محصول.',
      ),
      '_romonet_product_file_size' => array(
        'label'       => 'حجم بسته',
        'type'        => 'text',
        'description' => 'مثال: 9.2 مگابایت',
      ),
      '_romonet_product_wp_requirement' => array(
        'label'       => 'نیازمندی وردپرس',
        'type'        => 'text',
        'description' => 'مثال: وردپرس 6.4+',
      ),
      '_romonet_product_php_requirement' => array(
        'label'       => 'نیازمندی PHP',
        'type'        => 'text',
        'description' => 'مثال: PHP 8.0+',
      ),
      '_romonet_product_license_type' => array(
        'label'       => 'نوع لایسنس',
        'type'        => 'select',
        'description' => 'مدت اعتبار لایسنس محصول.',
        'options'     => array(
          ''         => 'انتخاب کنید',
          'annual'   => 'سالانه',
          'lifetime' => 'دائمی',
          'monthly'  => 'ماهانه',
        ),
      ),
      '_romonet_product_developer' => array(
        'label'       => 'توسعه‌دهنده',
        'type'        => 'text',
        'description' => 'نام سازنده یا برند (مثال: رومونت، Crocoblock).',
      ),
      '_romonet_product_demo_url' => array(
        'label'       => 'آدرس دمو زنده',
        'type'        => 'url',
        'description' => 'لینک اختیاری به دمو.',
      ),
      '_romonet_product_docs_url' => array(
        'label'       => 'آدرس مستندات',
        'type'        => 'url',
        'description' => 'لینک راهنما یا مرکز کمک.',
      ),
      '_romonet_product_support_url' => array(
        'label'       => 'آدرس پشتیبانی',
        'type'        => 'url',
        'description' => 'صفحه تماس یا تیکت پشتیبانی.',
      ),
      '_romonet_product_included_items' => array(
        'label'       => 'موارد شامل بسته',
        'type'        => 'textarea',
        'description' => 'هر مورد در یک خط (فایل، مستندات، پشتیبانی و ...).',
      ),
      '_romonet_product_changelog' => array(
        'label'       => 'تغییرات نسخه‌ها',
        'type'        => 'textarea',
        'description' => 'خلاصه changelog یا یادداشت انتشار.',
      ),
    );
  }
}

if (! function_exists('romonet_add_digital_product_meta_box')) {
  function romonet_add_digital_product_meta_box()
  {
    add_meta_box(
      'romonet_digital_product_meta_box',
      'جزئیات محصول دیجیتال',
      'romonet_render_digital_product_meta_box',
      'product',
      'normal',
      'high'
    );
  }
}
add_action('add_meta_boxes', 'romonet_add_digital_product_meta_box');

if (! function_exists('romonet_render_digital_product_meta_box')) {
  function romonet_render_digital_product_meta_box($post)
  {
    $fields = romonet_get_digital_product_meta_fields();

    wp_nonce_field('romonet_save_digital_product_meta', 'romonet_digital_product_meta_nonce');

    echo '<table class="form-table" role="presentation"><tbody>';

    foreach ($fields as $meta_key => $field) {
      $field_id = sanitize_html_class($meta_key);
      $value = get_post_meta($post->ID, $meta_key, true);

      echo '<tr>';
      echo '<th scope="row"><label for="' . esc_attr($field_id) . '">' . esc_html($field['label']) . '</label></th>';
      echo '<td>';

      if ('textarea' === $field['type']) {
        echo '<textarea class="widefat" rows="4" id="' . esc_attr($field_id) . '" name="' . esc_attr($meta_key) . '">' . esc_textarea($value) . '</textarea>';
      } elseif ('select' === $field['type']) {
        $options = isset($field['options']) && is_array($field['options']) ? $field['options'] : array();
        echo '<select class="widefat" id="' . esc_attr($field_id) . '" name="' . esc_attr($meta_key) . '">';
        foreach ($options as $option_value => $option_label) {
          echo '<option value="' . esc_attr($option_value) . '" ' . selected($value, $option_value, false) . '>' . esc_html($option_label) . '</option>';
        }
        echo '</select>';
      } else {
        $input_type = in_array($field['type'], array('text', 'url', 'date'), true) ? $field['type'] : 'text';
        echo '<input class="widefat" type="' . esc_attr($input_type) . '" id="' . esc_attr($field_id) . '" name="' . esc_attr($meta_key) . '" value="' . esc_attr($value) . '" />';
      }

      if (! empty($field['description'])) {
        echo '<p class="description">' . esc_html($field['description']) . '</p>';
      }

      echo '</td>';
      echo '</tr>';
    }

    echo '</tbody></table>';
  }
}

if (! function_exists('romonet_save_digital_product_meta_box')) {
  function romonet_save_digital_product_meta_box($post_id, $post)
  {
    if (! isset($_POST['romonet_digital_product_meta_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['romonet_digital_product_meta_nonce'])), 'romonet_save_digital_product_meta')) {
      return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }

    if (! $post || 'product' !== $post->post_type) {
      return;
    }

    if (! current_user_can('edit_post', $post_id)) {
      return;
    }

    if (wp_is_post_revision($post_id)) {
      return;
    }

    $fields = romonet_get_digital_product_meta_fields();
    $url_fields = array(
      '_romonet_product_demo_url',
      '_romonet_product_docs_url',
      '_romonet_product_support_url',
    );
    $textarea_fields = array(
      '_romonet_product_included_items',
      '_romonet_product_changelog',
    );
    $allowed_types = array('theme', 'plugin', 'script', 'template-kit', 'other');
    $allowed_licenses = array('annual', 'lifetime', 'monthly');

    foreach ($fields as $meta_key => $field) {
      $raw_value = isset($_POST[$meta_key]) ? wp_unslash($_POST[$meta_key]) : '';
      $value = '';

      if (in_array($meta_key, $url_fields, true)) {
        $value = esc_url_raw($raw_value);
      } elseif (in_array($meta_key, $textarea_fields, true)) {
        $value = sanitize_textarea_field($raw_value);
      } elseif ('_romonet_digital_product_type' === $meta_key) {
        $type_value = sanitize_key($raw_value);
        $value = in_array($type_value, $allowed_types, true) ? $type_value : '';
      } elseif ('_romonet_product_license_type' === $meta_key) {
        $license_value = sanitize_key($raw_value);
        $value = in_array($license_value, $allowed_licenses, true) ? $license_value : '';
      } else {
        $value = sanitize_text_field($raw_value);
      }

      if ('' === $value) {
        delete_post_meta($post_id, $meta_key);
      } else {
        update_post_meta($post_id, $meta_key, $value);
      }
    }
  }
}
add_action('save_post_product', 'romonet_save_digital_product_meta_box', 10, 2);

if (! function_exists('romonet_get_digital_product_type_labels')) {
  function romonet_get_digital_product_type_labels()
  {
    return array(
      'theme'        => __('Theme', 'romonet'),
      'plugin'       => __('Plugin', 'romonet'),
      'script'       => __('Script', 'romonet'),
      'template-kit' => __('Template Kit', 'romonet'),
      'other'        => __('Digital Product', 'romonet'),
    );
  }
}

if (! function_exists('romonet_get_digital_product_type_label')) {
  function romonet_get_digital_product_type_label($type)
  {
    $labels = romonet_get_digital_product_type_labels();

    return isset($labels[$type]) ? $labels[$type] : '';
  }
}

if (! function_exists('romonet_get_digital_product_type_labels_fa')) {
  function romonet_get_digital_product_type_labels_fa()
  {
    return array(
      'theme'        => 'قالب',
      'plugin'       => 'افزونه',
      'script'       => 'اسکریپت',
      'template-kit' => 'کیت قالب',
      'other'        => 'محصول دیجیتال',
    );
  }
}

if (! function_exists('romonet_get_digital_product_type_label_fa')) {
  function romonet_get_digital_product_type_label_fa($type)
  {
    $labels = romonet_get_digital_product_type_labels_fa();

    return isset($labels[$type]) ? $labels[$type] : '';
  }
}

if (! function_exists('romonet_get_product_license_labels_fa')) {
  function romonet_get_product_license_labels_fa()
  {
    return array(
      'annual'   => 'سالانه',
      'lifetime' => 'دائمی',
      'monthly'  => 'ماهانه',
    );
  }
}

if (! function_exists('romonet_get_product_license_label_fa')) {
  function romonet_get_product_license_label_fa($license)
  {
    $labels = romonet_get_product_license_labels_fa();

    if (isset($labels[$license])) {
      return $labels[$license];
    }

    $legacy = array(
      'سالانه' => 'سالانه',
      'دائمی'  => 'دائمی',
      'ماهانه' => 'ماهانه',
    );

    return isset($legacy[$license]) ? $legacy[$license] : $license;
  }
}

if (! function_exists('romonet_get_active_digital_type_filter')) {
  function romonet_get_active_digital_type_filter()
  {
    if (! isset($_GET['digital_type'])) {
      return '';
    }

    $type = sanitize_key(wp_unslash($_GET['digital_type']));
    $allowed = array_keys(romonet_get_digital_product_type_labels());

    return in_array($type, $allowed, true) ? $type : '';
  }
}

if (! function_exists('romonet_get_product_archive_base_url')) {
  function romonet_get_product_archive_base_url()
  {
    if (function_exists('is_product_category') && is_product_category()) {
      $term = get_queried_object();
      if ($term instanceof WP_Term) {
        $link = get_term_link($term);
        if (! is_wp_error($link)) {
          return $link;
        }
      }
    }

    if (function_exists('is_product_tag') && is_product_tag()) {
      $term = get_queried_object();
      if ($term instanceof WP_Term) {
        $link = get_term_link($term);
        if (! is_wp_error($link)) {
          return $link;
        }
      }
    }

    return function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
  }
}

if (! function_exists('romonet_get_product_archive_filter_url')) {
  function romonet_get_product_archive_filter_url($args = array())
  {
    $base_url = romonet_get_product_archive_base_url();
    $query_args = array();

    if (isset($_GET['s']) && '' !== $_GET['s']) {
      $query_args['s'] = sanitize_text_field(wp_unslash($_GET['s']));
    }

    if (isset($_GET['post_type']) && '' !== $_GET['post_type']) {
      $query_args['post_type'] = sanitize_key(wp_unslash($_GET['post_type']));
    }

    if (array_key_exists('digital_type', $args)) {
      if ('' !== $args['digital_type']) {
        $query_args['digital_type'] = sanitize_key($args['digital_type']);
      }
    } elseif ($active_type = romonet_get_active_digital_type_filter()) {
      $query_args['digital_type'] = $active_type;
    }

    if (empty($query_args)) {
      return $base_url;
    }

    return add_query_arg($query_args, $base_url);
  }
}

if (! function_exists('romonet_filter_products_by_digital_type')) {
  function romonet_filter_products_by_digital_type($query)
  {
    if (is_admin() || ! $query->is_main_query()) {
      return;
    }

    if (! function_exists('is_shop') || ! (is_shop() || is_product_taxonomy() || (is_search() && 'product' === get_query_var('post_type')))) {
      return;
    }

    $type = romonet_get_active_digital_type_filter();
    if (! $type) {
      return;
    }

    $meta_query = (array) $query->get('meta_query');
    $meta_query[] = array(
      'key'     => '_romonet_digital_product_type',
      'value'   => $type,
      'compare' => '=',
    );

    $query->set('meta_query', $meta_query);
  }
}
add_action('pre_get_posts', 'romonet_filter_products_by_digital_type');

if (! function_exists('romonet_get_product_card_args')) {
  function romonet_get_product_card_args($product_id)
  {
    $product_id = absint($product_id);
    $product    = function_exists('wc_get_product') ? wc_get_product($product_id) : null;

    if (! $product) {
      return array();
    }

    $summary = $product->get_short_description();
    $text    = wp_trim_words(wp_strip_all_tags($summary ? $summary : get_post_field('post_content', $product_id)), 18);

    $image = get_the_post_thumbnail_url($product_id, 'large');
    if (! $image) {
      $image = $product->get_image_id() ? wp_get_attachment_image_url($product->get_image_id(), 'large') : '';
    }

    $digital_type = get_post_meta($product_id, '_romonet_digital_product_type', true);
    $version      = get_post_meta($product_id, '_romonet_product_version', true);
    $file_size    = get_post_meta($product_id, '_romonet_product_file_size', true);
    $demo_url     = get_post_meta($product_id, '_romonet_product_demo_url', true);
    $last_update  = get_post_meta($product_id, '_romonet_product_last_update', true);
    $license_type = get_post_meta($product_id, '_romonet_product_license_type', true);
    $developer    = get_post_meta($product_id, '_romonet_product_developer', true);

    $updated_display = get_the_modified_date(get_option('date_format'), $product_id);
    if ($last_update) {
      $last_update_timestamp = strtotime($last_update);
      $updated_display = $last_update_timestamp ? date_i18n(get_option('date_format'), $last_update_timestamp) : $last_update;
    }

    $category_name = '';
    $terms = get_the_terms($product_id, 'product_cat');
    if ($terms && ! is_wp_error($terms)) {
      $category_name = $terms[0]->name;
    }

    $review_count   = (int) $product->get_review_count();
    $average_rating = (float) $product->get_average_rating();
    $rating_html    = function_exists('wc_get_rating_html') ? wc_get_rating_html($average_rating, $review_count) : '';

    return array(
      'title'         => get_the_title($product_id),
      'price'         => wp_kses_post($product->get_price_html()),
      'text'          => $text,
      'url'           => get_permalink($product_id),
      'image'         => $image,
      'alt'           => get_the_title($product_id),
      'type_label'    => romonet_get_digital_product_type_label_fa($digital_type),
      'version'       => $version,
      'file_size'     => $file_size,
      'updated'       => $updated_display,
      'category'      => $category_name,
      'rating_html'   => $rating_html,
      'review_count'  => $review_count,
      'has_demo'      => ! empty($demo_url),
      'license_label' => romonet_get_product_license_label_fa($license_type),
      'developer'     => $developer,
    );
  }
}
