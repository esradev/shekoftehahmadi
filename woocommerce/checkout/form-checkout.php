<?php

/**
 * Checkout Form
 *
 * This template overrides WooCommerce checkout output with a custom checkout layout.
 * It uses live cart data for the order summary and WooCommerce checkout hooks for
 * real billing, shipping, and payment fields.
 *
 * @see https://woocommerce.com/document/template-structure/
 */

if (! defined('ABSPATH')) {
  exit;
}

$checkout = WC()->checkout();

do_action('woocommerce_before_checkout_form', $checkout);

if (! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in()) {
  echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
  return;
}

$cart = WC()->cart;
$cart_items = $cart ? $cart->get_cart() : array();
$coupons = $cart ? $cart->get_applied_coupons() : array();
$primary_coupon = ! empty($coupons) ? strtoupper(reset($coupons)) : false;
$has_discount = $cart ? abs($cart->get_cart_discount_total()) > 0 : false;
$tax_total = $cart ? WC()->cart->get_taxes_total() : 0;
$shipping_total = $cart ? WC()->cart->get_cart_shipping_total() : '';
$has_shipping = $cart ? $cart->needs_shipping() : false;
$checkout_url = wc_get_checkout_url();
?>

<div class="lg:flex lg:min-h-full lg:flex-row-reverse">

  <h1 class="sr-only"><?php esc_html_e('Checkout', 'woocommerce'); ?></h1>

  <section aria-labelledby="order-heading" class="bg-slate-50 px-4 py-6 sm:px-6 lg:hidden">
    <div class="mx-auto max-w-lg">
      <div class="flex items-center justify-between">
        <h2 id="order-heading" class="text-lg font-medium text-slate-900"><?php esc_html_e('Your Order', 'woocommerce'); ?></h2>
        <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500" aria-controls="disclosure-1" aria-expanded="true" id="checkout-summary-toggle">
          <span class="show-summary"><?php esc_html_e('Hide full summary', 'woocommerce'); ?></span>
          <span class="hide-summary hidden"><?php esc_html_e('Show full summary', 'woocommerce'); ?></span>
        </button>
      </div>

      <div id="disclosure-1" class="mt-6">
        <ul role="list" class="divide-y divide-slate-200 border-b border-slate-200">
          <?php if (! empty($cart_items)) : ?>
            <?php foreach ($cart_items as $cart_item_key => $cart_item) :
              $product = $cart_item['data'];
              if (! $product) {
                continue;
              }
              $product_id = $cart_item['product_id'];
              $is_visible = $product->is_visible();
              $product_link = $is_visible ? $product->get_permalink($cart_item) : '';
              $thumbnail = $product->get_image(array(120, 120));
              $product_name = apply_filters('woocommerce_cart_item_name', $product->get_name(), $cart_item, $cart_item_key);
              $variation = $cart_item['variation'] ? wc_get_formatted_variation($product, true) : '';
              $cart_item_data = wc_get_formatted_cart_item_data($cart_item);
              $remove_url = esc_url(apply_filters('woocommerce_cart_item_remove_link', wc_get_cart_remove_url($cart_item_key), $cart_item_key));
            ?>
              <li class="flex space-x-6 py-6">
                <img src="<?php echo esc_url(wp_get_attachment_image_url($product->get_image_id(), 'thumbnail')); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" class="size-40 flex-none rounded-md bg-slate-200 object-cover" />
                <div class="flex flex-1 flex-col justify-between space-y-4">
                  <div class="space-y-1 text-sm font-medium">
                    <h3 class="text-slate-900"><?php echo $product_link ? '<a href="' . esc_url($product_link) . '" class="hover:text-slate-700">' . wp_kses_post($product_name) . '</a>' : wp_kses_post($product_name); ?></h3>
                    <p class="text-slate-900"><?php echo wp_kses_post(wc_price($product->get_price())); ?></p>
                    <?php if ($variation) : ?><p class="text-slate-500"><?php echo wp_kses_post($variation); ?></p><?php endif; ?>
                  </div>
                  <div class="flex space-x-4 text-sm">
                    <?php if ($product_link) : ?>
                      <a href="<?php echo esc_url($product_link); ?>" class="text-indigo-600 hover:text-indigo-500"><?php esc_html_e('Edit', 'woocommerce'); ?></a>
                    <?php endif; ?>
                    <a href="<?php echo $remove_url; ?>" class="text-indigo-600 hover:text-indigo-500"><?php esc_html_e('Remove', 'woocommerce'); ?></a>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          <?php else : ?>
            <li class="py-6 text-sm text-slate-600"><?php esc_html_e('Your order is empty.', 'woocommerce'); ?></li>
          <?php endif; ?>
        </ul>

        <?php if (wc_coupons_enabled()) : ?>
          <form class="mt-10" action="<?php echo esc_url($checkout_url); ?>" method="post">
            <label for="coupon_code_mobile" class="block text-sm font-medium text-slate-700"><?php esc_html_e('Discount code', 'woocommerce'); ?></label>
            <div class="mt-1 flex space-x-4">
              <input type="text" id="coupon_code_mobile" name="coupon_code" class="block w-full rounded-md bg-white px-3 py-2 text-base text-slate-900 outline-1 outline-offset-1 outline-slate-300 placeholder:text-slate-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm" placeholder="<?php esc_attr_e('Enter discount code', 'woocommerce'); ?>" />
              <button type="submit" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>" class="rounded-md bg-slate-200 px-4 text-sm font-medium text-slate-600 hover:bg-slate-300 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-50 focus:outline-hidden"><?php esc_html_e('Apply', 'woocommerce'); ?></button>
            </div>
            <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
          </form>
        <?php endif; ?>

        <dl class="mt-10 space-y-6 text-sm font-medium text-slate-500">
          <div class="flex justify-between">
            <dt><?php esc_html_e('Subtotal', 'woocommerce'); ?></dt>
            <dd class="text-slate-900"><?php echo WC()->cart->get_cart_subtotal(); ?></dd>
          </div>

          <?php if ($has_discount) : ?>
            <div class="flex justify-between">
              <dt class="flex items-center">
                <?php esc_html_e('Discount', 'woocommerce'); ?>
                <?php if ($primary_coupon) : ?>
                  <span class="ml-2 rounded-full bg-slate-200 px-2 py-0.5 text-xs tracking-wide text-slate-600"><?php echo esc_html($primary_coupon); ?></span>
                <?php endif; ?>
              </dt>
              <dd class="text-slate-900">-<?php echo wp_kses_post(wc_price(abs(WC()->cart->get_cart_discount_total()))); ?></dd>
            </div>
          <?php endif; ?>

          <?php if ($tax_total) : ?>
            <div class="flex justify-between">
              <dt><?php esc_html_e('Taxes', 'woocommerce'); ?></dt>
              <dd class="text-slate-900"><?php echo wp_kses_post(wc_price($tax_total)); ?></dd>
            </div>
          <?php endif; ?>

          <?php if ($has_shipping) : ?>
            <div class="flex justify-between">
              <dt><?php esc_html_e('Shipping', 'woocommerce'); ?></dt>
              <dd class="text-slate-900"><?php echo wp_kses_post($shipping_total); ?></dd>
            </div>
          <?php endif; ?>
        </dl>

        <p class="mt-6 flex items-center justify-between border-t border-slate-200 pt-6 text-base font-medium text-slate-900">
          <span><?php esc_html_e('Total', 'woocommerce'); ?></span>
          <span><?php echo wp_kses_post(WC()->cart->get_total()); ?></span>
        </p>
      </div>
    </div>
  </section>

  <section aria-labelledby="summary-heading" class="hidden w-full max-w-md flex-col bg-slate-50 lg:flex lg:flex-none lg:w-88 lg:max-w-88 lg:sticky lg:top-0 lg:h-screen lg:overflow-hidden lg:border-l lg:border-slate-200 lg:bg-slate-50">
    <h2 id="summary-heading" class="sr-only"><?php esc_html_e('Order summary', 'woocommerce'); ?></h2>

    <ul role="list" class="flex-auto divide-y divide-slate-200 overflow-y-auto px-6">
      <?php if (! empty($cart_items)) : ?>
        <?php foreach ($cart_items as $cart_item_key => $cart_item) :
          $product = $cart_item['data'];
          if (! $product) {
            continue;
          }
          $product_link = $product->is_visible() ? $product->get_permalink($cart_item) : '';
          $thumbnail = $product->get_image(array(120, 120));
          $product_name = apply_filters('woocommerce_cart_item_name', $product->get_name(), $cart_item, $cart_item_key);
          $variation = $cart_item['variation'] ? wc_get_formatted_variation($product, true) : '';
          $remove_url = esc_url(apply_filters('woocommerce_cart_item_remove_link', wc_get_cart_remove_url($cart_item_key), $cart_item_key));
        ?>
          <li class="flex space-x-6 py-6">
            <img src="<?php echo esc_url(wp_get_attachment_image_url($product->get_image_id(), 'thumbnail')); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" class="size-40 flex-none rounded-md bg-slate-200 object-cover" />
            <div class="flex flex-1 flex-col justify-between space-y-4">
              <div class="space-y-1 text-sm font-medium">
                <h3 class="text-slate-900"><?php echo $product_link ? '<a href="' . esc_url($product_link) . '" class="hover:text-slate-700">' . wp_kses_post($product_name) . '</a>' : wp_kses_post($product_name); ?></h3>
                <p class="text-slate-900"><?php echo wp_kses_post(wc_price($product->get_price())); ?></p>
                <?php if ($variation) : ?><p class="text-slate-500"><?php echo wp_kses_post($variation); ?></p><?php endif; ?>
              </div>
              <div class="flex space-x-4">
                <?php if ($product_link) : ?>
                  <a href="<?php echo esc_url($product_link); ?>" class="text-indigo-600 hover:text-indigo-500"><?php esc_html_e('Edit', 'woocommerce'); ?></a>
                <?php endif; ?>
                <a href="<?php echo $remove_url; ?>" class="text-indigo-600 hover:text-indigo-500"><?php esc_html_e('Remove', 'woocommerce'); ?></a>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      <?php else : ?>
        <li class="py-6 text-sm text-slate-600"><?php esc_html_e('Your order is empty.', 'woocommerce'); ?></li>
      <?php endif; ?>
    </ul>

    <div class="sticky bottom-0 flex-none border-t border-slate-200 bg-slate-50 p-6">
      <?php if (wc_coupons_enabled()) : ?>
        <form action="<?php echo esc_url($checkout_url); ?>" method="post">
          <label for="coupon_code" class="block text-sm font-medium text-slate-700"><?php esc_html_e('Discount code', 'woocommerce'); ?></label>
          <div class="mt-1 flex space-x-4">
            <input type="text" id="coupon_code" name="coupon_code" class="block w-full rounded-md bg-white px-3 py-2 text-base text-slate-900 outline-1 outline-offset-1 outline-slate-300 placeholder:text-slate-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm" placeholder="<?php esc_attr_e('Enter discount code', 'woocommerce'); ?>" />
            <button type="submit" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>" class="rounded-md bg-slate-200 px-4 text-sm font-medium text-slate-600 hover:bg-slate-300 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-50 focus:outline-hidden"><?php esc_html_e('Apply', 'woocommerce'); ?></button>
          </div>
          <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
        </form>
      <?php endif; ?>

      <dl class="mt-10 space-y-6 text-sm font-medium text-slate-500">
        <div class="flex justify-between">
          <dt><?php esc_html_e('Subtotal', 'woocommerce'); ?></dt>
          <dd class="text-slate-900"><?php echo WC()->cart->get_cart_subtotal(); ?></dd>
        </div>

        <?php if ($has_discount) : ?>
          <div class="flex justify-between">
            <dt class="flex items-center">
              <?php esc_html_e('Discount', 'woocommerce'); ?>
              <?php if ($primary_coupon) : ?>
                <span class="ml-2 rounded-full bg-slate-200 px-2 py-0.5 text-xs tracking-wide text-slate-600"><?php echo esc_html($primary_coupon); ?></span>
              <?php endif; ?>
            </dt>
            <dd class="text-slate-900">-<?php echo wp_kses_post(wc_price(abs(WC()->cart->get_cart_discount_total()))); ?></dd>
          </div>
        <?php endif; ?>

        <?php if ($tax_total) : ?>
          <div class="flex justify-between">
            <dt><?php esc_html_e('Taxes', 'woocommerce'); ?></dt>
            <dd class="text-slate-900"><?php echo wp_kses_post(wc_price($tax_total)); ?></dd>
          </div>
        <?php endif; ?>

        <?php if ($has_shipping) : ?>
          <div class="flex justify-between">
            <dt><?php esc_html_e('Shipping', 'woocommerce'); ?></dt>
            <dd class="text-slate-900"><?php echo wp_kses_post($shipping_total); ?></dd>
          </div>
        <?php endif; ?>

        <div class="flex items-center justify-between border-t border-slate-200 pt-6 text-slate-900">
          <dt class="text-base"><?php esc_html_e('Total', 'woocommerce'); ?></dt>
          <dd class="text-base"><?php echo wp_kses_post(WC()->cart->get_total()); ?></dd>
        </div>
      </dl>
    </div>
  </section>

  <section aria-labelledby="payment-heading" class="flex-auto px-4 pt-12 sm:px-6 sm:pt-16 lg:px-8 lg:pt-0">
    <div class="mx-auto max-w-lg">

      <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url($checkout_url); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__('Checkout', 'woocommerce'); ?>">
        <?php if ($checkout->get_checkout_fields()) : ?>
          <?php do_action('woocommerce_checkout_before_customer_details'); ?>

          <div class="grid grid-cols-12 gap-x-4 gap-y-6">
            <div class="col-span-full">
              <h2 id="payment-heading" class="text-lg font-semibold text-slate-900"><?php esc_html_e('Payment details', 'woocommerce'); ?></h2>
            </div>

            <div class="col-span-full lg:col-span-12">
              <?php do_action('woocommerce_checkout_billing'); ?>
              <?php do_action('woocommerce_checkout_shipping'); ?>
            </div>
          </div>

          <?php do_action('woocommerce_checkout_after_customer_details'); ?>
        <?php endif; ?>

        <div class="mt-10 romonet-woocommerce-payment">
          <?php
          // The custom checkout layout already renders an order summary above.
          // Remove WooCommerce's default order review summary and keep only payment rendering.
          remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
          do_action('woocommerce_checkout_before_order_review');
          do_action('woocommerce_checkout_order_review');
          do_action('woocommerce_checkout_after_order_review');
          ?>
        </div>
      </form>
    </div>
  </section>
</div>

<script type="text/javascript">
  (function() {
    var toggleButton = document.getElementById('checkout-summary-toggle');
    var details = document.getElementById('disclosure-1');
    if (!toggleButton || !details) {
      return;
    }

    toggleButton.addEventListener('click', function() {
      var expanded = toggleButton.getAttribute('aria-expanded') === 'true';
      toggleButton.setAttribute('aria-expanded', expanded ? 'false' : 'true');
      details.classList.toggle('hidden');
      toggleButton.querySelector('.show-summary').classList.toggle('hidden');
      toggleButton.querySelector('.hide-summary').classList.toggle('hidden');
    });
  })();
</script>
