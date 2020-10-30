<?php

defined('ABSPATH') || exit;

/**
 * Main WooCommerce Tabs Accordions Plugin Class
 *
 * @class WooTabsAccordions
 */
final class WooTabsAccordions
{
    /**
     * @var WooTabsAccordions
     */
    private static $_instance = null;

    /**
     * WooTabsAccordions Constructor
     */
    public function __construct()
    {
        $this->define_constants();

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
     * Define WC Constants.
     */
    private function define_constants()
    {
        $plugin_data = get_file_data(
            WOOT2A_PLUGIN_FILE,
            array(
                'name' => 'Plugin Name',
                'version' => 'Version',
            ),
            'plugin'
        );

        $this->define('WOOT2A_ABSPATH', dirname(WOOT2A_PLUGIN_FILE) . '/');
        $this->define('WOOT2A_PLUGIN_BASENAME', plugin_basename(WOOT2A_PLUGIN_FILE));
        $this->define('WOOT2A_PLUGIN_NAME', trim($plugin_data['name']));
        $this->define('WOOT2A_PLUGIN_VERSION', $plugin_data['version']);
        $this->define('WOOT2A_DIR', plugin_dir_path(__FILE__));
        $this->define('WOOT2A_URL', plugin_dir_url(__FILE__));
    }

    /**
     * Define constant if not already set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }

}
