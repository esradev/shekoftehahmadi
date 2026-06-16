<?php
/**
 * Orders
 *
 * This template overrides WooCommerce orders with a custom layout.
 * It uses Tailwind CSS for styling and matches the checkout page design.
 *
 * @see https://woocommerce.com/document/template-structure/
 */

if (! defined('ABSPATH')) {
  exit;
}

do_action('woocommerce_before_account_orders', $has_orders);
?>

<?php if ($has_orders) : ?>

  <div class="overflow-hidden rounded-lg border border-slate-200">
    <table class="min-w-full divide-y divide-slate-200">
      <thead class="bg-slate-50">
        <tr>
          <?php foreach (wc_get_account_orders_columns() as $column_id => $column_name) : ?>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
              <?php echo esc_html($column_name); ?>
            </th>
          <?php endforeach; ?>
        </tr>
      </thead>

      <tbody class="divide-y divide-slate-200 bg-white">
        <?php
        foreach ($customer_orders->orders as $customer_order) {
          $order = wc_get_order($customer_order);
          $item_count = $order->get_item_count() - $order->get_item_count_refunded();
          ?>
          <tr class="hover:bg-slate-50">
            <?php foreach (wc_get_account_orders_columns() as $column_id => $column_name) :
              $is_order_number = 'order-number' === $column_id;
            ?>
              <?php if ($is_order_number) : ?>
                <th class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900" scope="row">
              <?php else : ?>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
              <?php endif; ?>

                <?php if (has_action('woocommerce_my_account_my_orders_column_' . $column_id)) : ?>
                  <?php do_action('woocommerce_my_account_my_orders_column_' . $column_id, $order); ?>

                <?php elseif ($is_order_number) : ?>
                  <a href="<?php echo esc_url($order->get_view_order_url()); ?>" 
                     class="text-indigo-600 hover:text-indigo-500"
                     aria-label="<?php echo esc_attr(sprintf(__('View order number %s', 'woocommerce'), $order->get_order_number())); ?>">
                    <?php echo esc_html(_x('#', 'hash before order number', 'woocommerce') . $order->get_order_number()); ?>
                  </a>

                <?php elseif ('order-date' === $column_id) : ?>
                  <time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>">
                    <?php echo esc_html(wc_format_datetime($order->get_date_created())); ?>
                  </time>

                <?php elseif ('order-status' === $column_id) : ?>
                  <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                    <?php
                    $status = $order->get_status();
                    $status_classes = array(
                      'completed' => 'bg-green-100 text-green-800',
                      'processing' => 'bg-blue-100 text-blue-800',
                      'pending' => 'bg-yellow-100 text-yellow-800',
                      'cancelled' => 'bg-red-100 text-red-800',
                      'refunded' => 'bg-gray-100 text-gray-800',
                      'failed' => 'bg-red-100 text-red-800',
                    );
                    echo isset($status_classes[$status]) ? $status_classes[$status] : 'bg-gray-100 text-gray-800';
                    ?>">
                    <?php echo esc_html(wc_get_order_status_name($order->get_status())); ?>
                  </span>

                <?php elseif ('order-total' === $column_id) : ?>
                  <?php
                  echo wp_kses_post(sprintf(_n('%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce'), $order->get_formatted_order_total(), $item_count));
                  ?>

                <?php elseif ('order-actions' === $column_id) : ?>
                  <?php
                  $actions = wc_get_account_orders_actions($order);

                  if (! empty($actions)) {
                    foreach ($actions as $key => $action) {
                      if (empty($action['aria-label'])) {
                        $action_aria_label = sprintf(__('%1$s order number %2$s', 'woocommerce'), $action['name'], $order->get_order_number());
                      } else {
                        $action_aria_label = $action['aria-label'];
                      }
                      echo '<a href="' . esc_url($action['url']) . '" 
                            class="mr-2 inline-flex rounded-md bg-white px-3 py-1.5 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50" 
                            aria-label="' . esc_attr($action_aria_label) . '">' . esc_html($action['name']) . '</a>';
                      unset($action_aria_label);
                    }
                  }
                  ?>
                <?php endif; ?>

              <?php if ($is_order_number) : ?>
                </th>
              <?php else : ?>
                </td>
              <?php endif; ?>
            <?php endforeach; ?>
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
  </div>

  <?php do_action('woocommerce_before_account_orders_pagination'); ?>

  <?php if (1 < $customer_orders->max_num_pages) : ?>
    <div class="mt-6 flex items-center justify-between">
      <?php if (1 !== $current_page) : ?>
        <a href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>" 
           class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50">
          <?php esc_html_e('Previous', 'woocommerce'); ?>
        </a>
      <?php endif; ?>

      <?php if (intval($customer_orders->max_num_pages) !== $current_page) : ?>
        <a href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>" 
           class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-500">
          <?php esc_html_e('Next', 'woocommerce'); ?>
        </a>
      <?php endif; ?>
    </div>
  <?php endif; ?>

<?php else : ?>

  <div class="rounded-lg bg-slate-50 p-8 text-center">
    <p class="text-slate-600">
      <?php esc_html_e('No order has been made yet.', 'woocommerce'); ?>
    </p>
    <a href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>" 
       class="mt-4 inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-500">
      <?php esc_html_e('Browse products', 'woocommerce'); ?>
    </a>
  </div>

<?php endif; ?>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>
