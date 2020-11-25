<?php
/*
 * Plugin Name: CreeperBit Accordion Tabs for WooCommerce
 * Description: CreeperBit Accordion Tabs for WooCommerce converts the default product page tabs into an accordion.
 * Version: 1.1.0
 * Author: CreeperBit
 * Author URI: https://creeperbit.com/
 * Text Domain: creeperbit-woo-accordion
 * Requires at least: 4.7
 * Tested up to: 5.5.3
 * Requires PHP: 5.6

 * License: GNU General Public License v2.0 (or later)
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

if (!defined('WOOT2A_PLUGIN_FILE')) {
    define('WOOT2A_PLUGIN_FILE', __FILE__);
}

// Include the Composer autoload file
require plugin_dir_path(__FILE__) . 'vendor/autoload.php';

// Include the main WooAccordion class.
if (!class_exists('WooAccordion', false)) {
    include_once dirname(WOOT2A_PLUGIN_FILE) . '/includes/class-woo-accordion.php';
    WooAccordion::instance();
}
