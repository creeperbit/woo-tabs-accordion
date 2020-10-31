<?php

/**
 * Class WooT2A_Autoloader
 */
class WooT2A_Autoloader
{

    const PREFIX = 'WooT2A';

    /**
     * Base Directory for classes
     *
     * @var string The base directory where looking for classes.
     */
    private $base_dir;

    /**
     * WooT2A_Autoloader constructor
     */
    public function __construct()
    {

        $this->base_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;
    }

    /**
     * Plugin Autoloader
     *
     * Include not existing classes automatically
     *
     * @param string $class Class to load from file.
     *
     * @return void
     */
    public function init($class)
    {

        if (class_exists($class_name)) {
            return;
        }

        if (false === strpos($class_name, self::PREFIX)) {
            return;
        }

        $class_name = str_replace(self::PREFIX, '', $class_name);
        $classes_dir = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;
        $class_file = str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';

        if (file_exists($classes_dir . $class_file)) {
            require_once $classes_dir . $class_file;
        }
    }
}
