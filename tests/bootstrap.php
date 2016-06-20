<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require dirname(__DIR__) . '/vendor/autoload.php';
/* @var $loader \Composer\Autoload\ClassLoader */
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$_ENV['TMP_DIR'] = __DIR__ . '/tmp';

register_shutdown_function(function () {
    foreach (new \RecursiveDirectoryIterator($_ENV['TMP_DIR'], \FilesystemIterator::SKIP_DOTS) as $file) {
        if ($file->getFilename() !== '.placefolder') {
            @unlink($file);
        }
    }
});
