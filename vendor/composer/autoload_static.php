<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdc1356f5d3a1e04a6c84e0bccc2b831e
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Compado\\Products\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Compado\\Products\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdc1356f5d3a1e04a6c84e0bccc2b831e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdc1356f5d3a1e04a6c84e0bccc2b831e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdc1356f5d3a1e04a6c84e0bccc2b831e::$classMap;

        }, null, ClassLoader::class);
    }
}
