<?php

/**
 * Cart Page
 *
 * This template is a custom WooCommerce cart page override.
 * It keeps WooCommerce cart actions intact while customizing the UI.
 */

if (! defined('ABSPATH')) {
  exit;
}

$cart_url     = wc_get_cart_url();
$checkout_url = wc_get_checkout_url();
$shop_url     = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/');
?>

<div class="bg-white py-12" data-romonet-cart-page>
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <?php wc_print_notices(); ?>

    <form class="woocommerce-cart-form" action="<?php echo esc_url($cart_url); ?>" method="post">
      <?php do_action('woocommerce_before_cart'); ?>

      <div class="lg:grid lg:grid-cols-[1.4fr_0.8fr] lg:gap-x-12 lg:items-start">
        <div class="space-y-8">
          <div class="flex items-center justify-between border-b border-slate-200 pb-6">
            <div>
              <h1 class="text-3xl font-bold tracking-tight text-slate-900">سبد خرید شما</h1>
              <p class="mt-2 text-sm text-slate-500">محصولات دیجیتال شما در یک مکان و با تجربه‌ای ساده برای تکمیل خرید.</p>
            </div>
            <div class="hidden sm:block text-sm text-slate-500"><?php echo WC()->cart->get_cart_contents_count() . ' محصول'; ?></div>
          </div>

          <?php if (WC()->cart->is_empty()) : ?>
            <div class="mt-12 rounded-4xl border border-slate-200 bg-slate-50 p-10 text-center text-slate-600">
              <p class="text-lg font-medium text-slate-900">سبد خرید شما خالی است.</p>
              <p class="mt-3">محصولات دیجیتال ما را مشاهده کنید و دوباره شروع کنید.</p>
              <a href="<?php echo esc_url($shop_url); ?>" class="mt-6 inline-flex rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">بازگشت به فروشگاه</a>
            </div>
          <?php else : ?>
            <ul role="list" class="mt-8 divide-y divide-slate-200 border-t border-slate-200">
              <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                $product      = $cart_item['data'];
                $product_id   = $cart_item['product_id'];
                $is_visible   = $product && $product->is_visible();
                $product_link = $is_visible ? $product->get_permalink($cart_item) : '';
                $thumbnail    = $product ? $product->get_image(array(120, 120)) : '';
                $product_name = $product ? apply_filters('woocommerce_cart_item_name', $product->get_name(), $cart_item, $cart_item_key) : '';
                $variation    = $cart_item['variation'] ? wc_get_formatted_variation($product, true) : '';
                $cart_item_data = wc_get_formatted_cart_item_data($cart_item);
              ?>
                <li class="py-8 sm:flex sm:items-center sm:justify-between">
                  <div class="sm:flex sm:items-center sm:gap-6">
                    <div class="h-28 w-28 overflow-hidden rounded-3xl bg-slate-100">
                      <?php echo $thumbnail; ?>
                    </div>
                    <div class="mt-4 sm:mt-0">
                      <h2 class="text-base font-semibold text-slate-900">
                        <?php if ($product_link) : ?>
                          <a href="<?php echo esc_url($product_link); ?>" class="hover:text-slate-700"><?php echo wp_kses_post($product_name); ?></a>
                        <?php else : ?>
                          <?php echo wp_kses_post($product_name); ?>
                        <?php endif; ?>
                      </h2>
                      <?php if ($variation) : ?><p class="mt-2 text-sm text-slate-500"><?php echo wp_kses_post($variation); ?></p><?php endif; ?>
                      <?php if ($cart_item_data) : ?><div class="mt-2 text-sm text-slate-500"><?php echo wp_kses_post($cart_item_data); ?></div><?php endif; ?>
                    </div>
                  </div>

                  <div class="mt-6 grid gap-3 sm:mt-0 sm:w-56">
                    <div class="mt-4 sm:mt-0 sm:w-56 space-y-3 text-sm text-slate-500">

                      <div class="grid gap-3 sm:grid-cols-[1fr_auto]">
                        <div class="rounded-3xl border border-slate-200 bg-white p-4">
                          <?php if ($product && $product->is_sold_individually()) : ?>
                            <span class="text-sm text-slate-500">تکی</span>
                          <?php else : ?>
                            <?php
                            echo woocommerce_quantity_input(array(
                              'input_name'  => "cart[{$cart_item_key}][qty]",
                              'input_value' => $cart_item['quantity'],
                              'max_value'   => $product->get_max_purchase_quantity(),
                              'min_value'   => 1,
                              'product_name' => $product->get_name(),
                            ), $product, false);
                            ?>
                          <?php endif; ?>
                        </div>
                        <a href="<?php echo esc_url(apply_filters('woocommerce_cart_item_remove_link', wc_get_cart_remove_url($cart_item_key), $cart_item_key)); ?>" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-red-500 text-white transition hover:bg-red-600" aria-label="حذف محصول" title="حذف محصول">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                          </svg>
                        </a>
                      </div>
                      <p>جمع: <span class="font-semibold text-slate-900"><?php echo wp_kses_post(WC()->cart->get_product_subtotal($product, $cart_item['quantity'])); ?></span></p>
                    </div>
                </li>
              <?php endforeach; ?>
            </ul>

            <?php do_action('woocommerce_cart_contents'); ?>

            <div class="mt-8 rounded-4xl border border-slate-200 bg-slate-50 p-6">
              <?php if (wc_coupons_enabled()) : ?>
                <div class="grid gap-3 sm:grid-cols-[1fr_auto]">
                  <label for="coupon_code" class="sr-only">کد کوپن</label>
                  <input type="text" name="coupon_code" id="coupon_code" class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:ring-2 focus:ring-slate-300" placeholder="کد تخفیف را وارد کنید" value="<?php echo isset($_POST['coupon_code']) ? esc_attr(wp_unslash($_POST['coupon_code'])) : ''; ?>" />
                  <button type="submit" class="rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-700" name="apply_coupon" value="Apply coupon">اعمال</button>
                </div>
              <?php endif; ?>

              <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-700" name="update_cart" value="Update cart">به‌روزرسانی سبد</button>
              </div>
              <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
              <?php do_action('woocommerce_cart_actions'); ?>
            </div>
          <?php endif; ?>
        </div>

        <?php if (! WC()->cart->is_empty()) : ?>
          <aside class="mt-10 lg:mt-0 lg:self-start lg:sticky lg:top-24">
            <div class="rounded-4xl border border-slate-200 bg-slate-50 p-8">
              <h2 class="text-lg font-semibold text-slate-900">خلاصه سفارش</h2>
              <dl class="mt-6 space-y-4 text-sm text-slate-600">
                <div class="flex justify-between">
                  <dt>جمع جزئی</dt>
                  <dd class="font-medium text-slate-900"><?php echo WC()->cart->get_cart_subtotal(); ?></dd>
                </div>
                <?php if (WC()->cart->get_cart_contents_tax()) : ?>
                  <div class="flex justify-between">
                    <dt>مالیات</dt>
                    <dd class="font-medium text-slate-900"><?php echo wc_price(WC()->cart->get_taxes_total()); ?></dd>
                  </div>
                <?php endif; ?>
                <?php if (WC()->cart->get_cart_discount_total()) : ?>
                  <div class="flex justify-between">
                    <dt>تخفیف</dt>
                    <dd class="font-medium text-slate-900">-<?php echo wc_price(abs(WC()->cart->get_discount_total())); ?></dd>
                  </div>
                <?php endif; ?>
                <div class="flex justify-between border-t border-slate-200 pt-4 text-base font-semibold text-slate-900">
                  <dt>جمع کل</dt>
                  <dd><?php echo WC()->cart->get_cart_total(); ?></dd>
                </div>
              </dl>

              <div class="mt-8 space-y-3">
                <a href="<?php echo esc_url($checkout_url); ?>" class="block rounded-full bg-slate-900 px-6 py-3 text-center text-sm font-semibold text-white transition hover:bg-slate-700">پرداخت نهایی</a>
                <a href="<?php echo esc_url($shop_url); ?>" class="block rounded-full border border-slate-200 bg-white px-6 py-3 text-center text-sm font-semibold text-slate-900 transition hover:bg-slate-100">ادامه خرید</a>
              </div>
            </div>
          </aside>
        <?php endif; ?>
      </div>

      <?php do_action('woocommerce_after_cart'); ?>
    </form>
  </div>
