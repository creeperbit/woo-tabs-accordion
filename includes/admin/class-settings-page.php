<?php

defined('ABSPATH') || exit;

if (class_exists('WooT2A_Settings_Page', false)) {
    return new WooT2A_Settings_Page();
}

/**
 * Class WooT2A_Settings_Page
 */
class WooT2A_Settings_Page extends WC_Settings_Page
{

    /**
     * WooT2A_Settings_Page constructor
     *
     * @param array $settings_views
     * @param array $settings_updaters
     */
    public function __construct()
    {
        $this->id = 'woo-tabs-accordions';
        $this->label = __('Woo Tabs Accordions', 'woo-tabs-accordions');
        add_filter('woocommerce_settings_tabs_array', array($this, 'add_settings_page'), 20);
        add_action('woocommerce_settings_' . $this->id, array($this, 'output'));
        add_action('woocommerce_settings_save_' . $this->id, array($this, 'save'));
    }

    /**
     * Get settings array
     *
     * @return array
     */
    public function get_settings()
    {

        return apply_filters('woocommerce_' . $this->id . '_settings',
            array(
                array(
                    'title' => '',
                    'type' => 'title',
                    'desc' => '',
                    'id' => 'woot2a_title',
                ),
                array(
                    'title' => __('Enable', 'woo-tabs-accordions'),
                    'desc' => __('Enable Accordions.', 'woo-tabs-accordions'),
                    'type' => 'checkbox',
                    'id' => 'woot2a[enabled]',
                    'default' => 'no',
                ),
                array(
                    'title' => __('Choose a theme', 'woo-tabs-accordions'),
                    'desc' => __('Select an accordion theme style.', 'woo-tabs-accordions'),
                    'type' => 'select',
                    'options'  => array(
                        'theme_one'  => __( 'Theme One', 'woo-tabs-accordions' ),
                        'theme_two'   => __( 'Theme Two', 'woo-tabs-accordions' ),
                    ),
                    'id' => 'woot2a[theme]',
                    'default' => 'theme_one',
                ),
                array(
                    'title' => __('Accordion Mode', 'woo-tabs-accordions'),
                    'desc' => __('Expand or collapse accordion option on page load.', 'woo-tabs-accordions'),
                    'type' => 'radio',
                    'options'         => array(
                        'first'     => __( 'First Open', 'woo-tabs-accordions' ),
                        'all'      => __( 'All Open', 'woo-tabs-accordions' ),
                        'folded' => __( 'All Folded', 'woo-tabs-accordions' ),
                    ),
                    'id' => 'woot2a[mode]',
                    'default' => 'first',
                    'desc_tip'        => true,
                ),
                array(
                    'title' => __('Enable Collapsible', 'woo-tabs-accordions'),
                    'desc' => __('Check to open multiple accordions together', 'woo-tabs-accordions'),
                    'type' => 'checkbox',
                    'id' => 'woot2a[multiple_expand]',
                    'default' => 'no',
                ),
                array(
                    'title' => __('Background Color', 'woo-tabs-accordions'),
                    'id' => 'woot2a[bg_color]',
                    'type' => 'color',
                    'default' => '#666666',
                    'css' => 'width: 125px;',
                    'desc_tip' => true,
                ),
                array(
                    'title' => __('Active Background Color', 'woo-tabs-accordions'),
                    'id' => 'woot2a[bg_color_active]',
                    'type' => 'color',
                    'default' => '#000000',
                    'css' => 'width: 125px;',
                    'desc_tip' => true,
                ),
                array(
                    'title' => __('Title Color', 'woo-tabs-accordions'),
                    'id' => 'woot2a[title_color]',
                    'type' => 'color',
                    'default' => '#FFFFFF',
                    'css' => 'width: 125px;',
                    'desc_tip' => true,
                ),
                array(
                    'title' => __('Active Title Color', 'woo-tabs-accordions'),
                    'id' => 'woot2a[title_color_active]',
                    'type' => 'color',
                    'default' => '#FFFFFF',
                    'css' => 'width: 125px;',
                    'desc_tip' => true,
                ),
                array(
                    'title' => __('Arrow Color', 'woo-tabs-accordions'),
                    'id' => 'woot2a[arrow_color]',
                    'type' => 'color',
                    'default' => '#FFFFFF',
                    'css' => 'width: 125px;',
                    'desc_tip' => true,
                ),
                array(
                    'title' => __('Active Arrow Color', 'woo-tabs-accordions'),
                    'id' => 'woot2a[arrow_color_active]',
                    'type' => 'color',
                    'default' => '#FFFFFF',
                    'css' => 'width: 125px;',
                    'desc_tip' => true,
                ),
                array('type' => 'sectionend', 'id' => 'woot2a_options'),

            )); // End pages settings
    }

}

return new WooT2A_Settings_Page();
