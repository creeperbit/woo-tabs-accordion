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

        //add more actions
        /*add_action( 'admin_init', array( $this, 'admin_init' ) );
    add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_scripts' ) );

    //Save settings
    add_action( 'admin_post_woot2a', array( $this, 'save_post_form' ) );*/
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
     * @return array of setting pages along with woo-tabs-accordions settings page.
     *
     */
    public function settings_page($settings)
    {
        $settings[] = include_once 'class-settings-page.php';
        
        return $settings;
    }

}
