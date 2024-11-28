<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitace9b60f79cae87e26db9e98b39a6f45
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Trant\\PetCare\\' => 14,
        ),
        'E' => 
        array (
            'Endroid\\QrCode\\' => 15,
        ),
        'D' => 
        array (
            'DASPRiD\\Enum\\' => 13,
        ),
        'B' => 
        array (
            'BaconQrCode\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Trant\\PetCare\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Endroid\\QrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/endroid/qr-code/src',
        ),
        'DASPRiD\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/dasprid/enum/src',
        ),
        'BaconQrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/bacon/bacon-qr-code/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitace9b60f79cae87e26db9e98b39a6f45::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitace9b60f79cae87e26db9e98b39a6f45::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitace9b60f79cae87e26db9e98b39a6f45::$classMap;

        }, null, ClassLoader::class);
    }
}
