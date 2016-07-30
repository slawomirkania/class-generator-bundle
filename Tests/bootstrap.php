<?php

$autoloadFile = __DIR__.'/../../../../vendor/autoload.php';
if (false == is_file($autoloadFile)) {
    throw new \LogicException('Could not find autoload.php in vendor/. Did you run "composer install --dev"?');
}

require $autoloadFile;
