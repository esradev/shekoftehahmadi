<?php

/**
 * Form Admin Dashboard
 * 
 * This file creates admin dashboard pages to display contact and project request form entries.
 * 
 * @package Romonet
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu items
 */
function romonet_add_form_admin_menu() {
    // Main menu item
    add_menu_page(
        'فرم‌ها',
        'فرم‌ها',
        'manage_options',
        'romonet-forms',
        'romonet_contact_submissions_page',
        'dashicons-forms',
        30
    );
    
    // Contact submissions submenu
    add_submenu_page(
        'romonet-forms',
        'فرم‌های تماس',
        'فرم‌های تماس',
        'manage_options',
        'romonet-forms',
        'romonet_contact_submissions_page'
    );
    
    // Project submissions submenu
    add_submenu_page(
        'romonet-forms',
        'درخواست‌های پروژه',
        'درخواست‌های پروژه',
        'manage_options',
        'romonet-project-forms',
        'romonet_project_submissions_page'
    );

    // Newsletter subscribers submenu
    add_submenu_page(
        'romonet-forms',
        'مشترکین خبرنامه',
        'مشترکین خبرنامه',
        'manage_options',
        'romonet-newsletter-subscribers',
        'romonet_newsletter_subscribers_page'
    );
}
add_action('admin_menu', 'romonet_add_form_admin_menu');

/**
 * Contact submissions admin page
 */
