<?php

require_once __DIR__ . '/../vendor/symfony/class-loader/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->register();

// Look at the path. I spent some time on path thing and '/../' is very different as above '../'.
// Just saying ;)
$loader->registerNamespace('Symfony\\Component\\HttpFoundation', __DIR__.'/../vendor/symfony/http-foundation');