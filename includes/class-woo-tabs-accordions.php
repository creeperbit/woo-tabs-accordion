<?php

defined('ABSPATH') || exit;

/**
 * Main Woo Tabs Accordions Plugin Class
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
        //$this->set_autoloader();
        $this->init_hooks();

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
     * Set autoloader
     *
     * @return void
     */
    private function set_autoloader()
    {

        // MEGA Redirects Autoloader
        require_once WOOT2A_DIR . 'includes/class-autoload.php';

        spl_autoload_register(array(new WooT2A_Autoloader(), 'init'));
    }

    /**
     * Define WooTabsAccordions Constants.
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
     * Hook into actions and filters.
     */
    private function init_hooks()
    {
        //include_once WOOT2A_ABSPATH . 'includes/class-install.php';
        register_activation_hook(__FILE__, array('WooT2A_Install', 'activate'));

        add_action('init', array($this, 'init'), 0);

        register_deactivation_hook(__FILE__, array('WooT2A_Install', 'deactivate'));
    }

    /**
     * Init WooCommerce when WordPress Initialises.
     */
    public function init()
    {
        // Before init action.
        do_action('before_woot2a_init');

        // Set up localisation.
        $this->load_plugin_textdomain();

        // Classes/actions loaded for the frontend and for ajax requests.
        if ($this->is_request('frontend')) {
            //add_action( 'wp_enqueue_scripts',  array( $this, 'enque_scripts' ) );
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

        if (is_textdomain_loaded('woo-tabs-accordions')) {
            return true;
        }

        return load_plugin_textdomain('woo-tabs-accordions', false, WOOT2A_ABSPATH . 'languages');

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
