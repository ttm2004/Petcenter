<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitace9b60f79cae87e26db9e98b39a6f45
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitace9b60f79cae87e26db9e98b39a6f45', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitace9b60f79cae87e26db9e98b39a6f45', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitace9b60f79cae87e26db9e98b39a6f45::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
