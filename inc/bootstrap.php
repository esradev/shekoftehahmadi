<?php

/**
 * Theme bootstrap file.
 *
 * Loads modular features in a predictable order.
 */

if (! defined('ABSPATH')) {
  exit;
}

require_once get_theme_file_path('/inc/setup.php');
require_once get_theme_file_path('/inc/assets.php');
require_once get_theme_file_path('/inc/menus.php');
require_once get_theme_file_path('/inc/widgets.php');
require_once get_theme_file_path('/inc/posts.php');
require_once get_theme_file_path('/inc/theme-settings.php');
require_once get_theme_file_path('/inc/woocommerce.php');
require_once get_theme_file_path('/inc/helpers.php');
require_once get_theme_file_path('/inc/faq.php');
require_once get_theme_file_path('/inc/front-page.php');
require_once get_theme_file_path('/inc/hero.php');
require_once get_theme_file_path('/inc/cta.php');
require_once get_theme_file_path('/inc/form-database.php');
require_once get_theme_file_path('/inc/form-admin.php');
require_once get_theme_file_path('/inc/form-hooks.php');
