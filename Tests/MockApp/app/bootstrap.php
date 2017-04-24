<?php

$loader = __DIR__.'/../../../vendor/autoload.php';

if (false == is_file($loader)) {
    throw new \LogicException('Could not find autoload.php in vendor/. Did you run "composer install --dev"?');
}

require $loader;

Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
