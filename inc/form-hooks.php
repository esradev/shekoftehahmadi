<?php

/**
 * Form Hooks and Actions
 *
 * This file handles custom hooks and actions for form submissions.
 * You can add SMS and email functionality using these hooks.
 *
 * @package Romonet
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Initialize form hooks
 */
function romonet_init_form_hooks() {
    // Register AJAX handlers for form submissions
    add_action('wp_ajax_romonet_submit_contact_form', 'romonet_handle_contact_form_submission');
    add_action('wp_ajax_nopriv_romonet_submit_contact_form', 'romonet_handle_contact_form_submission');

    add_action('wp_ajax_romonet_submit_project_form', 'romonet_handle_project_form_submission');
    add_action('wp_ajax_nopriv_romonet_submit_project_form', 'romonet_handle_project_form_submission');

    add_action('wp_ajax_romonet_submit_newsletter_form', 'romonet_handle_newsletter_form_submission');
    add_action('wp_ajax_nopriv_romonet_submit_newsletter_form', 'romonet_handle_newsletter_form_submission');
}
add_action('init', 'romonet_init_form_hooks');

/**
 * Handle contact form submission via AJAX
 */
function romonet_handle_contact_form_submission() {
    // Verify nonce
    if (! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'romonet_form_nonce')) {
        wp_send_json_error(array('message' => 'خطای امنیتی: لطفاً صفحه را رفرش کنید و دوباره تلاش کنید.'));
    }

    // Validate required fields
    $required_fields = array('name', 'email', 'phone', 'subject', 'message');
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            wp_send_json_error(array('message' => 'لطفاً تمام فیلدهای ضروری را پر کنید.'));
        }
    }

    // Sanitize and prepare data
    $data = array(
        'name' => sanitize_text_field($_POST['name']),
        'phone' => sanitize_text_field($_POST['phone']),
        'email' => sanitize_email($_POST['email']),
        'company' => isset($_POST['company']) ? sanitize_text_field($_POST['company']) : '',
        'subject' => sanitize_text_field($_POST['subject']),
        'message' => sanitize_textarea_field($_POST['message']),
        'consent' => isset($_POST['consent']) ? 1 : 0,
        'ip_address' => romonet_get_client_ip(),
        'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '',
        'submitted_at' => current_time('mysql'),
    );

    // Trigger before submission hook
    do_action('romonet_before_contact_submission', $data);

    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'romonet_contact_submissions';

    $result = $wpdb->insert(
        $table_name,
        $data,
        array('%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s')
    );

    if ($result === false) {
        wp_send_json_error(array('message' => 'خطا در ذخیره اطلاعات. لطفاً دوباره تلاش کنید.'));
    }

    $entry_id = $wpdb->insert_id;
    $tracking_code = romonet_generate_tracking_code('contact', $entry_id);

    $wpdb->update(
        $table_name,
        array('tracking_code' => $tracking_code),
        array('id' => $entry_id),
        array('%s'),
        array('%d')
    );

    // Trigger after submission hook
    do_action('romonet_after_contact_submission', $data, $entry_id);

    wp_send_json_success(array(
        'message' => 'پیام شما با موفقیت ارسال شد. کارشناسان ما در کمتر از ۲۴ ساعت با شما تماس خواهند گرفت.',
        'entry_id' => $entry_id,
        'tracking_code' => $tracking_code,
    ));
}

/**
 * Handle project form submission via AJAX
 */
