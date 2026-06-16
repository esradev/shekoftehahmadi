<?php

/**
 * Form Database Tables
 *
 * This file creates custom database tables for storing contact and project request form submissions.
 *
 * @package Romonet
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Create database tables on theme activation
 */
function romonet_create_form_tables() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    // Contact submissions table
    $contact_table = $wpdb->prefix . 'romonet_contact_submissions';
    $contact_sql = "CREATE TABLE IF NOT EXISTS $contact_table (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        phone varchar(50) NOT NULL,
        email varchar(255) NOT NULL,
        company varchar(255) DEFAULT '',
        subject varchar(100) NOT NULL,
        message text NOT NULL,
        consent tinyint(1) DEFAULT 0,
        ip_address varchar(45) DEFAULT '',
        user_agent text DEFAULT '',
        status varchar(20) DEFAULT 'new',
        notes text DEFAULT '',
        tracking_code varchar(30) DEFAULT '',
        submitted_at datetime NOT NULL,
        PRIMARY KEY (id),
        KEY status (status),
        KEY submitted_at (submitted_at),
        KEY tracking_code (tracking_code)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($contact_sql);

    // Project submissions table
    $project_table = $wpdb->prefix . 'romonet_project_submissions';
    $project_sql = "CREATE TABLE IF NOT EXISTS $project_table (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        contact_name varchar(255) NOT NULL,
        company_name varchar(255) DEFAULT '',
        email varchar(255) NOT NULL,
        phone varchar(50) NOT NULL,
        project_type varchar(100) NOT NULL,
        website_url varchar(500) DEFAULT '',
        project_details text NOT NULL,
        features varchar(500) DEFAULT '',
        budget varchar(50) NOT NULL,
        timeline varchar(50) NOT NULL,
        additional_notes text DEFAULT '',
        consent tinyint(1) DEFAULT 0,
        ip_address varchar(45) DEFAULT '',
        user_agent text DEFAULT '',
        status varchar(20) DEFAULT 'new',
        notes text DEFAULT '',
        tracking_code varchar(30) DEFAULT '',
        submitted_at datetime NOT NULL,
        PRIMARY KEY (id),
        KEY status (status),
        KEY project_type (project_type),
        KEY submitted_at (submitted_at),
        KEY tracking_code (tracking_code)
    ) $charset_collate;";

    dbDelta($project_sql);

    // Newsletter subscribers table
    $subscribers_table = $wpdb->prefix . 'romonet_subscribers';
    $subscribers_sql = "CREATE TABLE IF NOT EXISTS $subscribers_table (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        email varchar(255) DEFAULT '',
        phone varchar(50) DEFAULT '',
        source varchar(100) DEFAULT 'footer',
        consent tinyint(1) DEFAULT 0,
        ip_address varchar(45) DEFAULT '',
        user_agent text DEFAULT '',
        status varchar(20) DEFAULT 'active',
        notes text DEFAULT '',
        subscribed_at datetime NOT NULL,
        PRIMARY KEY (id),
        KEY email (email),
        KEY phone (phone),
        KEY status (status),
        KEY source (source),
        KEY subscribed_at (subscribed_at)
    ) $charset_collate;";

    dbDelta($subscribers_sql);

    // Update database version
    update_option('romonet_form_db_version', '1.2');
}

/**
 * Generate a unique tracking code for a form submission.
 */
function romonet_generate_tracking_code($form_type, $entry_id) {
    $prefix = $form_type === 'project' ? 'ROM-P' : 'ROM-C';

    return $prefix . '-' . str_pad((string) $entry_id, 6, '0', STR_PAD_LEFT);
}

/**
 * Check whether a database table has a specific column.
 */
function romonet_table_has_column($table_name, $column_name) {
    global $wpdb;

    $column = $wpdb->get_var(
        $wpdb->prepare(
            'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s',
            DB_NAME,
            $table_name,
            $column_name
        )
    );

    return ! empty($column);
}

/**
 * Ensure tracking_code exists on form tables (dbDelta can miss column adds).
 */
function romonet_ensure_tracking_code_columns() {
    static $ensured = false;

    if ($ensured) {
        return false;
    }

    $ensured = true;
    global $wpdb;
    $columns_added = false;

    $tables = array(
        $wpdb->prefix . 'romonet_contact_submissions',
        $wpdb->prefix . 'romonet_project_submissions',
    );

    foreach ($tables as $table_name) {
        if (romonet_table_has_column($table_name, 'tracking_code')) {
            continue;
        }

        $wpdb->query("ALTER TABLE $table_name ADD COLUMN tracking_code varchar(30) DEFAULT '' AFTER notes");
        $wpdb->query("ALTER TABLE $table_name ADD INDEX tracking_code (tracking_code)");
        $columns_added = true;
    }

    return $columns_added;
}

/**
 * Get a submission tracking code, creating one if missing.
 */
function romonet_get_submission_tracking_code($entry, $form_type) {
    if (! empty($entry->tracking_code)) {
        return $entry->tracking_code;
    }

    if (empty($entry->id)) {
        return '';
    }

    global $wpdb;

    $table_name = $form_type === 'project'
        ? $wpdb->prefix . 'romonet_project_submissions'
        : $wpdb->prefix . 'romonet_contact_submissions';

    $tracking_code = romonet_generate_tracking_code($form_type, $entry->id);

    $wpdb->update(
        $table_name,
        array('tracking_code' => $tracking_code),
        array('id' => $entry->id),
        array('%s'),
        array('%d')
    );

    return $tracking_code;
}

/**
 * Backfill tracking codes for existing submissions.
 */
function romonet_backfill_tracking_codes() {
    global $wpdb;

    $tables = array(
        'contact' => $wpdb->prefix . 'romonet_contact_submissions',
        'project' => $wpdb->prefix . 'romonet_project_submissions',
    );

    foreach ($tables as $form_type => $table_name) {
        $entries = $wpdb->get_results("SELECT id FROM $table_name WHERE tracking_code = '' OR tracking_code IS NULL");

        if (! $entries) {
            continue;
        }

        foreach ($entries as $entry) {
            $wpdb->update(
                $table_name,
                array('tracking_code' => romonet_generate_tracking_code($form_type, $entry->id)),
                array('id' => $entry->id),
                array('%s'),
                array('%d')
            );
        }
    }
}

/**
 * Check if database tables need to be created/updated
 */
function romonet_check_form_tables() {
    $current_version = get_option('romonet_form_db_version');

    if ($current_version !== '1.2') {
        romonet_create_form_tables();
    }

    $columns_added = romonet_ensure_tracking_code_columns();

    if (! get_option('romonet_tracking_codes_backfilled') || $columns_added) {
        romonet_backfill_tracking_codes();
        update_option('romonet_tracking_codes_backfilled', '1');
    }

    if ($current_version !== '1.2') {
        update_option('romonet_form_db_version', '1.2');
    }
}

// Check tables on admin init and also on init to ensure they exist
add_action('admin_init', 'romonet_check_form_tables');
add_action('init', 'romonet_check_form_tables');
