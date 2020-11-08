<?php

defined('ABSPATH') || exit;

/**
 * Main Woo Accordion Plugin Class
 *
 * @class WooAccordion
 */
final class WooAccordion
{
    /**
     * @var WooAccordion
     */
    private static $_instance = null;

    /**
     * WooAccordion Constructor
     */
    public function __construct()
    {
        $this->define_constants();
        $this->init();

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
     * Define WooAccordion Constants.
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
        $this->define('WOOT2A_DIR', plugin_dir_path(WOOT2A_PLUGIN_FILE));
        $this->define('WOOT2A_URL', plugin_dir_url(WOOT2A_PLUGIN_FILE));
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

    /**
     * Init Woo Accordion when WordPress Initialises.
     */
    private function init()
    {
        add_action('admin_notices', array($this, 'check_system_requirements'), 5);
        register_activation_hook(WOOT2A_PLUGIN_BASENAME, array('CreeperBit\WooT2A\WooT2A_Install', 'activate'));
        add_action('init', array($this, 'init_hooks'), 20);
        register_deactivation_hook(WOOT2A_PLUGIN_BASENAME, array('CreeperBit\WooT2A\WooT2A_Install', 'deactivate'));
    }

    public function check_system_requirements()
    {
        $message = '';

        $system_requirements = new CreeperBit\WooT2A\SystemRequirements();
        $system_tests = new CreeperBit\WooT2A\SystemTests($system_requirements);

        // Don't activate on anything less than PHP 5.6 or WordPress 4.7
        if (!$system_tests->is_php_version_compatible() || !$system_tests->is_wp_version_compatible()) {
            $message .= '<div class="notice notice-error is-dismissible"><p>';
            $message .= sprintf(
                esc_html__(
                    'CreeperBit Accordion Tabs for WooCommerce requires PHP version %1$s with spl extension or greater and WordPress %2$s or greater.',
                    'creeperbit-woo-accordion'
                ),
                $system_requirements->php_minimum_version(),
                $system_requirements->wp_minimum_version()
            );
            $message .= '</p></div>';
            deactivate_plugins(WOOT2A_PLUGIN_BASENAME);
        }

        // Don't activate if woocommerce is disabled
        if (!$system_tests->is_woocommerce_activated()) {
            $message .= '<div class="notice notice-error is-dismissible"><p>';
            $message .= __(
                'CreeperBit Accordion Tabs for WooCommerce requires <a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a> to be activated in order to work.',
                'creeperbit-woo-accordion'
            );
            $message .= '</p></div>';
            deactivate_plugins(WOOT2A_PLUGIN_BASENAME);
        }

        if ($message != '') {
            echo $message;

            if (isset($_GET['activate'])) {
                unset($_GET['activate']);
            }
        } else {
            add_action('plugin_action_links_' . WOOT2A_PLUGIN_BASENAME, array('CreeperBit\WooT2A\WooT2A_Install', 'plugin_action_links'));
        }
    }

    /**
     * Hook into actions and filters.
     */
    public function init_hooks()
    {
        // Before init action.
        do_action('before_woot2a_init');

        // Set up localisation.
        $this->load_plugin_textdomain();

        // Classes/actions loaded for the frontend and for ajax requests.
        if ($this->is_request('frontend')) {
            // Init frontend
            CreeperBit\WooT2A\Frontend\WooT2A_Template::instance();
        }

        if ($this->is_request('admin')) {
            // Init backend
            CreeperBit\WooT2A\Admin\WooT2A_Settings::instance();
        }

        // Init action.
        do_action('woot2a_init');
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * @return bool Text domain loaded
     */
    private function load_plugin_textdomain()
    {

        if (is_textdomain_loaded('creeperbit-woo-accordion')) {
            return true;
        }

        return load_plugin_textdomain('creeperbit-woo-accordion', false, WOOT2A_ABSPATH . 'languages');

    }

    /**
     * What type of request is this?
     *
     * @param  string $type admin, ajax, cron or frontend.
     * @return bool
     */
    private function is_request($type)
    {
        switch ($type) {
            case 'admin':
                return is_admin();
            case 'ajax':
                return defined('DOING_AJAX');
            case 'cron':
                return defined('DOING_CRON');
            case 'frontend':
                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
        }
    }

}