function romonet_handle_project_form_submission() {
    // Verify nonce
    if (! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'romonet_form_nonce')) {
        wp_send_json_error(array('message' => 'خطای امنیتی: لطفاً صفحه را رفرش کنید و دوباره تلاش کنید.'));
    }

    // Validate required fields
    $required_fields = array('contact_name', 'email', 'phone', 'project_type', 'project_details', 'budget', 'timeline');
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            wp_send_json_error(array('message' => 'لطفاً تمام فیلدهای ضروری را پر کنید.'));
        }
    }

    // Sanitize and prepare data
    $data = array(
        'contact_name' => sanitize_text_field($_POST['contact_name']),
        'company_name' => isset($_POST['company_name']) ? sanitize_text_field($_POST['company_name']) : '',
        'email' => sanitize_email($_POST['email']),
        'phone' => sanitize_text_field($_POST['phone']),
        'project_type' => sanitize_text_field($_POST['project_type']),
        'website_url' => isset($_POST['website_url']) ? esc_url_raw($_POST['website_url']) : '',
        'project_details' => sanitize_textarea_field($_POST['project_details']),
        'features' => isset($_POST['features']) ? sanitize_text_field(implode(', ', $_POST['features'])) : '',
        'budget' => sanitize_text_field($_POST['budget']),
        'timeline' => sanitize_text_field($_POST['timeline']),
        'additional_notes' => isset($_POST['additional_notes']) ? sanitize_textarea_field($_POST['additional_notes']) : '',
        'consent' => isset($_POST['consent']) ? 1 : 0,
        'ip_address' => romonet_get_client_ip(),
        'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '',
        'submitted_at' => current_time('mysql'),
    );

    // Trigger before submission hook
    do_action('romonet_before_project_submission', $data);

    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'romonet_project_submissions';

    $result = $wpdb->insert(
        $table_name,
        $data,
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s')
    );

    if ($result === false) {
        wp_send_json_error(array('message' => 'خطا در ذخیره اطلاعات. لطفاً دوباره تلاش کنید.'));
    }

    $entry_id = $wpdb->insert_id;
    $tracking_code = romonet_generate_tracking_code('project', $entry_id);

    $wpdb->update(
        $table_name,
        array('tracking_code' => $tracking_code),
        array('id' => $entry_id),
        array('%s'),
        array('%d')
    );

    // Trigger after submission hook
    do_action('romonet_after_project_submission', $data, $entry_id);

    wp_send_json_success(array(
        'message' => 'درخواست پروژه شما با موفقیت ثبت شد. تیم فنی ما در کمتر از ۲۴ تا ۴۸ ساعت با شما تماس خواهد گرفت.',
        'entry_id' => $entry_id,
        'tracking_code' => $tracking_code,
    ));
}

/**
 * Handle newsletter subscription via AJAX
 */
function romonet_handle_newsletter_form_submission() {
    if (! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'romonet_form_nonce')) {
        wp_send_json_error(array('message' => 'خطای امنیتی: لطفاً صفحه را رفرش کنید و دوباره تلاش کنید.'));
    }

    $fields_mode = isset($_POST['fields_mode']) ? sanitize_text_field($_POST['fields_mode']) : 'email';

    if (! in_array($fields_mode, array('email', 'phone', 'both'), true)) {
        $fields_mode = 'email';
    }

    $email  = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $phone  = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $source = isset($_POST['source']) ? sanitize_text_field(wp_unslash($_POST['source'])) : 'footer';

    if ($fields_mode === 'email' || $fields_mode === 'both') {
        if (empty($email) || ! is_email($email)) {
            do_action('romonet_newsletter_submission_failed', array('reason' => 'invalid_email', 'email' => $email, 'phone' => $phone));
            wp_send_json_error(array('message' => 'لطفاً یک ایمیل معتبر وارد کنید.'));
        }
    }

    if ($fields_mode === 'phone' || $fields_mode === 'both') {
        $phone_digits = preg_replace('/\D+/', '', $phone);

        if (empty($phone_digits) || strlen($phone_digits) < 10) {
            do_action('romonet_newsletter_submission_failed', array('reason' => 'invalid_phone', 'email' => $email, 'phone' => $phone));
            wp_send_json_error(array('message' => 'لطفاً یک شماره تماس معتبر وارد کنید.'));
        }

        $phone = $phone_digits;
    }

    if ($fields_mode === 'both' && (empty($email) || empty($phone))) {
        do_action('romonet_newsletter_submission_failed', array('reason' => 'missing_fields', 'email' => $email, 'phone' => $phone));
        wp_send_json_error(array('message' => 'لطفاً ایمیل و شماره تماس را وارد کنید.'));
    }

    if (empty($_POST['consent'])) {
        do_action('romonet_newsletter_submission_failed', array('reason' => 'missing_consent', 'email' => $email, 'phone' => $phone));
        wp_send_json_error(array('message' => 'برای عضویت باید با دریافت خبرنامه موافقت کنید.'));
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'romonet_subscribers';

    if ($email && romonet_subscriber_exists('email', $email)) {
        do_action('romonet_newsletter_submission_failed', array('reason' => 'duplicate_email', 'email' => $email, 'phone' => $phone));
        wp_send_json_error(array('message' => 'این ایمیل قبلاً در خبرنامه ثبت شده است.'));
    }

    if ($phone && romonet_subscriber_exists('phone', $phone)) {
        do_action('romonet_newsletter_submission_failed', array('reason' => 'duplicate_phone', 'email' => $email, 'phone' => $phone));
        wp_send_json_error(array('message' => 'این شماره تماس قبلاً در خبرنامه ثبت شده است.'));
    }

    $data = array(
        'email' => $email,
        'phone' => $phone,
        'source' => $source,
        'consent' => 1,
        'ip_address' => romonet_get_client_ip(),
        'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '',
        'status' => 'active',
        'subscribed_at' => current_time('mysql'),
    );

    do_action('romonet_before_newsletter_submission', $data);

    $result = $wpdb->insert(
        $table_name,
        $data,
        array('%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s')
    );

    if ($result === false) {
        do_action('romonet_newsletter_submission_failed', array('reason' => 'database_error', 'email' => $email, 'phone' => $phone));
        wp_send_json_error(array('message' => 'خطا در ذخیره اطلاعات. لطفاً دوباره تلاش کنید.'));
    }

    $entry_id = $wpdb->insert_id;

    do_action('romonet_after_newsletter_submission', $data, $entry_id);

    wp_send_json_success(array(
        'message' => 'عضویت شما با موفقیت انجام شد. از همراهی شما سپاسگزاریم!',
        'entry_id' => $entry_id,
    ));
}

