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
        $this->id = 'creeperbit-woo-accordion';
        $this->label = __('Accordion Tabs', 'creeperbit-woo-accordion');
        $this->init_hooks();
        $this->enable_alpha_channel_wp_color_picker();
    }

    public function init_hooks()
    {
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
                    'title' => __('Enable', 'creeperbit-woo-accordion'),
                    'desc' => __('Enable Accordion.', 'creeperbit-woo-accordion'),
                    'type' => 'checkbox',
                    'id' => 'woot2a[enabled]',
                    'default' => 'no',
                ),
                array(
                    'title' => __('Choose a theme', 'creeperbit-woo-accordion'),
                    'desc' => __('Select an accordion theme style.', 'creeperbit-woo-accordion'),
                    'type' => 'select',
                    'options' => array(
                        'theme-one' => __('Theme One', 'creeperbit-woo-accordion'),
                        'theme-two' => __('Theme Two', 'creeperbit-woo-accordion'),
                    ),
                    'id' => 'woot2a[theme]',
                    'default' => 'theme-one',
                ),
                array(
                    'title' => __('Accordion Mode', 'creeperbit-woo-accordion'),
                    'desc' => __('Expand or collapse accordion option on page load.', 'creeperbit-woo-accordion'),
                    'type' => 'radio',
                    'options' => array(
                        'first' => __('First Open', 'creeperbit-woo-accordion'),
                        'all' => __('All Open', 'creeperbit-woo-accordion'),
                        'folded' => __('All Folded', 'creeperbit-woo-accordion'),
                    ),
                    'id' => 'woot2a[mode]',
                    'default' => 'first',
                    'desc_tip' => true,
                ),
                array(
                    'title' => __('Enable Collapsible', 'creeperbit-woo-accordion'),
                    'desc' => __('Check to open multiple accordions together', 'creeperbit-woo-accordion'),
                    'type' => 'checkbox',
                    'id' => 'woot2a[multiple_expand]',
                    'default' => 'no',
                ),
                array(
                    'title' => __('Title Background Color', 'creeperbit-woo-accordion'),
                    'id' => 'woot2a[bg_title_color]',
                    'type' => 'text',
                    'default' => '#666666',
                    'class' => 'color-picker',
                    'custom_attributes' => array(
                        'data-alpha-enabled' => 'true'
                    ),
                    'css' => 'width: 25px;',
                    'desc_tip' => true,
                ),
                array(
                    'title' => __('Active Title Background Color', 'creeperbit-woo-accordion'),
                    'id' => 'woot2a[bg_title_color_active]',
                    'type' => 'text',
                    'default' => '#000000',
                    'class' => 'color-picker',
                    'custom_attributes' => array(
                        'data-alpha-enabled' => 'true'
                    ),
                    'css' => 'width: 25px;',
                    'desc_tip' => true,
                ),
                array(
                    'title' => __('Title Color', 'creeperbit-woo-accordion'),
                    'id' => 'woot2a[title_color]',
                    'type' => 'text',
                    'default' => '#fff',
                    'class' => 'color-picker',
                    'custom_attributes' => array(
                        'data-alpha-enabled' => 'true'
                    ),
                    'css' => 'width: 25px;',
                    'desc_tip' => true,
                ),
                array(
                    'title' => __('Active Title Color', 'creeperbit-woo-accordion'),
                    'id' => 'woot2a[title_color_active]',
                    'type' => 'text',
                    'default' => '#fff',
                    'class' => 'color-picker',
                    'custom_attributes' => array(
                        'data-alpha-enabled' => 'true'
                    ),
                    'css' => 'width: 25px;',
                    'desc_tip' => true,
                ),
                array(
                    'title' => __('Arrow Color', 'creeperbit-woo-accordion'),
                    'id' => 'woot2a[arrow_color]',
                    'type' => 'text',
                    'default' => '#fff',
                    'class' => 'color-picker',
                    'custom_attributes' => array(
                        'data-alpha-enabled' => 'true'
                    ),
                    'css' => 'width: 25px;',
                    'desc_tip' => true,
                ),
                array(
                    'title' => __('Active Arrow Color', 'creeperbit-woo-accordion'),
                    'id' => 'woot2a[arrow_color_active]',
                    'type' => 'text',
                    'default' => '#fff',
                    'class' => 'color-picker',
                    'custom_attributes' => array(
                        'data-alpha-enabled' => 'true'
                    ),
                    'css' => 'width: 25px;',
                    'desc_tip' => true,
                ),
                array('type' => 'sectionend', 'id' => 'woot2a_options'),

            )); // End pages settings
    }

    /**
     * Overwrite Automattic Iris for enabled Alpha Channel in wpColorPicker
     */
    public function enable_alpha_channel_wp_color_picker()
    {
        wp_enqueue_style('wp-color-picker');
        wp_register_script('wp-color-picker-alpha', WOOT2A_URL . 'assets/js/wp-color-picker-alpha.js', array('wp-color-picker'), WOOT2A_PLUGIN_VERSION, true); 
        wp_add_inline_script(
            'wp-color-picker-alpha',
            'jQuery( function() { jQuery( ".color-picker" ).wpColorPicker(); } );'
        );
        wp_enqueue_script('wp-color-picker-alpha');
    }

}

return new WooT2A_Settings_Page();
