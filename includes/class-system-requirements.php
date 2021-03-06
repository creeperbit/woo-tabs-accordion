<?php

namespace CreeperBit\WooT2A;

defined('ABSPATH') || exit;

/**
 * Class SystemRequirements
 */
class SystemRequirements {
	/**
	 * Wp Minimum Version Required
	 *
	 * @var string The minimum version required for the plugin
	 */
	private static $wp_minimum_version = '4.5';

	/**
	 * Php Minimum Version Required
	 *
	 * @var string The minimum version required by the plugin
	 */
	private static $php_minimum_version = '5.6';

	/**
	 * Mysql Minimum version required by the plugin
	 *
	 * @var string
	 */
	private static $mysql_minimum_version = '5.0';

	/**
	 * Get minimum WordPress required version
	 *
	 * @return string The minimum required version of WordPress
	 */
	public function wp_minimum_version() {

		return self::$wp_minimum_version;
	}

	/**
	 * Get minimum PHP required version
	 *
	 * @return string The minimum version required by the plugin
	 */
	public function php_minimum_version() {

		return self::$php_minimum_version;
	}

	/**
	 * Get minimum MYSQL required version
	 *
	 * @return string The minimum version required by the plugin
	 */
	public function mysql_minimum_version() {

		return self::$mysql_minimum_version;
	}
}
