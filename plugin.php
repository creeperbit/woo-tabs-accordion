<?php
/*
 * Plugin Name: WooCommerce Tabs Accordion
 * Plugin URI: https://wordpress.org/plugins/woo-tabs-accordion/
 * Description: WooCommerce Tabs Accordion converts the default WooCommerce product page tabs into an accordion.
 * Version: 1.0.0
 * Author: CreeperBit
 * Author URI: https://creeperbit.com/
 * Text Domain: woo-tabs-accordion
 * Requires at least: 4.7
 * Tested up to: 5.5.1
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

// Include the main WooTabsAccordion class.
if (!class_exists('WooTabsAccordion', false)) {
    include_once dirname(WOOT2A_PLUGIN_FILE) . '/includes/class-woo-tabs-accordion.php';
    WooTabsAccordion::instance();
}
