<?php

/**
 * Site header template part.
 */

if (! defined('ABSPATH')) {
  exit;
}

$account_url  = esc_url(home_url('/my-account/'));
$logout_url   = esc_url(wp_logout_url(home_url('/my-account/')));
$cart_url     = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/');
$checkout_url = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/');
$cart_count   = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
$cart_items   = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart() : array();
?>

<div
  x-data="{ mobileMenuOpen: false, accountMenuOpen: false, cartMenuOpen: false }"
  x-effect="document.body.classList.toggle('overflow-hidden', mobileMenuOpen)"
  @keydown.escape.window="mobileMenuOpen = false; accountMenuOpen = false; cartMenuOpen = false"
  class="text-white">

  <!-- Top bar: secondary links & contact info (scrolls away) -->
  <div class="border-b border-white/5 bg-slate-900 text-slate-400">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-x-6 gap-y-2 px-4 py-2 text-xs sm:px-6 lg:px-8">
      <div class="flex flex-wrap items-center gap-x-5 gap-y-1">
        <span class="hidden items-center gap-1.5 sm:inline-flex">
          <svg class="h-3.5 w-3.5 shrink-0 text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg>
          <span>شنبه تا پنج‌شنبه، ۹ تا ۱۸</span>
        </span>
        <a href="tel:+982112345678" class="inline-flex items-center gap-1.5 transition hover:text-white" dir="ltr">
          <svg class="h-3.5 w-3.5 shrink-0 text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
          </svg>
          ۰۲۱-۱۲۳۴۵۶۷۸
        </a>
        <a href="mailto:info@romonet.ir" class="hidden items-center gap-1.5 transition hover:text-white md:inline-flex" dir="ltr">
          <svg class="h-3.5 w-3.5 shrink-0 text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
          </svg>
          info@romonet.ir
        </a>
      </div>

      <nav class="hidden items-center lg:flex" aria-label="منوی ثانویه">
        <?php
        add_filter('nav_menu_link_attributes', 'romonet_top_bar_nav_menu_link_attributes', 10, 4);
        wp_nav_menu(
          array(
            'theme_location' => 'top-bar',
            'container'      => false,
            'menu_class'     => 'flex flex-wrap items-center gap-x-5 gap-y-1',
            'fallback_cb'    => 'romonet_top_bar_menu_fallback',
            'depth'          => 1,
          )
        );
        remove_filter('nav_menu_link_attributes', 'romonet_top_bar_nav_menu_link_attributes', 10, 4);
        ?>
      </nav>
    </div>
  </div>

  <!-- Primary header: sticky on scroll -->
  <header class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/90 text-white backdrop-blur-xl">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between gap-4 lg:h-[4.5rem]">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex shrink-0 items-center gap-3 rounded-xl px-1 py-1" aria-label="رومونت">
          <span class="grid h-10 w-10 place-items-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-950/30 lg:h-11 lg:w-11">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M3 12a9 9 0 1 0 18 0 9 9 0 0 0-18 0Z" />
              <path d="m4 9 4.5 11L12 9l3.5 11L20 9" />
            </svg>
          </span>
          <span class="hidden sm:block">
            <span class="block text-base font-extrabold leading-none text-white lg:text-lg">رومونت</span>
            <span class="mt-0.5 block text-[11px] text-slate-400 lg:mt-1 lg:text-xs">طراحی و توسعه وردپرس</span>
          </span>
        </a>

        <nav class="hidden items-center gap-6 lg:flex" aria-label="منوی اصلی">
          <?php
          wp_nav_menu(
            array(
              'theme_location' => 'primary',
              'container'      => false,
              'menu_class'     => 'flex items-center gap-6 text-sm font-semibold text-white',
              'fallback_cb'    => 'romonet_primary_menu_fallback',
              'depth'          => 1,
            )
          );
          ?>
        </nav>

        <div class="flex items-center gap-2 sm:gap-3">
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="hidden rounded-full border border-white/15 px-4 py-2 text-sm font-medium text-slate-200 transition hover:border-white/30 hover:text-white xl:inline-flex">مشاوره رایگان</a>
          <a href="<?php echo esc_url(home_url('/project-request/')); ?>" class="hidden rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-blue-950/30 transition hover:bg-blue-500 lg:inline-flex">ثبت پروژه</a>

          <div class="relative" @click.away="cartMenuOpen = false">
            <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/15 text-white transition hover:border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-500" @click="cartMenuOpen = !cartMenuOpen; accountMenuOpen = false" :aria-expanded="cartMenuOpen.toString()" aria-haspopup="true" aria-label="نمایش سبد خرید">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
              </svg>

              <?php if ($cart_count) : ?>
                <span data-romonet-cart-badge class="absolute -right-1 -top-1 h-5 min-w-5 items-center justify-center rounded-full bg-white px-1.5 text-xs font-semibold text-slate-950" style="display:inline-flex"><?php echo esc_html($cart_count); ?></span>
              <?php else : ?>
                <span data-romonet-cart-badge class="absolute -right-1 -top-1 h-5 min-w-5 items-center justify-center rounded-full bg-white px-1.5 text-xs font-semibold text-slate-950" style="display:none"></span>
              <?php endif; ?>
            </button>

            <div x-cloak x-show="cartMenuOpen" x-transition class="absolute left-0 z-50 mt-2 w-80 max-w-[calc(100vw-1rem)] overflow-hidden rounded-3xl border border-white/10 bg-slate-950 text-sm shadow-xl shadow-black/25 ring-1 ring-white/10">
              <div class="border-b border-white/10 px-4 py-4">
                <div class="flex items-center justify-between text-sm font-medium text-slate-200">
                  <span>سبد خرید</span>
                  <span data-romonet-cart-count class="text-slate-400"><?php echo esc_html($cart_count); ?> آیتم</span>
                </div>
              </div>
              <div data-romonet-cart-items class="max-h-72 overflow-y-auto px-4 py-3">
                <?php if (empty($cart_items)) : ?>
                  <div class="rounded-3xl bg-slate-900 px-4 py-5 text-center text-slate-300">سبد خرید شما خالی است.</div>
                <?php else : ?>
                  <?php foreach ($cart_items as $cart_item_key => $cart_item) :
                    $product = $cart_item['data'];
                    if (! $product || ! $product->exists()) {
                      continue;
                    }
                    $product_name      = $product->get_name();
                    $product_qty       = intval($cart_item['quantity']);
                    $product_price     = wc_price(WC()->cart->get_product_subtotal($product, $product_qty));
                    $product_permalink = $product->is_visible() ? $product->get_permalink() : '';
                  ?>
                    <div class="flex items-start gap-3 border-b border-white/10 py-3 last:border-b-0">
                      <div class="inline-flex h-8 w-8 flex-none items-center justify-center rounded-full border border-white/10 bg-slate-900 text-slate-400 transition hover:bg-slate-800 hover:text-white" data-romonet-remove-cart-item="<?php echo esc_attr($cart_item_key); ?>" aria-label="حذف محصول">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 7V5.5a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5V7" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 11.25v6.75m3.75-6.75v6.75m3.75-6.75v6.75" />
                        </svg>
                      </div>
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
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
              <div class="space-y-3 border-t border-white/10 px-4 py-4">
                <div class="flex items-center justify-between text-sm text-slate-300">
                  <span>جمع سبد خرید</span>
                  <span data-romonet-cart-subtotal class="font-semibold text-white"><?php echo function_exists('WC') && WC()->cart ? wp_kses_post(WC()->cart->get_cart_subtotal()) : '&mdash;'; ?></span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                  <a href="<?php echo esc_url($cart_url); ?>" class="inline-flex items-center justify-center rounded-full border border-white/15 bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-900/90">مشاهده سبد</a>
                  <a href="<?php echo esc_url($checkout_url); ?>" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-500">تسویه حساب</a>
                </div>
              </div>
            </div>
          </div>

          <div class="relative hidden sm:block" @click.away="accountMenuOpen = false">
            <?php if (is_user_logged_in()) : ?>
              <?php $current_user = wp_get_current_user(); ?>
              <button type="button" class="inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full border border-white/15 bg-slate-900 text-white transition hover:border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-500" @click="accountMenuOpen = !accountMenuOpen; cartMenuOpen = false" :aria-expanded="accountMenuOpen.toString()" aria-haspopup="true" aria-label="باز کردن منوی حساب">
                <?php echo get_avatar($current_user->ID, 34, '', '', array('class' => 'h-10 w-10 rounded-full object-cover')); ?>
              </button>
              <div x-cloak x-show="accountMenuOpen" x-transition class="absolute right-0 z-50 mt-2 w-52 origin-top-right overflow-hidden rounded-3xl border border-white/10 bg-slate-950 text-sm shadow-xl shadow-black/25 ring-1 ring-white/10">
                <a href="<?php echo $account_url; ?>" class="block px-4 py-3 text-slate-200 transition hover:bg-slate-900">حساب کاربری</a>
                <a href="<?php echo $logout_url; ?>" class="block px-4 py-3 text-slate-200 transition hover:bg-slate-900">خروج</a>
              </div>
            <?php else : ?>
              <a href="<?php echo $account_url; ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/15 text-white transition hover:border-white/30" aria-label="ورود یا ثبت‌نام">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
              </a>
            <?php endif; ?>
          </div>

          <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/15 text-white transition hover:border-white/30 lg:hidden" @click="mobileMenuOpen = !mobileMenuOpen; cartMenuOpen = false; accountMenuOpen = false" :aria-expanded="mobileMenuOpen.toString()" aria-controls="mobile-menu-panel" aria-label="باز کردن منو">
            <svg x-show="!mobileMenuOpen" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg x-show="mobileMenuOpen" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- Mobile flyout: slides in from the right -->
  <div x-cloak x-show="mobileMenuOpen" class="fixed inset-0 z-[60] lg:hidden" role="dialog" aria-modal="true" aria-label="منوی موبایل">
    <div
      x-show="mobileMenuOpen"
      x-transition:enter="transition-opacity ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition-opacity ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm"
      @click="mobileMenuOpen = false"
      aria-hidden="true"></div>

    <div
      id="mobile-menu-panel"
      x-show="mobileMenuOpen"
      x-transition:enter="transform transition ease-out duration-300"
      x-transition:enter-start="translate-x-full"
      x-transition:enter-end="translate-x-0"
      x-transition:leave="transform transition ease-in duration-200"
      x-transition:leave-start="translate-x-0"
      x-transition:leave-end="translate-x-full"
      class="romonet-mobile-flyout absolute inset-y-0 right-0 flex w-[min(100%,20rem)] flex-col border-l border-white/10 bg-slate-950 shadow-2xl shadow-black/40">

      <div class="flex items-center justify-between border-b border-white/10 px-5 py-4">
        <span class="text-sm font-bold text-white">منو</span>
        <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/15 text-white transition hover:border-white/30" @click="mobileMenuOpen = false" aria-label="بستن منو">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <div class="flex-1 overflow-y-auto px-5 py-5">
        <nav class="romonet-mobile-flyout__nav" aria-label="منوی اصلی موبایل">
          <?php
          wp_nav_menu(
            array(
              'theme_location' => 'primary',
              'container'      => false,
              'menu_class'     => 'space-y-1',
              'fallback_cb'    => 'romonet_primary_menu_fallback',
              'depth'          => 1,
            )
          );
          ?>
        </nav>

        <div class="mt-6 border-t border-white/10 pt-6">
          <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-500">صفحات بیشتر</p>
          <nav class="romonet-mobile-flyout__nav romonet-mobile-flyout__nav--secondary" aria-label="منوی ثانویه موبایل">
            <?php
            add_filter('nav_menu_link_attributes', 'romonet_top_bar_nav_menu_link_attributes', 10, 4);
            wp_nav_menu(
              array(
                'theme_location' => 'top-bar',
                'container'      => false,
                'menu_class'     => 'space-y-1',
                'fallback_cb'    => 'romonet_top_bar_menu_fallback',
                'depth'          => 1,
              )
            );
            remove_filter('nav_menu_link_attributes', 'romonet_top_bar_nav_menu_link_attributes', 10, 4);
            ?>
          </nav>
        </div>

        <div class="mt-6 space-y-3 border-t border-white/10 pt-6">
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="flex w-full items-center justify-center rounded-full border border-white/15 px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-white/30 hover:text-white">مشاوره رایگان</a>
          <a href="<?php echo esc_url(home_url('/project-request/')); ?>" class="flex w-full items-center justify-center rounded-full bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-950/30">ثبت پروژه</a>
        </div>

        <div class="mt-6 space-y-3 border-t border-white/10 pt-6 text-sm">
          <?php if (is_user_logged_in()) : ?>
            <a href="<?php echo $account_url; ?>" class="flex items-center gap-3 rounded-xl border border-white/10 bg-slate-900/60 px-4 py-3 text-slate-200 transition hover:border-white/20 hover:text-white">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
              </svg>
              حساب کاربری
            </a>
            <a href="<?php echo $logout_url; ?>" class="flex items-center gap-3 rounded-xl px-4 py-2 text-slate-400 transition hover:text-white">خروج از حساب</a>
          <?php else : ?>
            <a href="<?php echo $account_url; ?>" class="flex items-center gap-3 rounded-xl border border-white/10 bg-slate-900/60 px-4 py-3 text-slate-200 transition hover:border-white/20 hover:text-white">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
              </svg>
              ورود / ثبت‌نام
            </a>
          <?php endif; ?>
        </div>

        <div class="mt-6 space-y-2 border-t border-white/10 pt-6 text-xs text-slate-400">
          <a href="tel:+982112345678" class="flex items-center gap-2 transition hover:text-white" dir="ltr">
            <svg class="h-4 w-4 shrink-0 text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
            </svg>
            ۰۲۱-۱۲۳۴۵۶۷۸
          </a>
          <a href="mailto:info@romonet.ir" class="flex items-center gap-2 transition hover:text-white" dir="ltr">
            <svg class="h-4 w-4 shrink-0 text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
            </svg>
            info@romonet.ir
          </a>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var cartItemsContainer = document.querySelector('[data-romonet-cart-items]');
      if (!cartItemsContainer) {
        return;
      }

      cartItemsContainer.addEventListener('click', function(event) {
        var removeButton = event.target.closest('[data-romonet-remove-cart-item]');
        if (!removeButton) {
          return;
        }

        event.preventDefault();

        var cartItemKey = removeButton.getAttribute('data-romonet-remove-cart-item');
        if (!cartItemKey) {
          return;
        }

        var data = new URLSearchParams();
        data.append('action', 'romonet_remove_cart_item');
        data.append('cart_item_key', cartItemKey);

        fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
          },
          body: data.toString(),
        })
        .then(function(response) {
          return response.json();
        })
        .then(function(response) {
          if (!response.success || !response.data) {
            window.alert(response.data && response.data.message ? response.data.message : 'خطا در حذف آیتم');
            return;
          }

          updateMiniCartFragments(response.data);
        })
        .catch(function() {
          window.alert('خطا در اتصال به سرور');
        });
      });

      function updateMiniCartFragments(data) {
        if (!data) {
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
              if (response.success && response.data) {
                return updateMiniCartFragments(response.data);
              }
            });
        }

        var badge = document.querySelector('[data-romonet-cart-badge]');
        var count = document.querySelector('[data-romonet-cart-count]');
        var items = document.querySelector('[data-romonet-cart-items]');
        var subtotal = document.querySelector('[data-romonet-cart-subtotal]');

        if (badge) {
          if (data.cart_count > 0) {
            badge.textContent = data.cart_count;
            badge.style.display = 'inline-flex';
          } else {
            badge.textContent = '';
            badge.style.display = 'none';
          }
        }

        if (count) {
          count.textContent = data.cart_count_label;
        }

        if (items) {
          items.innerHTML = data.items_html;
        }

        if (subtotal) {
          subtotal.innerHTML = data.cart_subtotal;
        }

        if (typeof window.CustomEvent === 'function') {
          window.dispatchEvent(new CustomEvent('romonetCartFragmentsUpdated', {
            detail: { cartProductIds: data.cart_product_ids || [] }
          }));
        }
      }
    });
  </script>
</div>
