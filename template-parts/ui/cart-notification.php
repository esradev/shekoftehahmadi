<?php

if (! defined('ABSPATH')) {
  exit;
}

$cart_url     = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/');
$checkout_url = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/');

get_template_part(
  'template-parts/ui/toast-notification',
  null,
  array(
    'notice_attr' => 'data-romonet-cart-notice',
    'close_attr'  => 'data-romonet-cart-notice-close',
    'message'     => 'محصول شما به سبد خرید اضافه شد.',
    'actions'     => array(
      array(
        'label'   => 'مشاهده سبد',
        'url'     => $cart_url,
        'primary' => true,
      ),
      array(
        'label' => 'پرداخت',
        'url'   => $checkout_url,
      ),
    ),
  )
);
