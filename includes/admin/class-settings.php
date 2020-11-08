<?php

namespace CreeperBit\WooT2A\Admin;

defined('ABSPATH') || exit;

/**
 * Class WooT2A_Admin_Settings
 */
class WooT2A_Settings
{
    /**
     * @var WooT2A_Settings
     */
    private static $_instance = null;

    /**
     *
     * Set needed filters and actions and load all needed
     */
    public function __construct()
    {
        // Add backend settings
        add_filter('woocommerce_get_settings_pages', array($this, 'settings_page'));
    }

    /**
     * @return self
     */
    public static function instance()
    {

        if (null === self::$_instance) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * Add new admin setting page
     *
     * @param array   $settings an array of existing setting pages.
     * @return array of setting pages along with creeperbit-woo-accordion settings page.
     *
     */
    public function settings_page($settings)
    {
        $settings[] = include_once 'class-settings-page.php';
        
        return $settings;
    }

}
