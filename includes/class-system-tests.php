<?php

namespace CreeperBit\WooT2A;

defined('ABSPATH') || exit;

use CreeperBit\WooT2A\SystemRequirements;

/**
 * Class SystemTesting
 */
class SystemTests
{

    /**
     * @var SystemRequirements
     */
    private $requirements;

    /**
     * SystemTesting constructor
     *
     * @param SystemRequirements $requirements The instance of the class.
     */
    public function __construct(SystemRequirements $requirements)
    {

        $this->requirements = $requirements;
    }

    /**
     * Is WordPress compatible
     *
     * @uses version_compare() To compare the versions
     *
     * @return bool True if compatible, false otherwise
     */
    public function is_wp_version_compatible()
    {
        //Get unmodified WP Versions
        require_once ABSPATH . WPINC . '/version.php';
        global $wp_version;

        return version_compare(
            $wp_version,
            $this->requirements->wp_minimum_version(),
            '>='
        );
    }

    /**
     * Is PHP Compatible
     *
     * @uses version_compare() To compare the versions
     *
     * @return bool True if compatible, false otherwise
     */
    public function is_php_version_compatible()
    {

        return version_compare(
            PHP_VERSION,
            $this->requirements->php_minimum_version(),
            '>='
        );
    }

    /**
     * Is MySQL Compatible
     *
     * @uses version_compare() To compare the versions
     *
     * @return bool True if compatible, false otherwise
     */
    public function is_database_compatible()
    {
		global $wpdb;

        $version = $wpdb->db_version();

        return (
            class_exists('mysqli')
            && version_compare($version, $this->requirements->mysql_minimum_version(), '>=')
        );
    }

    /**
     * Test if CURL is supported
     *
     * @return bool True if supported, false otherwise
     */
    public function test_curl_init()
    {

        return function_exists('curl_init');
    }

    /**
     * Check if save mode is active
     *
     * @return bool Return true if active, false otherwise
     */
    public function is_save_mode_activated()
    {

        // @todo `safe_mode` to remove when support for php5.3 will be dropped. For php5.3 the use of `safe_mode` emit a `E_DEPRECATED` but in php5.4 an `E_CORE_ERROR`.
        // phpcs:ignore
        return (bool) ini_get('safe_mode');
    }

    /**
     * Check if woocommerce is active
     *
     * @return bool Return true if active, false otherwise
     */
    public function is_woocommerce_activated()
    {

        return (bool) in_array(
            'woocommerce/woocommerce.php',
            apply_filters('active_plugins', get_option('active_plugins'))
        );
    }

}