function romonet_contact_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'romonet_contact_submissions';
    
    // Handle status update
    if (isset($_POST['romonet_update_status']) && isset($_POST['entry_id']) && check_admin_referer('romonet_update_status')) {
        $status = sanitize_text_field($_POST['status']);
        $entry_id = intval($_POST['entry_id']);
        $notes = isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : '';
        
        $wpdb->update(
            $table_name,
            array(
                'status' => $status,
                'notes' => $notes
            ),
            array('id' => $entry_id),
            array('%s', '%s'),
            array('%d')
        );
        
        echo '<div class="notice notice-success"><p>وضعیت با موفقیت به‌روزرسانی شد.</p></div>';
    }
    
    // Handle delete
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['entry_id'])) {
        check_admin_referer('romonet_delete_entry');
        $entry_id = intval($_GET['entry_id']);
        $wpdb->delete($table_name, array('id' => $entry_id), array('%d'));
        echo '<div class="notice notice-success"><p>ورودی با موفقیت حذف شد.</p></div>';
    }
    
    // Get pagination and filters
    $paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $per_page = 20;
    $offset = ($paged - 1) * $per_page;
    $status_filter = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
    
    // Build query
    $where = "WHERE 1=1";
    if ($status_filter) {
        $where .= $wpdb->prepare(" AND status = %s", $status_filter);
    }
    
    // Get total count
    $total = $wpdb->get_var("SELECT COUNT(*) FROM $table_name $where");
    $total_pages = ceil($total / $per_page);
    
    // Get entries
    $entries = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name $where ORDER BY submitted_at DESC LIMIT %d OFFSET %d",
            $per_page,
            $offset
        )
    );
    
    ?>
    <div class="wrap">
        <h1>فرم‌های تماس</h1>
        
        <!-- Filters -->
        <div class="tablenav top">
            <div class="alignleft actions">
                <form method="get" action="">
                    <input type="hidden" name="page" value="romonet-forms">
                    <select name="status">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="new" <?php selected($status_filter, 'new'); ?>>جدید</option>
                        <option value="contacted" <?php selected($status_filter, 'contacted'); ?>>تماس گرفته شده</option>
                        <option value="in_progress" <?php selected($status_filter, 'in_progress'); ?>>در حال بررسی</option>
                        <option value="completed" <?php selected($status_filter, 'completed'); ?>>تکمیل شده</option>
                        <option value="spam" <?php selected($status_filter, 'spam'); ?>>اسپم</option>
                    </select>
                    <input type="submit" class="button" value="فیلتر">
                </form>
            </div>
            <div class="tablenav-pages">
                <span class="displaying-num"><?php echo $total; ?> مورد</span>
                <?php if ($total_pages > 1) : ?>
                    <span class="pagination-links">
                        <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $class = $i === $paged ? 'class="pagination-link current"' : 'class="pagination-link"';
                            echo '<a ' . $class . ' href="' . admin_url('admin.php?page=romonet-forms&paged=' . $i . ($status_filter ? '&status=' . $status_filter : '')) . '">' . $i . '</a>';
                        }
                        ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Table -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>کد پیگیری</th>
                    <th>نام</th>
                    <th>ایمیل</th>
                    <th>تلفن</th>
                    <th>موضوع</th>
                    <th>وضعیت</th>
                    <th>تاریخ</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($entries) : ?>
                    <?php foreach ($entries as $entry) : ?>
                        <tr>
                            <td><code dir="ltr"><?php echo esc_html(romonet_get_submission_tracking_code($entry, 'contact')); ?></code></td>
                            <td>
                                <strong><?php echo esc_html($entry->name); ?></strong>
                                <?php if ($entry->company) : ?>
                                    <br><small><?php echo esc_html($entry->company); ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo esc_html($entry->email); ?></td>
                            <td><?php echo esc_html($entry->phone); ?></td>
                            <td><?php echo esc_html($entry->subject); ?></td>
                            <td>
                                <span class="status-<?php echo esc_attr($entry->status); ?>">
                                    <?php
                                    $status_labels = array(
                                        'new' => 'جدید',
                                        'contacted' => 'تماس گرفته شده',
                                        'in_progress' => 'در حال بررسی',
                                        'completed' => 'تکمیل شده',
                                        'spam' => 'اسپم'
                                    );
                                    echo isset($status_labels[$entry->status]) ? $status_labels[$entry->status] : $entry->status;
                                    ?>
                                </span>
                            </td>
                            <td><?php echo date_i18n('Y/m/d - H:i', strtotime($entry->submitted_at)); ?></td>
                            <td>
                                <a href="#" class="button button-small view-entry" data-entry-id="<?php echo $entry->id; ?>">مشاهده</a>
                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=romonet-forms&action=delete&entry_id=' . $entry->id), 'romonet_delete_entry'); ?>" class="button button-small" onclick="return confirm('آیا مطمئن هستید؟');">حذف</a>
                            </td>
                        </tr>
                        
                        <!-- Hidden detail row -->
                        <tr class="detail-row" id="detail-<?php echo $entry->id; ?>" style="display: none;">
                            <td colspan="8">
                                <div class="entry-detail" style="padding: 20px; background: #f9f9f9;">
                                    <p><strong>کد پیگیری:</strong> <code dir="ltr"><?php echo esc_html(romonet_get_submission_tracking_code($entry, 'contact')); ?></code></p>
                                    <h3>جزئیات پیام</h3>
                                    <p><?php echo nl2br(esc_html($entry->message)); ?></p>
                                    
                                    <?php if ($entry->ip_address) : ?>
                                        <p><strong>IP:</strong> <?php echo esc_html($entry->ip_address); ?></p>
                                    <?php endif; ?>
                                    
                                    <hr style="margin: 20px 0;">
                                    
                                    <form method="post" action="">
                                        <?php wp_nonce_field('romonet_update_status'); ?>
                                        <input type="hidden" name="entry_id" value="<?php echo $entry->id; ?>">
                                        <input type="hidden" name="romonet_update_status" value="1">
                                        
                                        <label>
                                            <strong>وضعیت:</strong>
                                            <select name="status" style="width: 200px; margin-left: 10px;">
                                                <option value="new" <?php selected($entry->status, 'new'); ?>>جدید</option>
                                                <option value="contacted" <?php selected($entry->status, 'contacted'); ?>>تماس گرفته شده</option>
                                                <option value="in_progress" <?php selected($entry->status, 'in_progress'); ?>>در حال بررسی</option>
                                                <option value="completed" <?php selected($entry->status, 'completed'); ?>>تکمیل شده</option>
                                                <option value="spam" <?php selected($entry->status, 'spam'); ?>>اسپم</option>
                                            </select>
                                        </label>
                                        
                                        <br><br>
                                        
                                        <label>
                                            <strong>یادداشت:</strong><br>
                                            <textarea name="notes" rows="3" style="width: 100%; max-width: 600px;"><?php echo esc_textarea($entry->notes); ?></textarea>
                                        </label>
                                        
                                        <br><br>
                                        
                                        <input type="submit" class="button button-primary" value="ذخیره تغییرات">
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 20px;">هیچ موردی یافت نشد.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('.view-entry').on('click', function(e) {
            e.preventDefault();
            var entryId = $(this).data('entry-id');
            $('#detail-' + entryId).toggle();
        });
    });
    </script>
    
    <style>
    .status-new { color: #d63638; font-weight: bold; }
    .status-contacted { color: #00a32a; }
    .status-in_progress { color: #dba617; }
    .status-completed { color: #00a32a; font-weight: bold; }
    .status-spam { color: #646970; }
    </style>
    <?php
}

/**
 * Project submissions admin page
 */
function romonet_project_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'romonet_project_submissions';
    
    // Handle status update
    if (isset($_POST['romonet_update_status']) && isset($_POST['entry_id']) && check_admin_referer('romonet_update_status')) {
        $status = sanitize_text_field($_POST['status']);
        $entry_id = intval($_POST['entry_id']);
        $notes = isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : '';
        
        $wpdb->update(
            $table_name,
            array(
                'status' => $status,
                'notes' => $notes
            ),
            array('id' => $entry_id),
            array('%s', '%s'),
            array('%d')
        );
        
        echo '<div class="notice notice-success"><p>وضعیت با موفقیت به‌روزرسانی شد.</p></div>';
    }
    
    // Handle delete
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['entry_id'])) {
        check_admin_referer('romonet_delete_entry');
        $entry_id = intval($_GET['entry_id']);
        $wpdb->delete($table_name, array('id' => $entry_id), array('%d'));
        echo '<div class="notice notice-success"><p>ورودی با موفقیت حذف شد.</p></div>';
    }
    
    // Get pagination and filters
    $paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $per_page = 20;
    $offset = ($paged - 1) * $per_page;
    $status_filter = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
    $type_filter = isset($_GET['project_type']) ? sanitize_text_field($_GET['project_type']) : '';
    
    // Build query
    $where = "WHERE 1=1";
    if ($status_filter) {
        $where .= $wpdb->prepare(" AND status = %s", $status_filter);
    }
    if ($type_filter) {
        $where .= $wpdb->prepare(" AND project_type = %s", $type_filter);
    }
    
    // Get total count
    $total = $wpdb->get_var("SELECT COUNT(*) FROM $table_name $where");
    $total_pages = ceil($total / $per_page);
    
    // Get entries
    $entries = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name $where ORDER BY submitted_at DESC LIMIT %d OFFSET %d",
            $per_page,
            $offset
        )
    );
    
    // Get unique project types for filter
    $project_types = $wpdb->get_col("SELECT DISTINCT project_type FROM $table_name WHERE project_type != '' ORDER BY project_type");
    
    ?>
    <div class="wrap">
        <h1>درخواست‌های پروژه</h1>
        
        <!-- Filters -->
        <div class="tablenav top">
            <div class="alignleft actions">
                <form method="get" action="">
                    <input type="hidden" name="page" value="romonet-project-forms">
                    <select name="status">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="new" <?php selected($status_filter, 'new'); ?>>جدید</option>
                        <option value="contacted" <?php selected($status_filter, 'contacted'); ?>>تماس گرفته شده</option>
                        <option value="in_progress" <?php selected($status_filter, 'in_progress'); ?>>در حال بررسی</option>
                        <option value="quoted" <?php selected($status_filter, 'quoted'); ?>>قیمت‌دهی شده</option>
                        <option value="completed" <?php selected($status_filter, 'completed'); ?>>تکمیل شده</option>
                        <option value="spam" <?php selected($status_filter, 'spam'); ?>>اسپم</option>
                    </select>
                    <select name="project_type">
                        <option value="">همه انواع پروژه</option>
                        <?php foreach ($project_types as $type) : ?>
                            <option value="<?php echo esc_attr($type); ?>" <?php selected($type_filter, $type); ?>><?php echo esc_html($type); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" class="button" value="فیلتر">
                </form>
            </div>
            <div class="tablenav-pages">
                <span class="displaying-num"><?php echo $total; ?> مورد</span>
                <?php if ($total_pages > 1) : ?>
                    <span class="pagination-links">
                        <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $class = $i === $paged ? 'class="pagination-link current"' : 'class="pagination-link"';
                            echo '<a ' . $class . ' href="' . admin_url('admin.php?page=romonet-project-forms&paged=' . $i . ($status_filter ? '&status=' . $status_filter : '') . ($type_filter ? '&project_type=' . $type_filter : '')) . '">' . $i . '</a>';
                        }
                        ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Table -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>کد پیگیری</th>
                    <th>نام تماس</th>
                    <th>شرکت</th>
                    <th>نوع پروژه</th>
                    <th>بودجه</th>
                    <th>زمان‌بندی</th>
                    <th>وضعیت</th>
                    <th>تاریخ</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($entries) : ?>
                    <?php foreach ($entries as $entry) : ?>
                        <tr>
                            <td><code dir="ltr"><?php echo esc_html(romonet_get_submission_tracking_code($entry, 'project')); ?></code></td>
                            <td>
                                <strong><?php echo esc_html($entry->contact_name); ?></strong>
                                <br><small><?php echo esc_html($entry->email); ?></small>
                                <br><small><?php echo esc_html($entry->phone); ?></small>
                            </td>
                            <td><?php echo esc_html($entry->company_name); ?></td>
                            <td><?php echo esc_html($entry->project_type); ?></td>
                            <td><?php echo esc_html($entry->budget); ?></td>
                            <td><?php echo esc_html($entry->timeline); ?></td>
                            <td>
                                <span class="status-<?php echo esc_attr($entry->status); ?>">
                                    <?php
                                    $status_labels = array(
                                        'new' => 'جدید',
                                        'contacted' => 'تماس گرفته شده',
                                        'in_progress' => 'در حال بررسی',
                                        'quoted' => 'قیمت‌دهی شده',
                                        'completed' => 'تکمیل شده',
                                        'spam' => 'اسپم'
                                    );
                                    echo isset($status_labels[$entry->status]) ? $status_labels[$entry->status] : $entry->status;
                                    ?>
                                </span>
                            </td>
                            <td><?php echo date_i18n('Y/m/d - H:i', strtotime($entry->submitted_at)); ?></td>
                            <td>
                                <a href="#" class="button button-small view-entry" data-entry-id="<?php echo $entry->id; ?>">مشاهده</a>
                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=romonet-project-forms&action=delete&entry_id=' . $entry->id), 'romonet_delete_entry'); ?>" class="button button-small" onclick="return confirm('آیا مطمئن هستید؟');">حذف</a>
                            </td>
                        </tr>
                        
                        <!-- Hidden detail row -->
                        <tr class="detail-row" id="detail-<?php echo $entry->id; ?>" style="display: none;">
                            <td colspan="9">
                                <div class="entry-detail" style="padding: 20px; background: #f9f9f9;">
                                    <p><strong>کد پیگیری:</strong> <code dir="ltr"><?php echo esc_html(romonet_get_submission_tracking_code($entry, 'project')); ?></code></p>
                                    <h3>جزئیات پروژه</h3>
                                    
                                    <?php if ($entry->website_url) : ?>
                                        <p><strong>وب‌سایت:</strong> <a href="<?php echo esc_url($entry->website_url); ?>" target="_blank"><?php echo esc_html($entry->website_url); ?></a></p>
                                    <?php endif; ?>
                                    
                                    <?php if ($entry->features) : ?>
                                        <p><strong>امکانات:</strong> <?php echo esc_html($entry->features); ?></p>
                                    <?php endif; ?>
                                    
                                    <p><strong>توضیحات:</strong></p>
                                    <p><?php echo nl2br(esc_html($entry->project_details)); ?></p>
                                    
                                    <?php if ($entry->additional_notes) : ?>
                                        <p><strong>یادداشت‌های اضافی:</strong></p>
                                        <p><?php echo nl2br(esc_html($entry->additional_notes)); ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if ($entry->ip_address) : ?>
                                        <p><strong>IP:</strong> <?php echo esc_html($entry->ip_address); ?></p>
                                    <?php endif; ?>
                                    
                                    <hr style="margin: 20px 0;">
                                    
                                    <form method="post" action="">
                                        <?php wp_nonce_field('romonet_update_status'); ?>
                                        <input type="hidden" name="entry_id" value="<?php echo $entry->id; ?>">
                                        <input type="hidden" name="romonet_update_status" value="1">
                                        
                                        <label>
                                            <strong>وضعیت:</strong>
                                            <select name="status" style="width: 200px; margin-left: 10px;">
                                                <option value="new" <?php selected($entry->status, 'new'); ?>>جدید</option>
                                                <option value="contacted" <?php selected($entry->status, 'contacted'); ?>>تماس گرفته شده</option>
                                                <option value="in_progress" <?php selected($entry->status, 'in_progress'); ?>>در حال بررسی</option>
                                                <option value="quoted" <?php selected($entry->status, 'quoted'); ?>>قیمت‌دهی شده</option>
                                                <option value="completed" <?php selected($entry->status, 'completed'); ?>>تکمیل شده</option>
                                                <option value="spam" <?php selected($entry->status, 'spam'); ?>>اسپم</option>
                                            </select>
                                        </label>
                                        
                                        <br><br>
                                        
                                        <label>
                                            <strong>یادداشت:</strong><br>
                                            <textarea name="notes" rows="3" style="width: 100%; max-width: 600px;"><?php echo esc_textarea($entry->notes); ?></textarea>
                                        </label>
                                        
                                        <br><br>
                                        
                                        <input type="submit" class="button button-primary" value="ذخیره تغییرات">
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 20px;">هیچ موردی یافت نشد.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('.view-entry').on('click', function(e) {
            e.preventDefault();
            var entryId = $(this).data('entry-id');
            $('#detail-' + entryId).toggle();
        });
    });
    </script>
    
    <style>
    .status-new { color: #d63638; font-weight: bold; }
    .status-contacted { color: #00a32a; }
    .status-in_progress { color: #dba617; }
    .status-quoted { color: #2271b1; }
    .status-completed { color: #00a32a; font-weight: bold; }
    .status-spam { color: #646970; }
    </style>
    <?php
}

/**
 * Newsletter subscribers admin page
 */
function romonet_newsletter_subscribers_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'romonet_subscribers';

    if (isset($_POST['romonet_update_subscriber']) && isset($_POST['entry_id']) && check_admin_referer('romonet_update_subscriber')) {
        $status = sanitize_text_field($_POST['status']);
        $entry_id = intval($_POST['entry_id']);
        $notes = isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : '';

        $wpdb->update(
            $table_name,
            array(
                'status' => $status,
                'notes' => $notes,
            ),
            array('id' => $entry_id),
            array('%s', '%s'),
            array('%d')
        );

        echo '<div class="notice notice-success"><p>مشترک با موفقیت به‌روزرسانی شد.</p></div>';
    }

    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['entry_id'])) {
        check_admin_referer('romonet_delete_subscriber');
        $entry_id = intval($_GET['entry_id']);
        $wpdb->delete($table_name, array('id' => $entry_id), array('%d'));
        echo '<div class="notice notice-success"><p>مشترک با موفقیت حذف شد.</p></div>';
    }

    $paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $per_page = 20;
    $offset = ($paged - 1) * $per_page;
    $status_filter = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
    $source_filter = isset($_GET['source']) ? sanitize_text_field($_GET['source']) : '';

    $where = 'WHERE 1=1';

    if ($status_filter) {
        $where .= $wpdb->prepare(' AND status = %s', $status_filter);
    }

    if ($source_filter) {
        $where .= $wpdb->prepare(' AND source = %s', $source_filter);
    }

    $total = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table_name $where");
    $total_pages = ceil($total / $per_page);

    $entries = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name $where ORDER BY subscribed_at DESC LIMIT %d OFFSET %d",
            $per_page,
            $offset
        )
    );

    $sources = $wpdb->get_col("SELECT DISTINCT source FROM $table_name WHERE source != '' ORDER BY source");

    ?>
    <div class="wrap">
        <h1>مشترکین خبرنامه</h1>

        <div class="tablenav top">
            <div class="alignleft actions">
                <form method="get" action="">
                    <input type="hidden" name="page" value="romonet-newsletter-subscribers">
                    <select name="status">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="active" <?php selected($status_filter, 'active'); ?>>فعال</option>
                        <option value="unsubscribed" <?php selected($status_filter, 'unsubscribed'); ?>>لغو اشتراک</option>
                        <option value="spam" <?php selected($status_filter, 'spam'); ?>>اسپم</option>
                    </select>
                    <select name="source">
                        <option value="">همه منابع</option>
                        <?php foreach ($sources as $source) : ?>
                            <option value="<?php echo esc_attr($source); ?>" <?php selected($source_filter, $source); ?>><?php echo esc_html($source); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" class="button" value="فیلتر">
                </form>
            </div>
            <div class="tablenav-pages">
                <span class="displaying-num"><?php echo esc_html((string) $total); ?> مورد</span>
                <?php if ($total_pages > 1) : ?>
                    <span class="pagination-links">
                        <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $class = $i === $paged ? 'class="pagination-link current"' : 'class="pagination-link"';
                            $url = admin_url('admin.php?page=romonet-newsletter-subscribers&paged=' . $i);

                            if ($status_filter) {
                                $url .= '&status=' . rawurlencode($status_filter);
                            }

                            if ($source_filter) {
                                $url .= '&source=' . rawurlencode($source_filter);
                            }

                            echo '<a ' . $class . ' href="' . esc_url($url) . '">' . esc_html((string) $i) . '</a>';
                        }
                        ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ایمیل</th>
                    <th>تلفن</th>
                    <th>منبع</th>
                    <th>وضعیت</th>
                    <th>تاریخ عضویت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($entries) : ?>
                    <?php foreach ($entries as $entry) : ?>
                        <tr>
                            <td><?php echo $entry->email ? esc_html($entry->email) : '—'; ?></td>
                            <td><?php echo $entry->phone ? esc_html($entry->phone) : '—'; ?></td>
                            <td><?php echo esc_html($entry->source); ?></td>
                            <td>
                                <span class="status-<?php echo esc_attr($entry->status); ?>">
                                    <?php
                                    $status_labels = array(
                                        'active' => 'فعال',
                                        'unsubscribed' => 'لغو اشتراک',
                                        'spam' => 'اسپم',
                                    );
                                    echo isset($status_labels[$entry->status]) ? $status_labels[$entry->status] : esc_html($entry->status);
                                    ?>
                                </span>
                            </td>
                            <td><?php echo esc_html(date_i18n('Y/m/d - H:i', strtotime($entry->subscribed_at))); ?></td>
                            <td>
                                <a href="#" class="button button-small view-subscriber" data-entry-id="<?php echo esc_attr((string) $entry->id); ?>">مشاهده</a>
                                <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=romonet-newsletter-subscribers&action=delete&entry_id=' . $entry->id), 'romonet_delete_subscriber')); ?>" class="button button-small" onclick="return confirm('آیا مطمئن هستید؟');">حذف</a>
                            </td>
                        </tr>

                        <tr class="detail-row" id="subscriber-detail-<?php echo esc_attr((string) $entry->id); ?>" style="display: none;">
                            <td colspan="6">
                                <div class="entry-detail" style="padding: 20px; background: #f9f9f9;">
                                    <?php if ($entry->ip_address) : ?>
                                        <p><strong>IP:</strong> <?php echo esc_html($entry->ip_address); ?></p>
                                    <?php endif; ?>

                                    <?php if ($entry->user_agent) : ?>
                                        <p><strong>مرورگر:</strong> <?php echo esc_html($entry->user_agent); ?></p>
                                    <?php endif; ?>

                                    <p><strong>رضایت:</strong> <?php echo $entry->consent ? 'بله' : 'خیر'; ?></p>

                                    <hr style="margin: 20px 0;">

                                    <form method="post" action="">
                                        <?php wp_nonce_field('romonet_update_subscriber'); ?>
                                        <input type="hidden" name="entry_id" value="<?php echo esc_attr((string) $entry->id); ?>">
                                        <input type="hidden" name="romonet_update_subscriber" value="1">

                                        <label>
                                            <strong>وضعیت:</strong>
                                            <select name="status" style="width: 200px; margin-left: 10px;">
                                                <option value="active" <?php selected($entry->status, 'active'); ?>>فعال</option>
                                                <option value="unsubscribed" <?php selected($entry->status, 'unsubscribed'); ?>>لغو اشتراک</option>
                                                <option value="spam" <?php selected($entry->status, 'spam'); ?>>اسپم</option>
                                            </select>
                                        </label>

                                        <br><br>

                                        <label>
                                            <strong>یادداشت:</strong><br>
                                            <textarea name="notes" rows="3" style="width: 100%; max-width: 600px;"><?php echo esc_textarea($entry->notes); ?></textarea>
                                        </label>

                                        <br><br>

                                        <input type="submit" class="button button-primary" value="ذخیره تغییرات">
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">هیچ مشترکی یافت نشد.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('.view-subscriber').on('click', function(e) {
            e.preventDefault();
            var entryId = $(this).data('entry-id');
            $('#subscriber-detail-' + entryId).toggle();
        });
    });
    </script>

    <style>
    .status-active { color: #00a32a; font-weight: bold; }
    .status-unsubscribed { color: #646970; }
    .status-spam { color: #d63638; }
    </style>
    <?php
}
