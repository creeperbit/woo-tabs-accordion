<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9e45468ab571c642589d89dc2964994d
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'CreeperBit\\WooT2A\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'CreeperBit\\WooT2A\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'CreeperBit\\WooT2A\\Install' => __DIR__ . '/../..' . '/includes/class-install.php',
        'CreeperBit\\WooT2A\\SystemRequirements' => __DIR__ . '/../..' . '/includes/class-system-requirements.php',
        'CreeperBit\\WooT2A\\SystemTests' => __DIR__ . '/../..' . '/includes/class-system-tests.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9e45468ab571c642589d89dc2964994d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9e45468ab571c642589d89dc2964994d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9e45468ab571c642589d89dc2964994d::$classMap;

        }, null, ClassLoader::class);
    }
}