/**
 * Check whether a subscriber already exists for a given field.
 */
function romonet_subscriber_exists($field, $value) {
    if (empty($value)) {
        return false;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'romonet_subscribers';

    if ($field === 'email') {
        return (bool) $wpdb->get_var(
            $wpdb->prepare("SELECT id FROM $table_name WHERE email = %s AND status != 'unsubscribed' LIMIT 1", $value)
        );
    }

    if ($field === 'phone') {
        return (bool) $wpdb->get_var(
            $wpdb->prepare("SELECT id FROM $table_name WHERE phone = %s AND status != 'unsubscribed' LIMIT 1", $value)
        );
    }

    return false;
}

/**
 * Get client IP address
 */
function romonet_get_client_ip() {
    $ip = '';

    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED'];
    } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
        $ip = $_SERVER['HTTP_FORWARDED'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return sanitize_text_field($ip);
}

/**
 * Example: Add email notification after contact submission
 * Uncomment and modify this function to enable email notifications
 */
/*
add_action('romonet_after_contact_submission', 'romonet_send_contact_email', 10, 2);
function romonet_send_contact_email($data, $entry_id) {
    $to = get_option('admin_email');
    $subject = 'فرم تماس جدید: ' . $data['name'];
    $message = "نام: {$data['name']}\n";
    $message .= "ایمیل: {$data['email']}\n";
    $message .= "تلفن: {$data['phone']}\n";
    $message .= "شرکت: {$data['company']}\n";
    $message .= "موضوع: {$data['subject']}\n";
    $message .= "پیام:\n{$data['message']}";

    wp_mail($to, $subject, $message);
}
*/

/**
 * Example: Add SMS notification after project submission
 * Uncomment and modify this function to enable SMS notifications
 * You'll need to integrate with an SMS service like Kavenegar, MeliPayamak, etc.
 */
/*
add_action('romonet_after_project_submission', 'romonet_send_project_sms', 10, 2);
function romonet_send_project_sms($data, $entry_id) {
    // Integrate with your SMS service here
    // Example using a fictional SMS service:
    // $sms_api = new Your_SMS_Service();
    // $sms_api->send($data['phone'], 'درخواست پروژه شما ثبت شد. به زودی با شما تماس می‌گیریم.');
}
*/

/**
 * Example: Add email notification after newsletter subscription
 * Uncomment and modify this function to enable welcome emails
 */
/*
add_action('romonet_after_newsletter_submission', 'romonet_send_newsletter_welcome_email', 10, 2);
function romonet_send_newsletter_welcome_email($data, $entry_id) {
    if (empty($data['email'])) {
        return;
    }

    wp_mail(
        $data['email'],
        'به خبرنامه رومونت خوش آمدید',
        'عضویت شما با موفقیت انجام شد.'
    );
}
*/
