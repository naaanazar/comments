<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3d5f41ab92d321c2ff632e1a4aeacc1b
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3d5f41ab92d321c2ff632e1a4aeacc1b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3d5f41ab92d321c2ff632e1a4aeacc1b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
