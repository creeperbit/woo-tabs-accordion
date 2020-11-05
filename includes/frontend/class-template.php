<?php

namespace CreeperBit\WooT2A\Frontend;

defined('ABSPATH') || exit;

/**
 * Class WooT2A_Template
 */
class WooT2A_Template
{
    /**
     * @var WooT2A_Template
     */
    private static $_instance = null;

    /**
     * Plugin Options for template
     *
     * @var array The template options.
     */
    private $options;

    /**
     *
     * Set needed filters and actions and load all needed
     */
    public function __construct()
    {
        $this->options = get_option('woot2a');

        if ($this->options['enabled'] != 'yes') {
            return;
        }

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

    public function init()
    {
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
        add_action('woocommerce_after_single_product_summary', array($this, 'render'), 10);

        add_filter('woocommerce_product_description_heading', array($this, 'remove_product_description_heading'), 10, 1);
        add_filter('woocommerce_product_additional_information_heading', array($this, 'remove_product_additional_information_heading'), 10, 1);
        add_filter('woocommerce_reviews_title', array($this, 'remove_woocommerce_reviews_title'), 10, 1);

        //Add css and js files for the tabs
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function enqueue_scripts()
    {
        //Add the js and css files only on the product single page.
        if (!is_product()) {
            return;
        }

        $inline_css = ".drawer .accordion-header { background-color:{$this->options['bg_title_color']};}";
        $inline_css .= ".drawer .accordion-item-active .accordion-header { background-color:{$this->options['bg_title_color_active']};}";
        $inline_css .= ".drawer .accordion-header h1 { color:{$this->options['title_color']};}";
        $inline_css .= ".drawer .accordion-item-active .accordion-header h1{ color:{$this->options['title_color_active']};}";
        $inline_css .= ".drawer .accordion-header-icon { color:{$this->options['arrow_color']}; }";
        $inline_css .= ".drawer .accordion-header-icon.accordion-header-icon-active { color:{$this->options['arrow_color_active']};}";

        $firstChildExpand = "false";
        $allChildsOpen = "false";

        switch ($this->options['mode']) {
            case "first":
                $firstChildExpand = "true";
                break;
            case "all":
                $allChildsOpen = "true";
                break;
            default:
                $firstChildExpand = "false";
                $allChildsOpen = "false";
        }

        if ($this->options['multiple_expand'] != 'yes') {
            $multiExpand = "false";
        } else {
            $multiExpand = "true";
        }

        $inline_js = "var woot2a_first_open = {$firstChildExpand};";
        $inline_js .= "var woot2a_all_open = {$allChildsOpen};";
        $inline_js .= "var woot2a_multiple_expand = {$multiExpand};";

        wp_enqueue_style('woot2a-style', WOOT2A_URL . 'assets/css/style.css', '', WOOT2A_PLUGIN_VERSION);
        wp_add_inline_style('woot2a-style', $inline_css);

        wp_enqueue_script('woot2a-accordion', WOOT2A_URL . 'assets/js/accordion.js', array('jquery'), WOOT2A_PLUGIN_VERSION, true);
        wp_add_inline_script('woot2a-accordion', $inline_js);

        wp_enqueue_script('woot2a-main', WOOT2A_URL . 'assets/js/main.js', array('jquery', 'woot2a-accordion'), WOOT2A_PLUGIN_VERSION, true);
    }

    /**
     * Remove woocommerce_product_description_heading from content
     * @return empty
     */
    public function remove_product_description_heading()
    {
        return '';
    }

    /**
     * Remove the woocommerce_product_additional_information_heading from content
     * @return empty
     */
    public function remove_product_additional_information_heading()
    {
        return '';
    }

    /**
     * Remove the remove_woocommerce_reviews_title from content
     * @return empty
     */
    public function remove_woocommerce_reviews_title()
    {
        return '';
    }

    /**
     * Rendering the accordion.
     */
    public function render()
    {
        /**
         * Filter tabs and allow third parties to add their own
         *
         * Each tab is an array containing title, callback and priority.
         * @see woocommerce_default_product_tabs()
         */
        $template_name = $this->options['theme'];

        if (!$template_name) {
            $template_name = 'theme-one';
        }

        $template_name = apply_filters('woot2a_get_template', $template_name);
        $product_tabs = apply_filters('woocommerce_product_tabs', array());

        ob_start();
        include_once WOOT2A_ABSPATH . 'templates/' . sanitize_key($template_name) . '/content.php';
        $html = ob_get_contents();
        ob_end_clean();

        $template_stylesheet = 'templates/' . sanitize_key($template_name) . '/css/style.css';

        if (file_exists(WOOT2A_ABSPATH . $template_stylesheet)) {
            $template_stylesheet_uri = apply_filters('woot2a_get_stylesheet_uri', WOOT2A_URL . $template_stylesheet);
            wp_enqueue_style('woot2a-' . sanitize_key($template_name) . '-style', $template_stylesheet_uri, '', WOOT2A_PLUGIN_VERSION);
        }

        $template_script = apply_filters('woot2a_get_javascript', WOOT2A_ABSPATH . 'templates/' . sanitize_key($template_name) . '/js/script.js');

        if (file_exists($template_script)) {
            ob_start();
            include_once $template_script;
            $script = ob_get_contents();
            ob_end_clean();

            wp_add_inline_script('woot2a-accordion', $script);
        }

        echo apply_filters('woot2a_render_content', $html);
    }

}
