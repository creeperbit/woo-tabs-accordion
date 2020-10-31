<?php
/*
 * Plugin Name: WooCommerce Tabs Accordions
 * Plugin URI: https://wordpress.org/plugins/woo-tabs-accordions/
 * Description: WooCommerce Tabs Accordions converts default woocommerce product page tabs to accordions.
 * Version: 1.0.0
 * Author: CreeperBit
 * Author URI: https://creeperbit.com/
 * Text Domain: woo-tabs-accordions
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

use CreeperBit\WooT2A\SystemRequirements;
use CreeperBit\WooT2A\SystemTests;

$system_requirements = new SystemRequirements();
$system_tests = new SystemTests($system_requirements);

// Don't activate on anything less than PHP 5.6 or WordPress 4.7
if (!$system_tests->is_php_version_compatible() || !$system_tests->is_wp_version_compatible()) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    deactivate_plugins(__FILE__);
    die(
        sprintf(
            esc_html__(
                'WooCommerce Tabs Accordions requires PHP version %1$s with spl extension or greater and WordPress %2$s or greater.',
                'woo-tabs-accordions'
            ),
            $system_requirements->php_minimum_version(),
            $system_requirements->wp_minimum_version()
        )
    );
}

// Don't activate if woocommerce is disabled
if (!$system_tests->is_woocommerce_activated()) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    deactivate_plugins(__FILE__);
    die(
        esc_html__(
            'WooCommerce Tabs Accordions requires <a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a> to be activated in order to work.',
            'woo-tabs-accordions'
        )
    );
}

// Include the main WooTabsAccordions class.
if (!class_exists('WooT2A', false)) {
    include_once dirname(WOOT2A_PLUGIN_FILE) . '/includes/class-woo-tabs-accordions.php';
}

WooTabsAccordions::instance();
