<?php

namespace CreeperBit\WooT2A;

defined('ABSPATH') || exit;

/**
 * Class for upgrade / deactivation / uninstall
 */
class WooT2A_Install {

	/**
	 * Creates DB und updates settings
	 */
	public static function activate() {}

	/**
	 *
	 * Cleanup on Plugin deactivation
	 *
	 * @return void
	 */
	public static function deactivate() {}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @param mixed $links Plugin Action links.
	 *
	 * @return array
	 */
	public static function plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=creeperbit-woo-accordion' ) . '" aria-label="' . esc_attr__( 'View CreeperBit Accordion Tabs for WooCommerce settings', 'creeperbit-woo-accordion' ) . '">' . esc_html__( 'Settings', 'creeperbit-woo-accordion' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}
}