</div>

<script type="text/javascript">
  (function() {
    var cartForm = document.querySelector('.woocommerce-cart-form');
    var cartSection = document.querySelector('[data-romonet-cart-page]');
    if (!cartForm || !cartSection) {
      return;
    }

    function initQuantityAjax() {
      var qtyInputs = cartForm.querySelectorAll('input.qty');
      qtyInputs.forEach(function(input) {
        input.removeEventListener('change', onQtyChange);
        input.addEventListener('change', onQtyChange);
      });
    }

    function onQtyChange() {
      if (window.romonetCartUpdateTimer) {
        clearTimeout(window.romonetCartUpdateTimer);
      }
      window.romonetCartUpdateTimer = setTimeout(function() {
        updateCartAjax();
      }, 400);
    }

    function updateCartAjax() {
      if (!cartForm) {
        return;
      }

      var formData = new FormData(cartForm);
      formData.set('update_cart', 'Update cart');

      fetch(cartForm.action, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      }).then(function(response) {
        return response.text();
      }).then(function(html) {
        var parser = new DOMParser();
        var doc = parser.parseFromString(html, 'text/html');
        var newSection = doc.querySelector('[data-romonet-cart-page]');
        if (newSection && cartSection.parentNode) {
          cartSection.parentNode.replaceChild(newSection, cartSection);
          cartSection = document.querySelector('[data-romonet-cart-page]');
          cartForm = cartSection ? cartSection.querySelector('.woocommerce-cart-form') : null;
          initQuantityAjax();
        }
      }).catch(function(error) {
        console.error('Cart update failed', error);
      });
    }

    initQuantityAjax();
  })();
</script>
